<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $carts = $this->cartService->getCart();

        // Calculate totals for each cart (grouped by artisan)
        $cartTotals = [];
        foreach ($carts as $cart) {
            $cartTotals[$cart->id] = $this->cartService->calculateCartTotal($cart->id);
        }

        return view('content.apps.cart', compact('carts', 'cartTotals'));
    }

    /**
     * Add item to cart
     */
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'artisan_id' => 'required|exists:artisan_profiles,id',
            'item_type' => 'required|in:service,product',
            'item_id' => 'required|integer',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:500'
        ]);

        $result = $this->cartService->addItem(
            $validated['artisan_id'],
            $validated['item_type'],
            $validated['item_id'],
            $validated['quantity'] ?? 1,
            $validated['notes'] ?? null
        );

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(CartItem $cartItem, Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Verify ownership
        if ($cartItem->cart->client_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        $success = $this->cartService->updateQuantity($cartItem->id, $validated['quantity']);

        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Quantity updated successfully' : 'Could not update quantity. Stock limit may have been reached.'
        );
    }

    /**
     * Remove item from cart
     */
    public function removeItem(CartItem $cartItem)
    {
        // Verify ownership
        if ($cartItem->cart->client_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        $success = $this->cartService->removeItem($cartItem->id);

        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Item removed from cart' : 'Could not remove item'
        );
    }

    /**
     * Clear entire cart
     */
    public function clearCart(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        $success = $this->cartService->clearCart($validated['cart_id']);

        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Cart cleared successfully' : 'Could not clear cart'
        );
    }

    /**
     * Get cart count (for AJAX requests)
     */
    public function getCartCount()
    {
        return response()->json([
            'count' => $this->cartService->getCartItemCount()
        ]);
    }
}
