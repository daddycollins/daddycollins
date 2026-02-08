<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Review;
use App\Models\SystemLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsMonitor extends Controller
{
  public function index()
  {
    $reviews = Review::with(['client', 'artisan.user', 'order'])
      ->latest('created_at')
      ->paginate(10);

    $totalReviews = Review::count();
    $averageRating = Review::avg('rating');
    $reviewsAwaitingResponse = Review::where('has_response', false)->count();
    $reviewsWithResponse = Review::where('has_response', true)->count();

    $fiveStarCount = Review::where('rating', 5)->count();
    $fourStarCount = Review::where('rating', 4)->count();
    $threeStarCount = Review::where('rating', 3)->count();
    $belowThreeCount = Review::where('rating', '<', 3)->count();

    $thisMonthReviews = Review::whereBetween('created_at', [
      Carbon::now()->startOfMonth(),
      Carbon::now()->endOfMonth()
    ])->count();
    $responseRate = $totalReviews > 0 ? round(($reviewsWithResponse / $totalReviews) * 100) : 0;

    return view('content.apps.admin-review-overview', [
      'reviews' => $reviews,
      'totalReviews' => $totalReviews,
      'averageRating' => round($averageRating, 1),
      'reviewsAwaitingResponse' => $reviewsAwaitingResponse,
      'reviewsWithResponse' => $reviewsWithResponse,
      'fiveStarCount' => $fiveStarCount,
      'fourStarCount' => $fourStarCount,
      'threeStarCount' => $threeStarCount,
      'belowThreeCount' => $belowThreeCount,
      'thisMonthReviews' => $thisMonthReviews,
      'responseRate' => $responseRate,
    ]);
  }

  public function feature(Review $review, Request $request)
  {
    $review->update(['is_featured' => !$review->is_featured]);

    $action = $review->is_featured ? 'Featured' : 'Unfeatured';

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => $action . ' review #' . $review->id . ' by ' . ($review->client?->name ?? 'Unknown'),
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Review has been ' . strtolower($action) . ' successfully.');
  }

  public function update(Review $review, Request $request)
  {
    $validated = $request->validate([
      'comment' => 'required|string|min:3|max:2000',
      'rating' => 'required|integer|min:1|max:5',
    ]);

    $review->update($validated);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Edited review #' . $review->id . ' by ' . ($review->client?->name ?? 'Unknown'),
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Review has been updated successfully.');
  }

  public function remove(Review $review, Request $request)
  {
    $request->validate([
      'hidden_reason' => 'required|string|max:255',
    ]);

    $review->update([
      'is_hidden' => true,
      'hidden_reason' => $request->input('hidden_reason'),
    ]);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Removed review #' . $review->id . ' as inappropriate. Reason: ' . $request->input('hidden_reason'),
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Review has been removed as inappropriate.');
  }

  public function restore(Review $review, Request $request)
  {
    $review->update([
      'is_hidden' => false,
      'hidden_reason' => null,
    ]);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Restored review #' . $review->id,
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', 'Review has been restored successfully.');
  }
}
