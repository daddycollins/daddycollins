<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SystemLog;
use App\Mail\PaymentReceipt;
use App\Mail\PaymentFailed;
use App\Mail\PaymentCancelled;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        // Validate credentials are provided
        if (empty($integrationId)) {
            throw new \Exception('PayNow Integration ID is not configured for this provider');
        }

        if (empty($integrationKey)) {
            throw new \Exception('PayNow Integration Key is not configured for this provider');
        }

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
     * Validate if a provider can accept payments
     */
    public function validateProviderPayment($artisanId): array
    {
        try {
            $artisan = \App\Models\ArtisanProfile::with('paynow')->find($artisanId);

            if (!$artisan) {
                return [
                    'valid' => false,
                    'message' => 'Provider not found',
                ];
            }

            if (!$artisan->paynow) {
                return [
                    'valid' => false,
                    'message' => 'Provider has not configured payment methods',
                ];
            }

            if ($artisan->paynow->status !== 'active') {
                return [
                    'valid' => false,
                    'message' => 'Provider\'s payment account is not active',
                ];
            }

            if (!$artisan->verified) {
                return [
                    'valid' => false,
                    'message' => 'Provider account is not verified for payments',
                ];
            }

            return [
                'valid' => true,
                'message' => 'Provider is ready to accept payments',
            ];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Initiate a payment for an order
     */
    public function initiatePayment(Order $order, string $phone): array
    {
        try {
            $artisan = $order->artisan()->with('paynow')->first();

            if (!$artisan) {
                throw new \Exception('Artisan not found for order');
            }

            if (!$artisan->paynow) {
                throw new \Exception('Artisan has not configured a PayNow payment account');
            }

            // Validate PayNow credentials are set
            $integrationId = $artisan->paynow->paynow_integration_id;
            $integrationKey = $artisan->paynow->paynow_integration_key;

            // Log retrieved credentials for debugging
            Log::info('PayNow payment attempt', [
                'artisan_id' => $artisan->id,
                'artisan_name' => $artisan->business_name,
                'integration_id_set' => !empty($integrationId),
                'integration_key_set' => !empty($integrationKey),
                'integration_id_length' => strlen($integrationId ?? ''),
                'integration_key_length' => strlen($integrationKey ?? ''),
            ]);

            if (empty($integrationId)) {
                throw new \Exception('PayNow Integration ID is missing for this provider. Please contact the provider to complete their payment setup.');
            }

            if (empty($integrationKey)) {
                throw new \Exception('PayNow Integration Key is missing for this provider. Please contact the provider to complete their payment setup.');
            }

            // Validate PayNow account is active
            if ($artisan->paynow->status !== 'active') {
                throw new \Exception('This provider\'s payment account is not active. Please contact the provider.');
            }

            // Initialize Paynow with artisan's credentials
            $this->initializePaynow(
                $integrationId,
                $integrationKey,
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

            // Add service fee if any
            if ($order->service_fee > 0) {
                $payment->add('Service Fee', $order->service_fee);
            }

            // Send mobile payment
            $response = $this->paynow->sendMobile(
                $payment,
                $phone,
                'ecocash' // Default to EcoCash, can be 'onemoney' or other methods
            );

            if ($response->success()) {
                // Get reference from response data
                $responseData = $response->data();
                $reference = $responseData['reference'] ?? $responseData['transactionid'] ?? 'N/A';

                // Update order with Paynow references
                $order->update([
                    'paynow_poll_url' => $response->pollUrl(),
                    'paynow_reference' => $reference,
                ]);

                // Log transaction
                SystemLog::create([
                    'user_id' => $order->client_id,
                    'action' => 'Payment initiated for order #' . $order->id . '. Paynow reference: ' . $reference,
                    'ip_address' => request()->ip(),
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $response->redirectUrl(),
                    'poll_url' => $response->pollUrl(),
                    'reference' => $reference
                ];
            } else {
                // Get error from response data
                $responseData = $response->data();
                $errorMsg = $responseData['error'] ?? 'Payment initiation failed';
                throw new \Exception($errorMsg);
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

                // Send confirmation emails
                try {
                    // Send to client
                    Mail::to($order->client->email)->send(new PaymentReceipt($order, 'client'));

                    // Send to artisan
                    Mail::to($order->artisan->user->email)->send(new PaymentReceipt($order, 'artisan'));

                    Log::info('Payment confirmation emails sent for order #' . $order->id);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment confirmation emails: ' . $e->getMessage());
                    // Don't fail the webhook processing just because email failed
                }

            } elseif ($status === 'Cancelled') {
                $order->update([
                    'payment_status' => 'cancelled',
                    'status' => 'cancelled'
                ]);

                // Restore stock for any products
                $this->restoreOrderStock($order);

                Log::info('Payment cancelled for order #' . $order->id, ['reference' => $reference]);

                // Send cancellation emails
                try {
                    Mail::to($order->client->email)->send(new PaymentCancelled($order, 'client'));
                    Mail::to($order->artisan->user->email)->send(new PaymentCancelled($order, 'artisan'));

                    Log::info('Payment cancellation emails sent for order #' . $order->id);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment cancellation emails: ' . $e->getMessage());
                }

            } elseif ($status === 'Failed') {
                $order->update([
                    'payment_status' => 'failed'
                ]);

                // Restore stock for any products
                $this->restoreOrderStock($order);

                Log::warning('Payment failed for order #' . $order->id, ['reference' => $reference]);

                // Send failure emails
                try {
                    Mail::to($order->client->email)->send(new PaymentFailed($order, 'Payment processing failed. Please try again.', 'client'));
                    Mail::to($order->artisan->user->email)->send(new PaymentFailed($order, 'Payment processing failed. Please try again.', 'artisan'));

                    Log::info('Payment failure emails sent for order #' . $order->id);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment failure emails: ' . $e->getMessage());
                }
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

    /**
     * Restore stock for products in a cancelled/failed order
     */
    private function restoreOrderStock(Order $order): void
    {
        try {
            $order->items()->each(function ($item) {
                if ($item->item_type === 'product') {
                    // Get the product
                    $product = \App\Models\ArtisanGood::find($item->item_id);
                    if ($product) {
                        $product->increment('stock_quantity', $item->quantity);
                        Log::info('Stock restored for product #' . $item->item_id . ' - quantity: ' . $item->quantity);
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed to restore stock for order #' . $order->id . ': ' . $e->getMessage());
        }
    }
}
