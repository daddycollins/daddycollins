<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ArtisanService;
use App\Models\ArtisanGood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Add an item to the cart
     */
    public function addItem(int $artisanId, string $itemType, int $itemId, int $quantity = 1, ?string $notes = null): array
    {
        DB::beginTransaction();
        try {
            // Check if user already has a cart with a different artisan
            $existingCart = Cart::where('client_id', Auth::id())
                ->where('artisan_id', '!=', $artisanId)
                ->first();

            if ($existingCart) {
                return [
                    'success' => false,
                    'message' => 'You can only order from one artisan at a time. Please complete your current cart or clear it first.'
                ];
            }

            // Get or create cart for this client-artisan pair
            $cart = Cart::firstOrCreate([
                'client_id' => Auth::id(),
                'artisan_id' => $artisanId
            ]);

            // Get item details and validate
            $item = $this->getItem($itemType, $itemId);
            if (!$item) {
                throw new \Exception('Item not found');
            }

            // Validate availability
            if ($item->availability !== 'available') {
                throw new \Exception('This item is currently unavailable');
            }

            // Validate stock for products
            if ($itemType === 'product') {
                if ($item->stock_quantity < $quantity) {
                    throw new \Exception('Insufficient stock. Only ' . $item->stock_quantity . ' available.');
                }

                // Check if item already in cart
                $existingCartItem = CartItem::where('cart_id', $cart->id)
                    ->where('item_type', $itemType)
                    ->where('item_id', $itemId)
                    ->first();

                if ($existingCartItem) {
                    $newQuantity = $existingCartItem->quantity + $quantity;
                    if ($newQuantity > $item->stock_quantity) {
                        throw new \Exception('Cannot add more. Stock limit is ' . $item->stock_quantity);
                    }
                }
            }

            // Get price
            $price = $itemType === 'service' ? $item->price_estimate : $item->price;

            // Add or update cart item
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('item_type', $itemType)
                ->where('item_id', $itemId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'item_type' => $itemType,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'notes' => $notes
                ]);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cartCount' => $this->getCartItemCount()
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get cart(s) for current user
     */
    public function getCart(?int $artisanId = null)
    {
        $query = Cart::where('client_id', Auth::id())
            ->with([
                'items' => function ($q) {
                    $q->with(['artisanService', 'artisanGood']);
                },
                'artisan.user',
                'artisan.paynow'
            ]);

        if ($artisanId) {
            $query->where('artisan_id', $artisanId);
        }

        return $query->get();
    }

    /**
     * Get total count of items in cart
     */
    public function getCartItemCount(): int
    {
        return CartItem::whereHas('cart', function ($q) {
            $q->where('client_id', Auth::id());
        })->sum('quantity');
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(int $cartItemId, int $quantity): bool
    {
        $cartItem = CartItem::whereHas('cart', function ($q) {
            $q->where('client_id', Auth::id());
        })->find($cartItemId);

        if (!$cartItem) {
            return false;
        }

        // Validate stock for products
        if ($cartItem->item_type === 'product') {
            $product = ArtisanGood::find($cartItem->item_id);
            if ($product && $quantity > $product->stock_quantity) {
                return false;
            }
        }

        $cartItem->quantity = $quantity;
        return $cartItem->save();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $cartItemId): bool
    {
        $cartItem = CartItem::whereHas('cart', function ($q) {
            $q->where('client_id', Auth::id());
        })->find($cartItemId);

        if (!$cartItem) {
            return false;
        }

        $cartItem->delete();

        // If cart is now empty, delete the cart
        $cart = Cart::find($cartItem->cart_id);
        if ($cart && $cart->items()->count() === 0) {
            $cart->delete();
        }

        return true;
    }

    /**
     * Clear entire cart
     */
    public function clearCart(int $cartId): bool
    {
        $cart = Cart::where('id', $cartId)
            ->where('client_id', Auth::id())
            ->first();

        if ($cart) {
            $cart->delete();
            return true;
        }

        return false;
    }

    /**
     * Calculate cart totals
     */
    public function calculateCartTotal(int $cartId): array
    {
        $cart = Cart::with('items')->find($cartId);

        if (!$cart) {
            return [
                'subtotal' => 0,
                'service_fee' => 0,
                'total' => 0
            ];
        }

        $subtotal = 0;
        foreach ($cart->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        // Calculate service fee (10% platform fee)
        $serviceFee = round($subtotal * 0.10, 2);

        $total = $subtotal + $serviceFee;

        return [
            'subtotal' => $subtotal,
            'service_fee' => $serviceFee,
            'total' => $total
        ];
    }

    /**
     * Get item (service or product)
     */
    private function getItem(string $type, int $id)
    {
        return $type === 'service'
            ? ArtisanService::find($id)
            : ArtisanGood::find($id);
    }
}
