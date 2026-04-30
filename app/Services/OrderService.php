<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ArtisanGood;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * Create an order from a cart
     */
    public function createOrderFromCart(Cart $cart, array $data): Order
    {
        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($cart->items as $item) {
                $subtotal += $item->price * $item->quantity;
            }

            $serviceFee = round($subtotal * 0.10, 2);
            $total = $subtotal + $serviceFee;

            // Determine order type
            $itemTypes = $cart->items->pluck('item_type')->unique();
            $orderType = $itemTypes->count() === 1 ? $itemTypes->first() : 'service';

            // Create order
            $order = Order::create([
                'client_id' => Auth::id(),
                'artisan_id' => $cart->artisan_id,
                'order_type' => $orderType,
                'total_amount' => $total,
                'amount' => $total,
                'service_fee' => $serviceFee,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_address' => $data['shipping_address'] ?? null,
                'billing_address' => $data['billing_address'] ?? null,
                'payment_method' => 'paynow',
            ]);

            // Create order items
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $cartItem->item_type,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);

                // Decrease stock for products
                if ($cartItem->item_type === 'product') {
                    $product = ArtisanGood::find($cartItem->item_id);
                    if ($product) {
                        // Check if enough stock
                        if ($product->stock_quantity < $cartItem->quantity) {
                            throw new \Exception("Insufficient stock for {$product->product_name}");
                        }
                        $product->decrement('stock_quantity', $cartItem->quantity);
                    }
                }
            }

            // Clear cart
            $cart->delete();

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cancel an order and restore stock
     */
    public function cancelOrder(Order $order): bool
    {
        if (!in_array($order->status, ['pending', 'paid'])) {
            return false;
        }

        DB::beginTransaction();
        try {
            // Restore stock for products
            foreach ($order->items as $item) {
                if ($item->item_type === 'product') {
                    $product = ArtisanGood::find($item->item_id);
                    if ($product) {
                        $product->increment('stock_quantity', $item->quantity);
                    }
                }
            }

            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded'
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Mark order as paid (called from payment webhook)
     */
    public function markOrderAsPaid(Order $order): bool
    {
        return $order->update([
            'status' => 'paid',
            'payment_status' => 'paid'
        ]);
    }

    /**
     * Get order with all relationships
     */
    public function getOrderWithDetails(int $orderId)
    {
        return Order::with([
            'items.artisanService',
            'items.artisanGood',
            'artisan.user',
            'client'
        ])->find($orderId);
    }
}
