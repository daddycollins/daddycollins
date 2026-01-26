<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GeneralUSerController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        // Fetch statistical data
        $totalOrders = Order::where('client_id', $user->id)->count();
        $pendingOrders = Order::where('client_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('client_id', $user->id)->where('status', 'completed')->count();
        $inProgressOrders = Order::where('client_id', $user->id)->whereIn('status', ['processing', 'paid'])->count();
        $artisansHired = Order::where('client_id', $user->id)->distinct()->count('artisan_id');

        // Fetch recent 5 orders with artisan details
        $recentOrders = Order::where('client_id', $user->id)
            ->with([
                'artisan' => function ($query) {
                    $query->with('user');
                },
                'items' => function ($query) {
                    $query->with('artisanService');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Fetch order status distribution
        $orderStatusCounts = Order::where('client_id', $user->id)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        // Calculate status counts and percentages
        $completedCount = $orderStatusCounts->get('completed')->count ?? 0;
        $inProgressCount = ($orderStatusCounts->get('processing')->count ?? 0) + ($orderStatusCounts->get('paid')->count ?? 0);
        $pendingCount = $orderStatusCounts->get('pending')->count ?? 0;
        $cancelledCount = $orderStatusCounts->get('cancelled')->count ?? 0;

        $totalStatusCount = $completedCount + $inProgressCount + $pendingCount + $cancelledCount;

        if ($totalStatusCount > 0) {
            $completedPercent = round(($completedCount / $totalStatusCount) * 100);
            $inProgressPercent = round(($inProgressCount / $totalStatusCount) * 100);
            $pendingPercent = round(($pendingCount / $totalStatusCount) * 100);
            $cancelledPercent = round(($cancelledCount / $totalStatusCount) * 100);
        } else {
            $completedPercent = $inProgressPercent = $pendingPercent = $cancelledPercent = 0;
        }

        // Fetch top 4 recommended artisans (verified, excluding already hired)
        $hiredArtisanIds = Order::where('client_id', $user->id)
            ->distinct()
            ->pluck('artisan_id')
            ->toArray();

        $recommendedArtisans = ArtisanProfile::where('verified', true)
            ->whereNotIn('id', $hiredArtisanIds)
            ->with([
                'user',
                'reviews' => function ($query) {
                    $query->select('artisan_id', 'rating');
                }
            ])
            ->withCount('reviews')
            ->orderBy('average_rating', 'desc')
            ->limit(4)
            ->get();

        return view('content.apps.client-dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'inProgressOrders',
            'artisansHired',
            'recentOrders',
            'completedCount',
            'inProgressCount',
            'pendingCount',
            'cancelledCount',
            'completedPercent',
            'inProgressPercent',
            'pendingPercent',
            'cancelledPercent',
            'totalStatusCount',
            'recommendedArtisans'
        ));
    }

    public function browseArtisans(Request $request)
    {
        // Build the base query with eager loading
        $query = ArtisanProfile::query()
            ->with(['user', 'services'])
            ->withCount([
                'reviews',
                'orders as completed_jobs_count' => function ($q) {
                    $q->where('status', 'completed');
                },
                'orders as total_orders_count'
            ]);

        // FILTER: Search (name, specialty, location)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('business_name', 'like', "%{$searchTerm}%")
                    ->orWhere('first_name', 'like', "%{$searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$searchTerm}%")
                    ->orWhere('category', 'like', "%{$searchTerm}%")
                    ->orWhere('city', 'like', "%{$searchTerm}%")
                    ->orWhere('location', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // FILTER: Category
        if ($request->filled('category')) {
            $query->where('category', 'like', "%{$request->category}%");
        }

        // FILTER: Location (city)
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('city', 'like', "%{$request->location}%")
                    ->orWhere('location', 'like', "%{$request->location}%");
            });
        }

        // FILTER: Rating
        if ($request->filled('rating')) {
            $minRating = (int) $request->rating;
            $query->where('average_rating', '>=', $minRating);
        }

        // FILTER: Experience
        if ($request->filled('experience')) {
            switch ($request->experience) {
                case '0-2':
                    $query->whereBetween('years_of_experience', [0, 2]);
                    break;
                case '2-5':
                    $query->whereBetween('years_of_experience', [2, 5]);
                    break;
                case '5+':
                    $query->where('years_of_experience', '>=', 5);
                    break;
            }
        }

        // FILTER: Price Range (based on average service price)
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case 'budget':
                    $query->whereHas('services', function ($q) {
                        $q->where('price_estimate', '<', 50);
                    });
                    break;
                case 'mid':
                    $query->whereHas('services', function ($q) {
                        $q->whereBetween('price_estimate', [50, 150]);
                    });
                    break;
                case 'premium':
                    $query->whereHas('services', function ($q) {
                        $q->where('price_estimate', '>', 150);
                    });
                    break;
            }
        }

        // FILTER: Availability
        if ($request->filled('availability')) {
            $query->whereHas('services', function ($q) {
                $q->where('availability', 'available');
            });
        }

        // FILTER: Verified Only
        if ($request->filled('verified_only') && $request->verified_only === 'true') {
            $query->where('verified', true);
        }

        // Sorting
        $sortBy = $request->get('sort', 'rating');
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'experience':
                $query->orderBy('years_of_experience', 'desc');
                break;
            case 'jobs':
                $query->orderBy('completed_jobs_count', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('average_rating', 'desc');
        }

        // Paginate results (12 per page for 4-column grid)
        $artisans = $query->paginate(12)->withQueryString();

        // Get total counts for display
        $totalArtisans = ArtisanProfile::count();
        $verifiedCount = ArtisanProfile::where('verified', true)->count();

        // Category options
        $categoryOptions = [
            'Plumbing & Repairs' => 'Plumbing & Repairs',
            'Carpentry & Woodwork' => 'Carpentry & Woodwork',
            'Electrical Services' => 'Electrical Services',
            'Tailoring & Fashion' => 'Tailoring & Fashion',
            'Painting & Decoration' => 'Painting & Decoration',
            'Masonry & Construction' => 'Masonry & Construction',
            'Welding & Metalwork' => 'Welding & Metalwork',
            'Crafts & Beadwork' => 'Crafts & Beadwork',
            'Automotive Repair' => 'Automotive Repair',
            'Hairdressing & Beauty' => 'Hairdressing & Beauty',
        ];

        // Location options
        $locationOptions = [
            'Harare' => 'Harare',
            'Bulawayo' => 'Bulawayo',
            'Chitungwiza' => 'Chitungwiza',
            'Mutare' => 'Mutare',
            'Gweru' => 'Gweru',
            'Victoria Falls' => 'Victoria Falls',
            'Kwekwe' => 'Kwekwe',
            'Kadoma' => 'Kadoma',
        ];

        return view('content.apps.browse-artisans', compact(
            'artisans',
            'totalArtisans',
            'verifiedCount',
            'categoryOptions',
            'locationOptions'
        ));
    }

    public function myOrders()
    {
        $user = Auth::user();

        // Get all orders for the user with pagination
        $orders = Order::where('client_id', $user->id)
            ->with([
                'artisan' => function ($q) {
                    $q->with('user');
                },
                'items' => function ($q) {
                    $q->with('artisanService');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count orders by status
        $completedCount = Order::where('client_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $inProgressCount = Order::where('client_id', $user->id)
            ->whereIn('status', ['processing', 'paid'])
            ->count();

        $pendingPaymentCount = Order::where('client_id', $user->id)
            ->where('payment_status', 'unpaid')
            ->count();

        $totalOrders = Order::where('client_id', $user->id)->count();

        // Calculate total spent
        $totalSpent = Order::where('client_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_amount') ?? 0;

        // Get 30-day trend data
        $thirtyDaysAgo = now()->subDays(30)->startOfDay();
        $trendData = Order::where('client_id', $user->id)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as date, status, COUNT(*) as count')
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();

        // Format chart data
        $dates = [];
        $completedTrend = [];
        $inProgressTrend = [];
        $pendingPaymentTrend = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = now()->subDays($i)->format('M d');

            $completed = $trendData->where('date', $date)->where('status', 'completed')->sum('count');
            $inProgress = $trendData->where('date', $date)->whereIn('status', ['processing', 'paid'])->sum('count');
            $pendingPayment = $trendData->where('date', $date)->where('payment_status', 'unpaid')->sum('count');

            $completedTrend[] = $completed;
            $inProgressTrend[] = $inProgress;
            $pendingPaymentTrend[] = $pendingPayment;
        }

        $chartData = [
            'categories' => $dates,
            'series' => [
                [
                    'name' => 'Completed',
                    'data' => $completedTrend
                ],
                [
                    'name' => 'In Progress',
                    'data' => $inProgressTrend
                ],
                [
                    'name' => 'Pending Payment',
                    'data' => $pendingPaymentTrend
                ]
            ]
        ];

        return view('content.apps.my-orders', compact(
            'orders',
            'completedCount',
            'inProgressCount',
            'pendingPaymentCount',
            'totalOrders',
            'totalSpent',
            'chartData'
        ));
    }

    public function createReview()
    {
        $user = Auth::user();

        // Fetch all reviews by this client with artisan and order details
        $reviews = Review::where('client_id', $user->id)
            ->with([
                'artisan' => function ($q) {
                    $q->with('user');
                },
                'order'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;

        // Count reviews by rating
        $fiveStarCount = $reviews->where('rating', 5)->count();
        $fourStarCount = $reviews->where('rating', 4)->count();
        $threeStarCount = $reviews->where('rating', 3)->count();
        $twoStarCount = $reviews->where('rating', 2)->count();
        $oneStarCount = $reviews->where('rating', 1)->count();

        // Calculate percentages for chart
        $ratingDistribution = [
            5 => $fiveStarCount,
            4 => $fourStarCount,
            3 => $threeStarCount,
            2 => $twoStarCount,
            1 => $oneStarCount,
        ];

        // Calculate 5-star percentage
        $fiveStarPercent = $totalReviews > 0 ? round(($fiveStarCount / $totalReviews) * 100) : 0;

        // Count reviews this month
        $reviewsThisMonth = Review::where('client_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get completed orders without reviews (pending reviews)
        $reviewedOrderIds = Review::where('client_id', $user->id)->pluck('order_id')->toArray();
        $pendingReviewOrders = Order::where('client_id', $user->id)
            ->where('status', 'completed')
            ->whereNotIn('id', $reviewedOrderIds)
            ->with([
                'artisan' => function ($q) {
                    $q->with('user');
                },
                'items' => function ($q) {
                    $q->with('artisanService');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingReviewsCount = $pendingReviewOrders->count();

        return view('content.apps.artisan-review', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'fiveStarCount',
            'fourStarCount',
            'threeStarCount',
            'twoStarCount',
            'oneStarCount',
            'ratingDistribution',
            'fiveStarPercent',
            'reviewsThisMonth',
            'pendingReviewOrders',
            'pendingReviewsCount'
        ));
    }

    public function userProfile()
    {
        $user = Auth::user();

        // Get user's name parts (for edit form)
        $nameParts = explode(' ', $user->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        return view('content.apps.user-profile', compact(
            'user',
            'firstName',
            'lastName'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20'
        ]);

        $user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone']
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => 'required|string|min:8|confirmed|different:current_password',
            'password_confirmation' => 'required'
        ]);

        $user->update([
            'password' => bcrypt($validated['password'])
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function orderDetails(Order $order)
    {
        $user = Auth::user();

        // Authorize: Client can only view their own orders
        if ($order->client_id !== $user->id) {
            abort(403, 'Unauthorized to view this order');
        }

        // Eager load relationships
        $order->load(['items.artisanService', 'client', 'artisan.user']);

        // Calculate totals
        $subtotal = 0;
        $tax = 0;

        foreach ($order->items as $item) {
            $itemTotal = $item->price * $item->quantity;
            $subtotal += $itemTotal;

            // Calculate tax based on service price (assume 10% tax on service items)
            if ($item->artisanService) {
                $serviceTax = ($item->price * 0.10) * $item->quantity;
                $tax += $serviceTax;
            }
        }

        $total = $subtotal + $tax;

        // Format addresses for display
        $shippingAddress = $order->shipping_address ?? ($user->address ?? 'No address provided');
        $billingAddress = $order->billing_address ?? ($user->address ?? 'No address provided');

        // Create basic timeline based on order status
        $timeline = [
            ['status' => 'Order Placed', 'date' => $order->created_at, 'icon' => 'ri-shopping-cart-line'],
            ['status' => 'Processing', 'date' => $order->created_at->addDays(1), 'icon' => 'ri-time-line'],
            ['status' => 'Ready for Pickup', 'date' => $order->created_at->addDays(2), 'icon' => 'ri-checkbox-circle-line'],
            ['status' => 'Completed', 'date' => $order->updated_at, 'icon' => 'ri-check-double-line']
        ];

        return view('content.apps.order-details', [
            'order' => $order,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress,
            'timeline' => $timeline
        ]);
    }
}
