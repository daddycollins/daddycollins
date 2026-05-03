<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

  // ===== REVENUE REPORTS =====
  public function revenueTrends(Request $request)
  {
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $trends = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
      ->where('status', 'completed')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->groupByRaw('DATE(created_at)')
      ->orderBy('date')
      ->get();

    return response()->json(['success' => true, 'data' => $trends]);
  }

  public function paymentStatusReport(Request $request)
  {
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');
    $orderStatusFilter = $request->input('orderStatus', '');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $query = Order::selectRaw('status, COUNT(*) as count, SUM(total_amount) as total_amount')
      ->whereBetween('created_at', [$startDate, $endDate]);

    // Apply status filter if provided
    if ($orderStatusFilter) {
      $query->where('status', $orderStatusFilter);
    }

    $paymentStatus = $query->groupBy('status')->get();

    return response()->json(['success' => true, 'data' => $paymentStatus]);
  }

  public function artisanPerformance(Request $request)
  {
    $limit = $request->input('limit', 20);
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $artisans = ArtisanProfile::with('user')
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
      ->withAvg([
        'reviews' => function ($query) {
          $query->where('status', 'approved');
        }
      ], 'rating')
      ->orderByDesc('orders_sum_total_amount')
      ->limit($limit)
      ->get()
      ->map(function ($artisan) {
        return [
          'name' => $artisan->user?->name ?? 'N/A',
          'category' => $artisan->category ?? 'N/A',
          'orders_completed' => $artisan->orders_count ?? 0,
          'total_revenue' => $artisan->orders_sum_total_amount ?? 0,
          'avg_rating' => round($artisan->reviews_avg_rating ?? 0, 2),
          'verified' => $artisan->verified ? 'Yes' : 'No',
        ];
      });

    return response()->json(['success' => true, 'data' => $artisans]);
  }

  // ===== USER REPORTS =====
  public function userGrowthReport(Request $request)
  {
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $growth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(CASE WHEN role = "artisan" THEN 1 ELSE 0 END) as artisans, SUM(CASE WHEN role = "client" THEN 1 ELSE 0 END) as clients')
      ->whereBetween('created_at', [$startDate, $endDate])
      ->groupByRaw('DATE(created_at)')
      ->orderBy('date')
      ->get();

    return response()->json(['success' => true, 'data' => $growth]);
  }

  public function artisanVerificationStatus(Request $request)
  {
    $artisans = ArtisanProfile::with('user', 'user.nationalIds', 'verification')
      ->get()
      ->map(function ($artisan) {
        $nationalDoc = $artisan->user?->nationalIds?->first();
        return [
          'id' => $artisan->id,
          'name' => $artisan->user?->name ?? 'N/A',
          'email' => $artisan->user?->email ?? 'N/A',
          'category' => $artisan->category ?? 'N/A',
          'verified' => $artisan->verified ? 'Verified' : 'Not Verified',
          'verification_status' => $artisan->verification?->status ?? 'No Application',
          'ocr_confidence' => $nationalDoc?->ocr_confidence ?? 'N/A',
          'created_at' => $artisan->created_at->format('M d, Y'),
        ];
      });

    return response()->json(['success' => true, 'data' => $artisans]);
  }

  public function inactiveUsersReport(Request $request)
  {
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');
    $statusFilter = $request->input('status', '');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    // Users who haven't updated their profile BEFORE the start date (inactive during the range)
    $query = User::where('updated_at', '<', $startDate);

    // Apply status filter if provided
    if ($statusFilter) {
      $query->where('status', $statusFilter);
    }

    $inactiveUsers = $query->get()
      ->map(function ($user) {
        return [
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email,
          'role' => ucfirst($user->role),
          'status' => ucfirst($user->status),
          'last_updated' => $user->updated_at ? $user->updated_at->format('M d, Y H:i') : 'Never',
          'created_at' => $user->created_at->format('M d, Y'),
        ];
      });

    return response()->json(['success' => true, 'data' => $inactiveUsers]);
  }

  // ===== ORDER REPORTS =====
  public function orderStatusReport(Request $request)
  {
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');
    $orderStatusFilter = $request->input('orderStatus', '');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $query = Order::selectRaw('status, COUNT(*) as count, SUM(total_amount) as total_amount, AVG(total_amount) as avg_amount')
      ->whereBetween('created_at', [$startDate, $endDate]);

    // Apply status filter if provided
    if ($orderStatusFilter) {
      $query->where('status', $orderStatusFilter);
    }

    $orders = $query->groupBy('status')->get();

    return response()->json(['success' => true, 'data' => $orders]);
  }

  public function topServicesReport(Request $request)
  {
    $limit = $request->input('limit', 15);
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $services = ArtisanProfile::selectRaw('artisan_profiles.category, COUNT(orders.id) as order_count, SUM(orders.total_amount) as total_revenue, COALESCE(AVG(reviews.rating), 0) as avg_rating')
      ->leftJoin('orders', 'artisan_profiles.id', '=', 'orders.artisan_id')
      ->leftJoin('reviews', 'artisan_profiles.id', '=', 'reviews.artisan_id')
      ->whereBetween('orders.created_at', [$startDate, $endDate])
      ->where('orders.status', 'completed')
      ->groupBy('artisan_profiles.category')
      ->orderByDesc('total_revenue')
      ->limit($limit)
      ->get();

    return response()->json(['success' => true, 'data' => $services]);
  }

  public function cancelledOrdersAnalysis(Request $request)
  {
    $dateRange = $this->getDateRange($request->input('dateRange', 'year'));
    $customStart = $request->input('startDate');
    $customEnd = $request->input('endDate');
    $orderStatusFilter = $request->input('orderStatus', '');

    if ($request->input('dateRange') === 'custom' && $customStart && $customEnd) {
      $startDate = Carbon::createFromFormat('Y-m-d', $customStart)->startOfDay();
      $endDate = Carbon::createFromFormat('Y-m-d', $customEnd)->endOfDay();
    } else {
      $startDate = $dateRange['start'];
      $endDate = $dateRange['end'];
    }

    $query = Order::whereIn('status', ['cancelled', 'rejected'])
      ->whereBetween('created_at', [$startDate, $endDate])
      ->with('client', 'artisan');

    // Apply status filter if provided
    if ($orderStatusFilter) {
      $query->where('status', $orderStatusFilter);
    }

    $cancelledOrders = $query->get()
      ->map(function ($order) {
        return [
          'id' => $order->id,
          'client' => $order->client?->name ?? 'N/A',
          'artisan' => $order->artisan?->user?->name ?? 'N/A',
          'service' => $order->service_name ?? 'N/A',
          'amount' => $order->total_amount,
          'status' => ucfirst($order->status),
          'created_at' => $order->created_at->format('M d, Y'),
        ];
      });

    return response()->json(['success' => true, 'data' => $cancelledOrders]);
  }

  // ===== REVIEW REPORTS =====
  public function artisanQualityReport(Request $request)
  {
    $limit = $request->input('limit', 20);
    $artisans = ArtisanProfile::with('user', 'reviews')
      ->withCount('reviews')
      ->withAvg('reviews', 'rating')
      ->orderByDesc('reviews_avg_rating')
      ->limit($limit)
      ->get()
      ->map(function ($artisan) {
        return [
          'name' => $artisan->user?->name ?? 'N/A',
          'category' => $artisan->category ?? 'N/A',
          'total_reviews' => $artisan->reviews_count ?? 0,
          'avg_rating' => round($artisan->reviews_avg_rating ?? 0, 2),
          'status' => $artisan->verified ? 'Verified' : 'Unverified',
        ];
      });

    return response()->json(['success' => true, 'data' => $artisans]);
  }
}