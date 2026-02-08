<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SystemLog;
use Illuminate\Support\Facades\Log;

/**
 * PaynowService - Handles Paynow payment integration
 *
 * NOTE: This service requires the paynow/php-sdk package to be installed.
 * Run: composer require paynow/php-sdk
 *
 * This service will work once the SDK is installed.
 */
class PaynowService
{
    protected $paynow;

    /**
     * Initialize Paynow with artisan's credentials
     */
    private function initializePaynow(string $integrationId, string $integrationKey, int $orderId)
    {
        // Check if Paynow class exists (SDK installed)
        if (!class_exists('\Paynow\Payments\Paynow')) {
            throw new \Exception('Paynow SDK not installed. Run: composer require paynow/php-sdk');
        }

        $this->paynow = new \Paynow\Payments\Paynow(
            $integrationId,
            $integrationKey,
            config('paynow.result_url'),
            config('paynow.return_url') . '/' . $orderId
        );

        // Set to sandbox mode if configured
        if (config('paynow.mode') === 'sandbox') {
            $this->paynow->setResultUrl(config('paynow.result_url'));
            $this->paynow->setReturnUrl(config('paynow.return_url') . '/' . $orderId);
        }
    }

    /**
     * Initiate a payment for an order
     */
    public function initiatePayment(Order $order, string $phone): array
    {
        try {
            $artisan = $order->artisan()->with('paynow')->first();

            if (!$artisan || !$artisan->paynow) {
                throw new \Exception('Artisan payment account not configured');
            }

            // Initialize Paynow with artisan's credentials
            $this->initializePaynow(
                $artisan->paynow->paynow_integration_id,
                $artisan->paynow->paynow_integration_key,
                $order->id
            );

            // Create payment
            $payment = $this->paynow->createPayment(
                "Order #" . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                $order->client->email
            );

            // Add items to payment
            foreach ($order->items as $item) {
                $itemName = $item->item_type === 'service'
                    ? ($item->artisanService ? $item->artisanService->service_name : 'Service')
                    : ($item->artisanGood ? $item->artisanGood->product_name : 'Product');

                $payment->add(
                    $itemName,
                    $item->price * $item->quantity
                );
            }

            // Add service fee
            $payment->add('Service Fee', $order->service_fee ?? 0);

            // Send mobile payment
            $response = $this->paynow->sendMobile(
                $payment,
                $phone,
                'ecocash' // Default to EcoCash, can be 'onemoney' or other methods
            );

            if ($response->success()) {
                // Update order with Paynow references
                $order->update([
                    'paynow_poll_url' => $response->pollUrl(),
                    'paynow_reference' => $response->reference(),
                ]);

                // Log transaction
                SystemLog::create([
                    'user_id' => $order->client_id,
                    'action' => 'Payment initiated for order #' . $order->id . '. Paynow reference: ' . $response->reference(),
                    'ip_address' => request()->ip(),
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $response->redirectUrl(),
                    'poll_url' => $response->pollUrl(),
                    'reference' => $response->reference()
                ];
            } else {
                throw new \Exception($response->errors());
            }
        } catch (\Exception $e) {
            Log::error('Paynow payment initiation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Check payment status by polling Paynow
     */
    public function checkPaymentStatus(Order $order): array
    {
        try {
            if (!$order->paynow_poll_url) {
                throw new \Exception('No payment reference found');
            }

            $artisan = $order->artisan()->with('paynow')->first();

            $this->initializePaynow(
                $artisan->paynow->paynow_integration_id,
                $artisan->paynow->paynow_integration_key,
                $order->id
            );

            $status = $this->paynow->pollTransaction($order->paynow_poll_url);

            return [
                'success' => true,
                'paid' => $status->paid(),
                'status' => $status->status(),
                'amount' => $status->amount(),
                'reference' => $status->reference()
            ];
        } catch (\Exception $e) {
            Log::error('Paynow status check failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Process webhook payment notification from Paynow
     */
    public function processWebhookPayment(array $data): bool
    {
        try {
            $reference = $data['paynowreference'] ?? null;
            $status = $data['status'] ?? null;

            if (!$reference) {
                throw new \Exception('Missing payment reference');
            }

            // Find order by reference
            $order = Order::where('paynow_reference', $reference)->first();

            if (!$order) {
                Log::warning('Webhook received for unknown order reference: ' . $reference);
                throw new \Exception('Order not found');
            }

            // Update order based on payment status
            if ($status === 'Paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'paid'
                ]);

                // Log payment confirmation
                SystemLog::create([
                    'user_id' => $order->client_id,
                    'action' => 'Payment confirmed for order #' . $order->id . '. Amount: $' . $order->total_amount,
                    'ip_address' => request()->ip(),
                ]);

                Log::info('Payment confirmed for order #' . $order->id, ['reference' => $reference]);

                // TODO: Send confirmation email to client
                // TODO: Send notification email to artisan

            } elseif ($status === 'Cancelled') {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);

                Log::info('Payment cancelled for order #' . $order->id, ['reference' => $reference]);

            } elseif ($status === 'Failed') {
                $order->update([
                    'payment_status' => 'failed'
                ]);

                Log::warning('Payment failed for order #' . $order->id, ['reference' => $reference]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'data' => $data,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
