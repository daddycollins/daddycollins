<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaynowService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $paynowService;

    public function __construct(
        CartService $cartService,
        OrderService $orderService,
        PaynowService $paynowService
    ) {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->paynowService = $paynowService;
    }

    /**
     * Show checkout page
     */
    public function show(Cart $cart)
    {
        // Verify ownership
        if ($cart->client_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized');
        }

        $cart->load(['items.artisanService', 'items.artisanGood', 'artisan.user', 'artisan.paynow']);

        // Check if artisan has Paynow account
        if (!$cart->artisan->paynow) {
            return redirect()->route('cart.index')
                ->with('error', 'This artisan has not set up payment processing yet. Please contact them directly.');
        }

        $totals = $this->cartService->calculateCartTotal($cart->id);

        return view('content.apps.checkout', compact('cart', 'totals'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Cart $cart, Request $request)
    {
        // Verify ownership
        if ($cart->client_id !== auth()->id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'shipping_address' => 'required|string|max:500',
            'billing_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
        ]);

        try {
            // Create order
            $order = $this->orderService->createOrderFromCart($cart, $validated);

            // Initiate Paynow payment
            $paymentResult = $this->paynowService->initiatePayment($order, $validated['phone']);

            if ($paymentResult['success']) {
                // Redirect to Paynow payment gateway
                return redirect($paymentResult['redirect_url']);
            } else {
                // Payment initiation failed - cancel order and restore stock
                $this->orderService->cancelOrder($order);

                return back()->with('error', 'Payment initiation failed: ' . $paymentResult['message']);
            }

        } catch (\Exception $e) {
            // If order was created, cancel it
            if (isset($order)) {
                $this->orderService->cancelOrder($order);
            }

            return back()->with('error', 'Order creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Show order success page
     */
    public function success(Order $order)
    {
        // Verify ownership
        if ($order->client_id !== auth()->id()) {
            return redirect()->route('user-my-orders')->with('error', 'Unauthorized');
        }

        $order->load(['items.artisanService', 'items.artisanGood', 'artisan.user']);

        return view('content.apps.order-success', compact('order'));
    }
}
