<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\DB;
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

    // User Growth Trend (last 30 days by date)
    $userGrowthData = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
      ->where('created_at', '>=', Carbon::now()->subDays(30))
      ->groupBy(DB::raw('DATE(created_at)'))
      ->orderBy('date')
      ->get();

    // User Type Distribution
    $userDistribution = User::selectRaw('role, COUNT(*) as count')
      ->groupBy('role')
      ->get();

    // Orders Status Distribution
    $orderStatus = Order::selectRaw('status, COUNT(*) as count')
      ->groupBy('status')
      ->get();

    // Revenue Trend (last 12 weeks by week)
    $revenueTrend = Order::selectRaw('WEEK(created_at) as week, YEAR(created_at) as year, SUM(CAST(total_amount AS DECIMAL(10,2))) as revenue')
      ->where('created_at', '>=', Carbon::now()->subWeeks(12))
      ->where('status', 'completed')
      ->groupBy(DB::raw('WEEK(created_at), YEAR(created_at)'))
      ->orderBy('year')
      ->orderBy('week')
      ->get();

    // Recent Orders with relationships
    $recentOrders = Order::with(['client', 'artisan.user'])
      ->latest()
      ->limit(10)
      ->get();

    // Pending Verifications with relationships
    $pendingVerificationsList = ArtisanVerification::with(['artisan.user', 'nationalDocument'])
      ->where('status', 'pending')
      ->latest()
      ->get();

    // Verification Queue Statistics
    $verificationStats = ArtisanVerification::selectRaw('status, COUNT(*) as count')
      ->groupBy('status')
      ->pluck('count', 'status');

    $dashboardData = [
      'totalUsers' => $totalUsers,
      'verifiedArtisans' => $verifiedArtisans,
      'pendingVerifications' => $pendingVerifications,
      'totalOrders' => $totalOrders,
      'userGrowthData' => $userGrowthData,
      'userDistribution' => $userDistribution,
      'orderStatus' => $orderStatus,
      'revenueTrend' => $revenueTrend,
      'recentOrders' => $recentOrders,
      'pendingVerificationsList' => $pendingVerificationsList,
      'verificationStats' => $verificationStats,
    ];

    return view('content.apps.admin-dasboard', $dashboardData);
  }
}
