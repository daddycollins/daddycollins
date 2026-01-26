<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Order;
use App\Models\ArtisanVerification;
use App\Http\Controllers\Controller;

class AdminDashboard extends Controller
{
  public function index()
  {
    // Get dashboard statistics
    $totalUsers = User::count();
    $verifiedArtisans = User::where('role', 'artisan')->whereHas('artisanProfile', function ($q) {
      $q->where('verified', true);
    })->count();
    $pendingVerifications = ArtisanVerification::where('status', 'pending')->count();
    $totalOrders = Order::count();

    $dashboardData = [
      'totalUsers' => $totalUsers,
      'verifiedArtisans' => $verifiedArtisans,
      'pendingVerifications' => $pendingVerifications,
      'totalOrders' => $totalOrders,
    ];

    return view('content.apps.admin-dasboard', $dashboardData);
  }
}
