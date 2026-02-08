<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\SystemLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderMonitor extends Controller
{
  public function index()
  {
    $orders = Order::with(['client', 'artisan.user', 'items'])
      ->latest('created_at')
      ->paginate(12);

    $totalOrders = Order::count();
    $pendingPaymentOrders = Order::where('status', 'pending')->count();
    $inProgressOrders = Order::where('status', 'processing')->count();
    $todayRevenue = Order::whereDate('created_at', today())->sum('total_amount');

    return view('content.apps.admin-monitor-orders', [
      'orders' => $orders,
      'totalOrders' => $totalOrders,
      'pendingPaymentOrders' => $pendingPaymentOrders,
      'inProgressOrders' => $inProgressOrders,
      'todayRevenue' => $todayRevenue,
    ]);
  }

  public function hold(Order $order, Request $request)
  {
    $order->update(['status' => 'held']);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Put order #' . $order->id . ' on hold',
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Order #ORD-' . $order->created_at->format('Y') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT) . ' has been placed on hold.');
  }

  public function resume(Order $order, Request $request)
  {
    $order->update(['status' => 'processing']);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Resumed order #' . $order->id . ' from hold',
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Order #ORD-' . $order->created_at->format('Y') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT) . ' has been resumed.');
  }

  public function cancel(Order $order, Request $request)
  {
    $request->validate([
      'reason' => 'required|string|min:5|max:1000',
    ]);

    $order->update([
      'status' => 'cancelled',
      'payment_status' => 'refunded',
    ]);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Cancelled order #' . $order->id . '. Reason: ' . $request->input('reason'),
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Order #ORD-' . $order->created_at->format('Y') . '-' . str_pad($order->id, 3, '0', STR_PAD_LEFT) . ' has been cancelled.');
  }
}
