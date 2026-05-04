<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ArtisanGood;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\ArtisanService;
use App\Services\OrderService;
use App\Services\PaynowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
  protected $paynowService;
  protected $orderService;

  public function __construct(PaynowService $paynowService, OrderService $orderService)
  {
    $this->paynowService = $paynowService;
    $this->orderService = $orderService;
  }

  /**
   * Show direct checkout page for a single item
   */
  public function showCheckout(Request $request)
  {
    $itemType = $request->query('type'); // 'service' or 'product'
    $itemId = $request->query('item_id');
    $artisanId = $request->query('artisan_id');
    $quantity = $request->query('quantity', 1);

    // Validate input
    if (!in_array($itemType, ['service', 'product']) || !$itemId || !$artisanId) {
      return redirect()->back()->with('error', 'Invalid product or service');
    }

    // Get artisan
    $artisan = ArtisanProfile::findOrFail($artisanId);

    // Get the item
    if ($itemType === 'service') {
      $item = ArtisanService::findOrFail($itemId);
      $price = $item->price_estimate;
      $name = $item->service_name;
    } else {
      $item = ArtisanGood::findOrFail($itemId);
      $price = $item->price;
      $name = $item->product_name;

      // Check stock
      if ($item->stock_quantity < $quantity) {
        return redirect()->back()->with('error', 'Insufficient stock available');
      }
    }

    // Calculate totals
    $subtotal = $price * $quantity;
    $serviceFee = round($subtotal * 0.10, 2);
    $total = $subtotal + $serviceFee;

    return view('payment.checkout', [
      'item' => $item,
      'itemType' => $itemType,
      'artisan' => $artisan,
      'quantity' => $quantity,
      'price' => $price,
      'subtotal' => $subtotal,
      'serviceFee' => $serviceFee,
      'total' => $total,
    ]);
  }

  /**
   * Process direct checkout and initiate payment
   */
  public function processCheckout(Request $request)
  {
    // Check authentication
    if (!auth()->check()) {
      return redirect()->route('login')->with('error', 'Please log in to proceed with payment');
    }

    $validated = $request->validate([
      'item_type' => 'required|in:service,product',
      'item_id' => 'required|integer',
      'artisan_id' => 'required|integer',
      'quantity' => 'required|integer|min:1',
      'phone' => 'required|string|min:7',
      'shipping_address' => 'nullable|string',
    ], [
      'phone.required' => 'Phone number is required',
      'phone.min' => 'Please enter a valid phone number',
    ]);

    try {
      DB::beginTransaction();

      // Get artisan and item
      $artisan = ArtisanProfile::findOrFail($validated['artisan_id']);

      // Validate provider has PayNow account
      if (!$artisan->paynow || $artisan->paynow->status !== 'active') {
        return redirect()->back()->with('error', 'This provider cannot accept online payments at this time');
      }

      // Get the item and create order
      if ($validated['item_type'] === 'service') {
        $item = ArtisanService::findOrFail($validated['item_id']);
        $price = $item->price_estimate;
        $subtotal = $price * $validated['quantity'];
      } else {
        $item = ArtisanGood::findOrFail($validated['item_id']);
        $price = $item->price;
        $subtotal = $price * $validated['quantity'];

        // Check and decrement stock
        if ($item->stock_quantity < $validated['quantity']) {
          throw new \Exception('Insufficient stock for this product');
        }
        $item->decrement('stock_quantity', $validated['quantity']);
      }

      // Calculate totals
      $serviceFee = round($subtotal * 0.10, 2);
      $total = $subtotal + $serviceFee;

      // Create order with authenticated user
      $order = Order::create([
        'client_id' => auth()->id(),
        'artisan_id' => $artisan->id,
        'order_type' => $validated['item_type'],
        'order_source' => 'direct_payment',
        'amount' => $subtotal,
        'service_fee' => $serviceFee,
        'total_amount' => $total,
        'payment_status' => 'unpaid',
        'status' => 'pending',
        'shipping_address' => $validated['shipping_address'] ?? '',
        'payment_method' => 'paynow',
      ]);

      if (!$order) {
        throw new \Exception('Failed to create order');
      }

      // Create order item
      $order->items()->create([
        'item_type' => $validated['item_type'],
        'item_id' => $validated['item_id'],
        'quantity' => $validated['quantity'],
        'price' => $price,
      ]);

      // Initiate payment
      $response = $this->paynowService->initiatePayment($order, $validated['phone']);

      if (!$response['success']) {
        throw new \Exception('Failed to initiate payment: ' . ($response['error'] ?? 'Unknown error'));
      }

      DB::commit();

      // Redirect to payment status page
      return redirect()->route('payment.status', $order->id);
    } catch (\Exception $e) {
      DB::rollBack();

      // Restore stock if product was decremented
      if (isset($item) && $validated['item_type'] === 'product') {
        $item->increment('stock_quantity', $validated['quantity']);
      }

      Log::error('Payment checkout error: ' . $e->getMessage(), [
        'user_id' => auth()->id(),
        'item_type' => $validated['item_type'] ?? null,
        'item_id' => $validated['item_id'] ?? null,
      ]);

      return redirect()->back()->withInput()->with('error', 'Checkout error: ' . $e->getMessage());
    }
  }

  /**
   * Show payment status page with polling
   */
  public function paymentStatus(Order $order)
  {
    // Authorize: user must be either the client or artisan
    if (auth()->id() !== $order->client_id && auth()->id() !== $order->artisan->user_id) {
      abort(403);
    }

    return view('payment.status', [
      'order' => $order->load('items', 'artisan.user', 'client'),
    ]);
  }

  /**
   * API endpoint to check payment status (for AJAX polling)
   */
  public function checkPaymentStatus(Order $order)
  {
    // Authorize: user must be either the client or artisan
    if (auth()->id() !== $order->client_id && auth()->id() !== $order->artisan->user_id) {
      return response()->json(['error' => 'Unauthorized'], 403);
    }

    if ($order->payment_status === 'paid') {
      return response()->json([
        'status' => 'paid',
        'message' => 'Payment successful',
        'redirect' => route('payment.success', $order->id),
      ]);
    }

    try {
      $response = $this->paynowService->checkPaymentStatus($order);

      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Show payment success page
   */
  public function paymentSuccess(Order $order)
  {
    // Authorize: user must be either the client or artisan
    if (auth()->id() !== $order->client_id && auth()->id() !== $order->artisan->user_id) {
      abort(403);
    }

    if ($order->payment_status !== 'paid') {
      return redirect()->route('payment.status', $order->id);
    }

    return view('payment.success', [
      'order' => $order->load('items', 'artisan.user', 'client'),
      'items' => $order->items,
    ]);
  }

  /**
   * Refresh payment status for an order (API endpoint)
   */
  public function refreshPaymentStatus(Order $order)
  {
    // Check if user is authorized to view this order
    if (Auth::id() !== $order->client_id && Auth::user()->role !== 'admin') {
      return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    try {
      // Check payment status from Paynow
      $paynowStatus = $this->paynowService->checkPaymentStatus($order);

      // If payment is confirmed as paid but order still shows unpaid, update it
      if ($paynowStatus['paid'] && $order->payment_status !== 'paid') {
        $order->update([
          'payment_status' => 'paid',
          'status' => 'paid',
        ]);

        return response()->json([
          'success' => true,
          'message' => 'Payment confirmed',
          'status' => 'paid',
          'updated' => true,
        ]);
      }

      // Return current status if already paid or still pending/failed
      return response()->json([
        'success' => true,
        'message' => 'Status checked',
        'status' => $order->payment_status,
        'paynowStatus' => $paynowStatus['status'],
        'updated' => false,
      ]);
    } catch (\Exception $e) {
      Log::error('Error refreshing payment status: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Failed to check payment status',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
