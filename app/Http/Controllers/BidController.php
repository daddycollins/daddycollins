<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Requirement;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BidController extends Controller
{
  // Store a new bid for a requirement (artisan)
  public function store(Request $request, Requirement $requirement)
  {
    $data = $request->validate([
      'amount' => 'required|numeric|min:0',
      'proposal' => 'nullable|string',
    ]);
    $data['artisan_id'] = auth()->id();
    $data['requirement_id'] = $requirement->id;
    Bid::create($data);
    return redirect()->route('requirements.show', $requirement)->with('success', 'Bid submitted successfully.');
  }

  // (Optional) Accept a bid (client)
  public function accept(Bid $bid)
  {
    // Only the requirement owner (client) can accept a bid
    if (auth()->id() !== $bid->requirement->user_id) {
      abort(403, 'Unauthorized action.');
    }
    $bid->status = 'accepted';
    $bid->save();
    $bid->requirement->update(['status' => 'awarded']);
    // Optionally reject other bids
    Bid::where('requirement_id', $bid->requirement_id)->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
    return back()->with('success', 'Bid accepted and requirement awarded.');
  }

  /**
   * Show bid checkout form (before payment)
   */
  public function showCheckout(Bid $bid)
  {
    // Verify bid is accepted and user is requirement owner
    if ($bid->status !== 'accepted') {
      return redirect()->back()->with('error', 'Bid must be accepted before proceeding to payment.');
    }

    if (auth()->id() !== $bid->requirement->user_id) {
      abort(403, 'Unauthorized action.');
    }

    $bid->load(['requirement', 'artisan']);

    // Calculate service fee
    $subtotal = $bid->amount;
    $serviceFee = round($subtotal * 0.10, 2);
    $total = $subtotal + $serviceFee;

    return view('bids.checkout', compact('bid', 'subtotal', 'serviceFee', 'total'));
  }

  /**
   * Process bid payment and initiate Paynow transaction
   */
  public function processPayment(Bid $bid, Request $request)
  {
    // Verify bid is accepted and user is requirement owner
    if ($bid->status !== 'accepted') {
      return redirect()->back()->with('error', 'Bid must be accepted before proceeding to payment.');
    }

    if (auth()->id() !== $bid->requirement->user_id) {
      abort(403, 'Unauthorized action.');
    }

    $validated = $request->validate([
      'phone' => 'required|string|min:7',
      'shipping_address' => 'nullable|string|max:500',
    ], [
      'phone.required' => 'Phone number is required',
      'phone.min' => 'Please enter a valid phone number',
    ]);

    try {
      // Get artisan
      $artisan = $bid->artisan->artisanProfile;

      if (!$artisan) {
        return redirect()->back()->with('error', 'Artisan profile not found.');
      }

      // Check if artisan has Paynow account
      if (!$artisan->paynow || $artisan->paynow->status !== 'active') {
        return redirect()->back()->with('error', 'This provider cannot accept online payments at this time.');
      }

      // Calculate totals
      $subtotal = $bid->amount;
      $serviceFee = round($subtotal * 0.10, 2);
      $total = $subtotal + $serviceFee;

      // Create order from bid
      $order = Order::create([
        'client_id' => auth()->id(),
        'artisan_id' => $bid->artisan_id,
        'order_type' => 'service',
        'total_amount' => $total,
        'amount' => $subtotal,
        'service_fee' => $serviceFee,
        'status' => 'pending',
        'payment_status' => 'unpaid',
        'shipping_address' => $validated['shipping_address'] ?? null,
        'billing_address' => null,
        'payment_method' => 'paynow',
      ]);

      // Create order item to link to the bid
      OrderItem::create([
        'order_id' => $order->id,
        'item_type' => 'service',
        'item_id' => 0, // No specific service item, this is from a bid
        'quantity' => 1,
        'price' => $subtotal,
      ]);

      // Store order reference in session for fallback
      session([
        'last_order_id' => $order->id,
        'last_order_reference' => $order->paynow_reference ?? $order->id,
        'last_order_timestamp' => now()->timestamp
      ]);

      // Initiate Paynow payment
      $paynowService = app(\App\Services\PaynowService::class);
      $paymentResult = $paynowService->initiatePayment($order, $validated['phone']);

      if ($paymentResult['success']) {
        // Mark bid as paid/processed
        $bid->update(['status' => 'payment_initiated']);

        // Redirect to Paynow payment gateway
        return redirect($paymentResult['redirect_url']);
      } else {
        // Payment initiation failed - delete order
        $order->delete();

        return back()->with('error', 'Payment initiation failed: ' . $paymentResult['message']);
      }

    } catch (\Exception $e) {
      // If order was created, delete it
      if (isset($order)) {
        $order->delete();
      }

      return back()->with('error', 'Error processing payment: ' . $e->getMessage());
    }
  }
}
