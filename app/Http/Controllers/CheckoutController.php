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

            // Store order reference in session for fallback if Paynow redirect fails
            session([
                'last_order_id' => $order->id,
                'last_order_reference' => $order->paynow_reference ?? $order->id,
                'last_order_timestamp' => now()->timestamp
            ]);

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
     * Handles generic redirects from Paynow (which may not include order ID)
     */
    public function success(Request $request, Order $order = null)
    {
        // Try multiple ways to locate the order

        // 1. If order ID is provided via route binding
        if ($order) {
            $order = $order;
        }
        // 2. Try to get from query string parameter
        elseif ($request->query('order_id')) {
            $order = Order::find($request->query('order_id'));
        }
        // 3. Try to get from query string reference (Paynow reference)
        elseif ($request->query('reference')) {
            $order = Order::where('paynow_reference', $request->query('reference'))->first();
        }
        // 4. Fall back to session-stored order (when generic redirect with no params)
        elseif (session('last_order_id') && session('last_order_timestamp')) {
            // Only use session if it's recent (within 15 minutes)
            if (now()->timestamp - session('last_order_timestamp') < 900) {
                $order = Order::find(session('last_order_id'));
            }
        }

        // If no order found through any method
        if (!isset($order) || !$order) {
            return redirect()->route('user-my-orders')
                ->with('error', 'Order not found. Please check your orders list.');
        }

        // Verify ownership
        if ($order->client_id !== auth()->id()) {
            return redirect()->route('user-my-orders')->with('error', 'Unauthorized');
        }

        $order->load(['items.artisanService', 'items.artisanGood', 'artisan.user']);

        // Clear session data after use
        session()->forget(['last_order_id', 'last_order_reference', 'last_order_timestamp']);

        return view('content.apps.order-success', compact('order'));
    }
}
