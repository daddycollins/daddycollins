<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Payout;
use App\Models\Review;
use App\Models\ArtisanGood;
use Illuminate\Http\Request;
use App\Models\PaynowAccount;
use App\Models\ArtisanProfile;
use App\Models\ArtisanService;
use App\Models\NationalDocument;
use App\Models\ArtisanVerification;
use App\Models\SystemLog;
use App\Services\OcrService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtisanController extends Controller
{
    public function artisanProfile()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        // Fetch all statistics
        $totalOrders = Order::where('artisan_id', $artisanProfile->id)->count();
        $completedOrders = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')->count();
        $totalEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')->sum('total_amount');
        $completionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // Review statistics
        $averageRating = Review::where('artisan_id', $artisanProfile->id)->avg('rating') ?? 0;
        $totalReviews = Review::where('artisan_id', $artisanProfile->id)->count();

        // Client-side statistics (for when user is viewing as client)
        $clientOrders = Order::where('client_id', $user->id)->count();
        $clientTotalSpent = Order::where('client_id', $user->id)->where('status', 'completed')->sum('total_amount');
        $favoriteArtisansCount = 0; // TODO: Implement favorites relationship if available

        // Client average rating given
        $clientAverageRatingGiven = Review::where('client_id', $user->id)->avg('rating') ?? 0;

        // Recent orders
        $recentOrders = Order::where('artisan_id', $artisanProfile->id)
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        // Payment account
        $paynowAccount = PaynowAccount::where('artisan_id', $artisanProfile->id)->first();

        // Verification status
        $isVerified = $artisanProfile->verified ?? false;

        return view('content.apps.artisan-profile', [
            'user' => $user,
            'artisanProfile' => $artisanProfile,
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'totalEarnings' => $totalEarnings,
            'completionRate' => round($completionRate, 1),
            'averageRating' => round($averageRating, 1),
            'totalReviews' => $totalReviews,
            'recentOrders' => $recentOrders,
            'paynowAccount' => $paynowAccount,
            'isVerified' => $isVerified,
            'clientOrders' => $clientOrders,
            'clientTotalSpent' => $clientTotalSpent,
            'favoriteArtisansCount' => $favoriteArtisansCount,
            'clientAverageRatingGiven' => round($clientAverageRatingGiven, 1),
        ]);
    }

    public function artisanDashboard()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            $artisanProfile = ArtisanProfile::create([
                'user_id' => $user->id,
                'business_name' => $user->name,
                'category' => 'General',
                'location' => 'Not specified',
                'verified' => false,
            ]);
        }

        // ===== STATISTICS =====
        // Total and monthly orders
        $totalOrders = Order::where('artisan_id', $artisanProfile->id)->count();
        $thisMonthOrders = Order::where('artisan_id', $artisanProfile->id)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();
        $lastMonthOrders = Order::where('artisan_id', $artisanProfile->id)
            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->count();
        $ordersGrowth = $lastMonthOrders > 0 ? (($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : 0;

        // Total and monthly earnings
        $totalEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->sum('total_amount');
        $thisMonthEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('total_amount');
        $lastMonthEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->sum('total_amount');
        $earningsGrowth = $lastMonthEarnings > 0 ? (($thisMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100 : 0;

        // Ratings
        $averageRating = Review::where('artisan_id', $artisanProfile->id)->avg('rating') ?? 0;
        $reviewCount = Review::where('artisan_id', $artisanProfile->id)->count();

        // Verification status
        $verificationStatus = $artisanProfile->verified ? 'Verified' : 'Pending';
        $verificationBadgeColor = $artisanProfile->verified ? 'success' : 'warning';

        // ===== ORDERS BREAKDOWN =====
        $completedOrders = Order::where('artisan_id', $artisanProfile->id)->where('status', 'completed')->count();
        $pendingOrders = Order::where('artisan_id', $artisanProfile->id)->where('status', 'pending')->count();
        $paidOrders = Order::where('artisan_id', $artisanProfile->id)->where('status', 'paid')->count();
        $cancelledOrders = Order::where('artisan_id', $artisanProfile->id)->where('status', 'cancelled')->count();

        $completionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // ===== 7-DAY ORDERS TREND =====
        $ordersTrendData = [];
        $ordersLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $ordersLabels[] = $date->format('D');
            $count = Order::where('artisan_id', $artisanProfile->id)
                ->whereDate('created_at', $date)
                ->count();
            $ordersTrendData[] = $count;
        }

        // ===== SERVICES & ORDERS =====
        $artisanServices = ArtisanService::where('artisan_id', $artisanProfile->id)
            ->withCount([
                'orders' => function ($query) {
                    $query->where('artisan_id', Auth::user()->id);
                }
            ])
            ->get();

        // Recent orders with client details
        $recentOrders = Order::where('artisan_id', $artisanProfile->id)
            ->with('client:id,name')
            ->latest()
            ->take(5)
            ->get();

        return view('content.apps.artisan-dashboard', [
            'artisanProfile' => $artisanProfile,
            'user' => $user,
            'totalOrders' => $totalOrders,
            'ordersGrowth' => round($ordersGrowth, 1),
            'totalEarnings' => round($totalEarnings, 2),
            'earningsGrowth' => round($earningsGrowth, 1),
            'averageRating' => round($averageRating, 1),
            'reviewCount' => $reviewCount,
            'verificationStatus' => $verificationStatus,
            'verificationBadgeColor' => $verificationBadgeColor,
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'paidOrders' => $paidOrders,
            'cancelledOrders' => $cancelledOrders,
            'completionRate' => round($completionRate, 1),
            'ordersTrendData' => json_encode($ordersTrendData),
            'ordersLabels' => json_encode($ordersLabels),
            'artisanServices' => $artisanServices,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function artisanOrders()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->route('artisan-dashboard')->with('warning', 'Please complete your profile first.');
        }

        // Fetch all orders for this artisan with client details
        $orders = Order::where('artisan_id', $artisanProfile->id)
            ->with('client:id,name')
            ->latest()
            ->get();

        // Calculate statistics
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $paidOrders = $orders->where('status', 'paid')->count();
        $cancelledOrders = $orders->where('status', 'cancelled')->count();

        $totalRevenue = $orders->where('status', 'completed')->sum('total_amount');
        $completionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;

        // 7-day order trend
        $completedTrendData = [];
        $inProgressTrendData = [];
        $pendingTrendData = [];
        $ordersLabels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $ordersLabels[] = $date->format('D');

            $completedTrendData[] = Order::where('artisan_id', $artisanProfile->id)
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->count();

            $inProgressTrendData[] = Order::where('artisan_id', $artisanProfile->id)
                ->where('status', 'paid')
                ->whereDate('created_at', $date)
                ->count();

            $pendingTrendData[] = Order::where('artisan_id', $artisanProfile->id)
                ->where('status', 'pending')
                ->whereDate('created_at', $date)
                ->count();
        }

        return view('content.apps.artisan-orders', [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'paidOrders' => $paidOrders,
            'cancelledOrders' => $cancelledOrders,
            'totalRevenue' => $totalRevenue,
            'completionRate' => round($completionRate, 1),
            'completedTrendData' => json_encode($completedTrendData),
            'inProgressTrendData' => json_encode($inProgressTrendData),
            'pendingTrendData' => json_encode($pendingTrendData),
            'ordersLabels' => json_encode($ordersLabels),
        ]);
    }
    public function artisanServices()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->route('artisan-dashboard')->with('warning', 'Please complete your artisan profile first.');
        }

        // Get all services for this artisan
        $services = ArtisanService::where('artisan_id', $artisanProfile->id)->get();

        // Calculate statistics
        $totalServices = $services->count();
        $activeServices = $services->where('availability', true)->count();

        // Calculate earnings from completed orders with these services
        $totalEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Average rating from reviews
        $avgRating = Review::whereHas('order', function ($query) use ($artisanProfile) {
            $query->where('artisan_id', $artisanProfile->id);
        })->avg('rating') ?? 0;

        $reviewCount = Review::whereHas('order', function ($query) use ($artisanProfile) {
            $query->where('artisan_id', $artisanProfile->id);
        })->count();

        return view('content.apps.artisan-services', compact(
            'services',
            'totalServices',
            'activeServices',
            'totalEarnings',
            'avgRating',
            'reviewCount'
        ));
    }

    public function artisanProducts()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->route('artisan-dashboard')->with('warning', 'Please complete your artisan profile first.');
        }

        // Get all products for this artisan
        $products = ArtisanGood::where('artisan_id', $artisanProfile->id)->get();

        // Calculate statistics
        $totalProducts = $products->count();
        $availableProducts = $products->where('availability', true)->count();
        $totalStockValue = $products->sum(function ($product) {
            return $product->price * $product->stock_quantity;
        });

        // Calculate earnings from completed orders with these products
        $totalEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('order_type', 'product')
            ->where('status', 'completed')
            ->sum('total_amount');

        // Average rating from reviews
        $avgRating = Review::whereHas('order', function ($query) use ($artisanProfile) {
            $query->where('artisan_id', $artisanProfile->id)
                ->where('order_type', 'product');
        })->avg('rating') ?? 0;

        $reviewCount = Review::whereHas('order', function ($query) use ($artisanProfile) {
            $query->where('artisan_id', $artisanProfile->id)
                ->where('order_type', 'product');
        })->count();

        return view('content.apps.artisan-products', compact(
            'products',
            'totalProducts',
            'availableProducts',
            'totalStockValue',
            'totalEarnings',
            'avgRating',
            'reviewCount'
        ));
    }
    public function myReviews(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect('/artisan/dashboard')->with('error', 'Artisan profile not found.');
        }

        // Get filter from request
        $filter = $request->query('filter', 'all');

        // Fetch reviews
        $reviewsQuery = Review::where('artisan_id', $artisanProfile->id)
            ->with(['client', 'order'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($filter === 'no-response') {
            $reviewsQuery->where('has_response', false);
        } elseif ($filter === 'positive') {
            $reviewsQuery->where('rating', '>=', 4);
        }

        $reviews = $reviewsQuery->get();

        // Calculate statistics
        $totalReviews = Review::where('artisan_id', $artisanProfile->id)->count();
        $averageRating = Review::where('artisan_id', $artisanProfile->id)->avg('rating') ?? 0;
        $fiveStarReviews = Review::where('artisan_id', $artisanProfile->id)->where('rating', 5)->count();
        $respondedReviews = Review::where('artisan_id', $artisanProfile->id)->where('has_response', true)->count();
        $responseRate = $totalReviews > 0 ? round(($respondedReviews / $totalReviews) * 100) : 0;
        $thisMonthReviews = Review::where('artisan_id', $artisanProfile->id)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        // Calculate rating distribution
        $ratingDistribution = [
            5 => Review::where('artisan_id', $artisanProfile->id)->where('rating', 5)->count(),
            4 => Review::where('artisan_id', $artisanProfile->id)->where('rating', 4)->count(),
            3 => Review::where('artisan_id', $artisanProfile->id)->where('rating', 3)->count(),
            2 => Review::where('artisan_id', $artisanProfile->id)->where('rating', 2)->count(),
            1 => Review::where('artisan_id', $artisanProfile->id)->where('rating', 1)->count(),
        ];

        // Get last 7 days of reviews for chart
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = Review::where('artisan_id', $artisanProfile->id)
                ->whereDate('created_at', $date)
                ->count();
            $last7Days[] = $count;
        }

        return view('content.apps.artisan-reviews', [
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => round($averageRating, 1),
            'fiveStarReviews' => $fiveStarReviews,
            'fiveStarPercentage' => $totalReviews > 0 ? round(($fiveStarReviews / $totalReviews) * 100) : 0,
            'responseRate' => $responseRate,
            'thisMonthReviews' => $thisMonthReviews,
            'ratingDistribution' => $ratingDistribution,
            'reviewTimeline' => $last7Days,
            'currentFilter' => $filter,
            'artisanProfile' => $artisanProfile,
        ]);
    }

    public function submitReviewReply(Request $request, Review $review)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Authorization check
        if ($review->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Validate
        $validated = $request->validate([
            'response_comment' => 'required|string|min:10|max:1000'
        ]);

        // Update review with response
        $review->update([
            'response_comment' => $validated['response_comment'],
            'response_date' => Carbon::now(),
            'has_response' => true
        ]);

        return redirect()->back()->with('success', 'Reply submitted successfully!');
    }

    public function viewPayments()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect('/artisan/dashboard')->with('error', 'Artisan profile not found.');
        }

        // Calculate earnings and balance
        $totalEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->sum('total_amount') ?? 0;

        $totalPayouts = Payout::where('artisan_id', $artisanProfile->id)
            ->whereIn('status', ['approved', 'processing', 'completed'])
            ->sum('amount') ?? 0;

        $availableBalance = $totalEarnings - $totalPayouts;

        $pendingPayouts = Payout::where('artisan_id', $artisanProfile->id)
            ->whereIn('status', ['pending', 'processing'])
            ->sum('amount') ?? 0;

        // Get last payment
        $lastPayout = Payout::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->latest('processed_at')
            ->first();

        // Get payment methods
        $paynowAccount = PaynowAccount::where('artisan_id', $artisanProfile->id)->first();

        // Get recent transactions (orders with payment status)
        $transactions = Order::where('artisan_id', $artisanProfile->id)
            ->with(['client', 'items'])
            ->latest('created_at')
            ->take(50)
            ->get();

        // Calculate payment methods distribution
        $completedOrdersCount = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->count();

        // Calculate earnings trend (last 7 days)
        $earningsTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $amount = Order::where('artisan_id', $artisanProfile->id)
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount') ?? 0;
            $earningsTrend[] = $amount;
        }

        return view('content.apps.artisan-payments', [
            'totalEarnings' => $totalEarnings,
            'availableBalance' => $availableBalance,
            'pendingPayouts' => $pendingPayouts,
            'lastPayout' => $lastPayout,
            'paynowAccount' => $paynowAccount,
            'transactions' => $transactions,
            'earningsTrend' => $earningsTrend,
            'artisanProfile' => $artisanProfile,
            'completedOrdersCount' => $completedOrdersCount,
        ]);
    }

    public function addPaynowAccount(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->back()->with('error', 'Artisan profile not found.');
        }

        // Check if already has Paynow account
        if (PaynowAccount::where('artisan_id', $artisanProfile->id)->exists()) {
            return redirect()->back()->with('warning', 'You already have a Paynow account linked.');
        }

        $validated = $request->validate([
            'paynow_integration_id' => 'required',
            'paynow_integration_key' => 'required',
        ]);

        PaynowAccount::create([
            'artisan_id' => $artisanProfile->id,
            'paynow_integration_id' => $validated['paynow_integration_id'],
            'paynow_integration_key' => $validated['paynow_integration_key'],
        ]);

        return back()->with('success', 'Paynow account added successfully!');
    }

    public function updatePaynowAccount(Request $request, PaynowAccount $paynowAccount)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Authorization check
        if ($paynowAccount->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'paynow_integration_id' => 'required|string|min:5|max:20',
            'paynow_integration_key' => 'required|string|min:10|max:100',
        ]);

        $paynowAccount->update($validated);

        return redirect()->back()->with('success', 'Paynow account updated successfully!');
    }

    public function deletePaynowAccount(PaynowAccount $paynowAccount)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Authorization check
        if ($paynowAccount->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $paynowAccount->delete();

        return redirect()->back()->with('success', 'Paynow account removed successfully!');
    }

    public function requestPayout(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->back()->with('error', 'Artisan profile not found.');
        }

        // Calculate available balance
        $totalEarnings = Order::where('artisan_id', $artisanProfile->id)
            ->where('status', 'completed')
            ->sum('total_amount') ?? 0;

        $totalPayouts = Payout::where('artisan_id', $artisanProfile->id)
            ->whereIn('status', ['approved', 'processing', 'completed'])
            ->sum('amount') ?? 0;

        $availableBalance = $totalEarnings - $totalPayouts;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000|max:' . $availableBalance,
            'payment_method' => 'required|in:paynow,bank_transfer',
            'notes' => 'nullable|string|max:500'
        ]);

        // Check if has payment method
        if ($validated['payment_method'] === 'paynow' && !PaynowAccount::where('artisan_id', $artisanProfile->id)->exists()) {
            return redirect()->back()->with('error', 'Please add a Paynow account first.');
        }

        Payout::create([
            'artisan_id' => $artisanProfile->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Payout request submitted successfully! Please wait for admin approval.');
    }

    public function verification()
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        // Get national document if exists
        $nationalDocument = NationalDocument::where('user_id', $user->id)->first();

        // Get verification status if exists
        $verification = ArtisanVerification::where('artisan_id', $artisanProfile->id)->first();

        // Check if verified (artisan_verifications status enum uses 'approved')
        $isVerified = $verification && $verification->status === 'approved';

        return view('content.apps.artisan-verification', compact('user', 'artisanProfile', 'nationalDocument', 'verification', 'isVerified'));
    }

    public function uploadNationalDocument(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        // Validate inputs
        $validated = $request->validate([
            'id_number' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'front_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'back_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            // Store front image
            $frontImagePath = $request->file('front_image')->store('national-documents', 'public');

            // Store back image
            $backImagePath = $request->file('back_image')->store('national-documents', 'public');

            // Run OCR on front image
            $ocrService = new OcrService();
            $ocrRawText = '';
            $ocrConfidence = 0;
            $extractedData = [];
            $autoVerified = false;

            try {
                $frontFullPath = Storage::disk('public')->path($frontImagePath);
                $ocrRawText = $ocrService->extractText($frontFullPath);
                $extractedData = $ocrService->parseNationalId($ocrRawText);

                // Calculate confidence by comparing OCR results with user-provided data
                $ocrConfidence = $ocrService->calculateConfidence($extractedData, [
                    'id_number' => $validated['id_number'],
                    'full_name' => $validated['full_name'],
                ]);

                // Check if auto-verification criteria are met
                $autoVerified = $ocrService->shouldAutoVerify(
                    $ocrConfidence,
                    $extractedData['expiry_date'] ?? null
                );
            } catch (\Exception $ocrException) {
                // OCR failed - continue with manual verification
                $ocrRawText = 'OCR processing failed: ' . $ocrException->getMessage();
            }

            // Create or update NationalDocument with OCR data
            $nationalDocument = NationalDocument::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'id_number' => $validated['id_number'],
                    'full_name' => $validated['full_name'],
                    'date_of_birth' => $extractedData['date_of_birth'] ?? null,
                    'issue_date' => $extractedData['issue_date'] ?? null,
                    'expiry_date' => $extractedData['expiry_date'] ?? null,
                    'front_image_path' => $frontImagePath,
                    'back_image_path' => $backImagePath,
                    'ocr_raw_text' => $ocrRawText,
                    'ocr_confidence' => $ocrConfidence,
                    'ocr_extracted_data' => $extractedData,
                    'status' => $autoVerified ? 'verified' : 'pending',
                ]
            );

            // Create or update ArtisanVerification
            $verificationStatus = $autoVerified ? 'approved' : 'pending';
            $verificationRemarks = $autoVerified
                ? 'Auto-verified by OCR with ' . $ocrConfidence . '% confidence'
                : 'Awaiting verification (OCR confidence: ' . $ocrConfidence . '%)';

            $verification = ArtisanVerification::updateOrCreate(
                ['artisan_id' => $artisanProfile->id],
                [
                    'national_id_document_id' => $nationalDocument->id,
                    'verification_method' => 'ocr-assisted',
                    'status' => $verificationStatus,
                    'remarks' => $verificationRemarks,
                    'verified_at' => $autoVerified ? now() : null,
                ]
            );

            // If auto-verified, update artisan profile
            if ($autoVerified) {
                $artisanProfile->update(['verified' => true]);
            }

            // Log the action
            SystemLog::create([
                'user_id' => $user->id,
                'action' => $autoVerified
                    ? 'Document uploaded and auto-verified (confidence: ' . $ocrConfidence . '%)'
                    : 'Document uploaded, pending verification (confidence: ' . $ocrConfidence . '%)',
                'ip_address' => $request->ip(),
            ]);

            $message = $autoVerified
                ? 'Document uploaded and automatically verified! Your profile is now verified.'
                : 'Document uploaded successfully. OCR confidence: ' . $ocrConfidence . '%. Awaiting admin verification.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    public function updateDocumentInfo(Request $request)
    {
        $user = Auth::user();

        // Validate inputs
        $validated = $request->validate([
            'id_number' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
        ]);

        try {
            // Update NationalDocument
            NationalDocument::where('user_id', $user->id)->update([
                'id_number' => $validated['id_number'],
                'full_name' => $validated['full_name'],
            ]);

            return redirect()->back()->with('success', 'Document information updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update information. Please try again.');
        }
    }

    public function orderDetails(Order $order)
    {
        // Get authenticated artisan profile
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Check if order belongs to this artisan
        if ($order->artisan_id !== $artisanProfile->id) {
            return redirect()->route('artisan-my-orders')->with('error', 'Unauthorized access to this order.');
        }

        // Load order with relationships
        $order->load('client', 'items', 'review');

        return view('content.apps.artisan-order-details', compact('order'));
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        $order = Order::find($orderId);

        // Verify the order belongs to this artisan
        if (!$order || $order->artisan_id !== $artisanProfile->id) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized access to this order.'], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized access to this order.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        $message = 'Order status updated to ' . ucfirst($validated['status']) . '!';

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function downloadInvoice($orderId)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        $order = Order::with(['client', 'artisan'])->find($orderId);

        // Verify the order belongs to this artisan
        if (!$order || $order->artisan_id !== $artisanProfile->id) {
            return response()->json(['error' => 'Unauthorized access to this order.'], 403);
        }

        // Generate invoice data for download
        // For now, return success response with order details
        return response()->json([
            'success' => true,
            'message' => 'Invoice ready for download',
            'order' => $order
        ]);
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price_estimate' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'availability' => 'nullable|in:available,unavailable',
        ]);

        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->back()->with('error', 'Please complete your profile first.');
        }

        $validated['artisan_id'] = $artisanProfile->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Remove the image field since it doesn't exist in the database
        unset($validated['image']);

        // Set default availability
        if (!isset($validated['availability'])) {
            $validated['availability'] = 'available';
        }

        ArtisanService::create($validated);

        return redirect()->back()->with('success', 'Service added successfully!');
    }

    public function storeProduct(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'category' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'unit' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'availability' => 'nullable|in:available,unavailable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if (!$artisanProfile) {
            return redirect()->back()->with('error', 'Please complete your profile first.');
        }

        $validated['artisan_id'] = $artisanProfile->id;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Remove the image field since it doesn't exist in the database
        unset($validated['image']);

        // Set default availability
        if (!isset($validated['availability'])) {
            $validated['availability'] = 'available';
        }

        ArtisanGood::create($validated);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function updateService(ArtisanService $service, Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Check authorization
        if ($service->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price_estimate' => 'required|numeric|min:0',
            'availability' => 'boolean',
        ]);

        $validated['artisan_id'] = $artisanProfile->id;

        // Handle image upload if provided
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('services', $fileName, 'public');
            $validated['image_path'] = 'storage/' . $filePath;
        }

        $service->update($validated);

        return redirect()->back()->with('success', 'Service updated successfully!');
    }

    public function deleteService(ArtisanService $service)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Check authorization
        if ($service->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Delete image if exists
        if ($service->image_path && Storage::disk('public')->exists($service->image_path)) {
            Storage::disk('public')->delete($service->image_path);
        }

        $service->delete();

        return redirect()->back()->with('success', 'Service deleted successfully!');
    }

    public function updateProduct(ArtisanGood $product, Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Check authorization
        if ($product->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'availability' => 'nullable|in:available,unavailable,1,0',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }
        unset($validated['image']);

        $product->update($validated);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function updateStock(ArtisanGood $product, Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        if ($product->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'action' => 'required|in:add,reduce',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated['action'] === 'add') {
            $product->stock_quantity += $validated['quantity'];
        } else {
            $product->stock_quantity = max(0, $product->stock_quantity - $validated['quantity']);
        }

        $product->save();

        return redirect()->back()->with('success', 'Stock updated successfully! New stock: ' . $product->stock_quantity);
    }

    public function deleteProduct(ArtisanGood $product)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->first();

        // Check authorization
        if ($product->artisan_id !== $artisanProfile->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Delete image if exists
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    // Profile Edit Methods
    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete old photo if exists
        if ($artisanProfile->profile_photo_path && Storage::disk('public')->exists($artisanProfile->profile_photo_path)) {
            Storage::disk('public')->delete($artisanProfile->profile_photo_path);
        }

        // Store new photo
        $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
        $artisanProfile->update(['profile_photo_path' => $photoPath]);

        return redirect()->back()->with('success', 'Profile photo updated successfully!');
    }

    public function updateBusinessProfile(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'years_of_experience' => 'nullable|integer|min:0|max:70',
            'service_areas' => 'nullable|string|max:500',
        ]);

        $artisanProfile->update($validated);

        return redirect()->back()->with('success', 'Business profile updated successfully!');
    }

    public function updatePersonalDetails(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        // Update user record (users table has name and email, not phone)
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update artisan profile phone (phone lives on artisan_profiles table)
        $artisanProfile->update([
            'phone' => $validated['phone'] ?? $artisanProfile->phone,
        ]);

        return redirect()->back()->with('success', 'Personal details updated successfully!');
    }

    public function updateBankDetails(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'branch_code' => 'required|string|max:20',
            'account_number' => 'required|string|max:50',
            'account_holder_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:100',
        ]);

        PaynowAccount::updateOrCreate(
            ['artisan_id' => $artisanProfile->id],
            $validated
        );

        return redirect()->back()->with('success', 'Bank details updated successfully!');
    }

    public function updateSocialLinks(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:30',
            'website' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
        ]);

        $artisanProfile->update(['social_links' => $validated]);

        return redirect()->back()->with('success', 'Social links updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $artisanProfile = ArtisanProfile::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'public_profile' => 'nullable|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            if ($artisanProfile->profile_photo_path && Storage::disk('public')->exists($artisanProfile->profile_photo_path)) {
                Storage::disk('public')->delete($artisanProfile->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Update user
        $user->update(['email' => $validated['email']]);

        // Update artisan profile
        $artisanProfile->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*[0-9])/',
        ]);

        $user->update(['password' => bcrypt($validated['new_password'])]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

}
