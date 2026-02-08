<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\SystemLog;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Reports extends Controller
{
  private function getDateRange($rangeType)
  {
    $today = Carbon::now();

    switch ($rangeType) {
      case 'today':
        return [
          'start' => $today->copy()->startOfDay(),
          'end' => $today->copy()->endOfDay(),
        ];
      case 'week':
        return [
          'start' => $today->copy()->startOfWeek(),
          'end' => $today->copy()->endOfWeek(),
        ];
      case 'month':
        return [
          'start' => $today->copy()->startOfMonth(),
          'end' => $today->copy()->endOfMonth(),
        ];
      case 'quarter':
        return [
          'start' => $today->copy()->startOfQuarter(),
          'end' => $today->copy()->endOfQuarter(),
        ];
      case 'year':
        return [
          'start' => $today->copy()->startOfYear(),
          'end' => $today->copy()->endOfYear(),
        ];
      default:
        return [
          'start' => $today->copy()->startOfMonth(),
          'end' => $today->copy()->endOfMonth(),
        ];
    }
  }

  public function generateReport(Request $request)
  {
    $dateRange = $request->input('dateRange', 'month');
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');

    if ($dateRange === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $dateRange = $this->getDateRange($dateRange);
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    // ===== FINANCIAL REPORTS =====
    $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount');
    $completedPayments = Order::whereBetween('created_at', [$startDate, $endDate])
      ->where('status', 'paid')->sum('total_amount');
    $pendingPayments = Order::whereBetween('created_at', [$startDate, $endDate])
      ->where('status', 'pending')->sum('total_amount');

    // Top Earning Artisans
    $topArtisans = ArtisanProfile::with('user')
      ->withCount([
        'orders' => function ($query) use ($startDate, $endDate) {
          $query->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed');
        }
      ])
      ->withSum([
        'orders' => function ($query) use ($startDate, $endDate) {
          $query->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed');
        }
      ], 'total_amount')
      ->orderByDesc('orders_sum_total_amount')
      ->limit(5)
      ->get();

    // ===== USER REPORTS =====
    $totalUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
    $activeUsers = User::whereBetween('created_at', [$startDate, $endDate])
      ->where('status', 'active')->count();

    // ===== SYSTEM REPORTS =====
    $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
    $completedOrders = Order::whereBetween('created_at', [$startDate, $endDate])
      ->where('status', 'completed')->count();
    $pendingOrders = Order::whereBetween('created_at', [$startDate, $endDate])
      ->where('status', 'pending')->count();
    $cancelledOrders = Order::whereBetween('created_at', [$startDate, $endDate])
      ->where('status', 'cancelled')->count();

    return response()->json([
      'success' => true,
      'message' => 'Reports generated successfully',
      'data' => [
        'totalRevenue' => $totalRevenue,
        'completedPayments' => $completedPayments,
        'pendingPayments' => $pendingPayments,
        'totalUsers' => $totalUsers,
        'activeUsers' => $activeUsers,
        'totalOrders' => $totalOrders,
        'completedOrders' => $completedOrders,
        'pendingOrders' => $pendingOrders,
        'cancelledOrders' => $cancelledOrders,
        'topArtisans' => $topArtisans,
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d'),
      ]
    ]);
  }

  public function index()
  {
    // ===== FINANCIAL REPORTS =====
    $totalRevenue = Order::sum('total_amount');
    $monthlyRevenue = Order::whereMonth('created_at', Carbon::now()->month)->sum('total_amount');
    $completedPayments = Order::where('status', 'paid')->sum('total_amount');
    $pendingPayments = Order::where('status', 'pending')->sum('total_amount');

    // Top Earning Artisans
    $topArtisans = ArtisanProfile::with('user')
      ->withCount([
        'orders' => function ($query) {
          $query->where('status', 'completed');
        }
      ])
      ->withSum([
        'orders' => function ($query) {
          $query->where('status', 'completed');
        }
      ], 'total_amount')
      ->orderByDesc('orders_sum_total_amount')
      ->limit(5)
      ->get();

    // Revenue by Category
    $revenueByCategory = DB::table('artisan_profiles')
      ->selectRaw('category, SUM(COALESCE((SELECT SUM(total_amount) FROM orders WHERE artisan_profiles.id = orders.artisan_id AND orders.status = "completed"), 0)) as orders_sum_total_amount')
      ->groupByRaw('category')
      ->orderByDesc('orders_sum_total_amount')
      ->get();

    // ===== USER REPORTS =====
    $totalUsers = User::count();
    $activeUsers = User::where('status', 'active')->count();
    $suspendedUsers = User::where('status', 'suspended')->count();
    $totalArtisans = User::where('role', 'artisan')->count();
    $verifiedArtisans = ArtisanProfile::where('verified', true)->count();
    $totalClients = User::where('role', 'client')->count();

    // User Growth (last 7 days)
    $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
      ->where('created_at', '>=', Carbon::now()->subDays(7))
      ->groupByRaw('DATE(created_at)')
      ->get();

    // Top Artisans by Orders
    $topArtisansByOrders = ArtisanProfile::with('user')
      ->withCount('orders')
      ->withAvg('reviews', 'rating')
      ->orderByDesc('orders_count')
      ->limit(5)
      ->get();

    // ===== SYSTEM REPORTS =====
    $totalOrders = Order::count();
    $completedOrders = Order::where('status', 'completed')->count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $cancelledOrders = Order::where('status', 'cancelled')->count();

    // Order Processing Status
    $orderStatusBreakdown = Order::selectRaw('status, COUNT(*) as count')
      ->groupByRaw('status')
      ->get()
      ->pluck('count', 'status');

    // Service Performance by Category
    $categoryPerformance = ArtisanProfile::selectRaw('artisan_profiles.id, artisan_profiles.category, COUNT(orders.id) as orders_count, AVG(reviews.rating) as reviews_avg_rating')
      ->leftJoin('orders', 'artisan_profiles.id', '=', 'orders.artisan_id')
      ->leftJoin('reviews', 'artisan_profiles.id', '=', 'reviews.artisan_id')
      ->groupByRaw('artisan_profiles.id, artisan_profiles.category')
      ->get();

    // Average metrics
    $avgOrderValue = Order::avg('total_amount') ?? 0;
    $avgRating = Review::avg('rating') ?? 0;
    $totalReviews = Review::count();
    $systemLogs = SystemLog::count();

    return view('content.apps.admin-reports', [
      // Financial
      'totalRevenue' => $totalRevenue,
      'monthlyRevenue' => $monthlyRevenue,
      'completedPayments' => $completedPayments,
      'pendingPayments' => $pendingPayments,
      'topArtisans' => $topArtisans,
      'revenueByCategory' => $revenueByCategory,
      'avgOrderValue' => round($avgOrderValue, 2),

      // Users
      'totalUsers' => $totalUsers,
      'activeUsers' => $activeUsers,
      'suspendedUsers' => $suspendedUsers,
      'totalArtisans' => $totalArtisans,
      'verifiedArtisans' => $verifiedArtisans,
      'totalClients' => $totalClients,
      'userGrowth' => $userGrowth,
      'topArtisansByOrders' => $topArtisansByOrders,

      // System
      'totalOrders' => $totalOrders,
      'completedOrders' => $completedOrders,
      'pendingOrders' => $pendingOrders,
      'cancelledOrders' => $cancelledOrders,
      'orderStatusBreakdown' => $orderStatusBreakdown,
      'categoryPerformance' => $categoryPerformance,
      'avgRating' => round($avgRating, 1),
      'totalReviews' => $totalReviews,
      'systemLogs' => $systemLogs,
    ]);
  }
}
