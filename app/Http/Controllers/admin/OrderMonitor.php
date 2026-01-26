<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderMonitor extends Controller
{
  public function index()
  {
    // Get paginated orders with relationships
    $orders = Order::with(['client', 'artisan', 'artisanService'])
      ->latest('created_at')
      ->paginate(12); // 12 orders per page

    // Calculate statistics
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
}