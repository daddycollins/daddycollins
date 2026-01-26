<?php

namespace App\Http\Controllers\admin;

use App\Models\Review;
use App\Http\Controllers\Controller;

class ReviewsMonitor extends Controller
{
  public function index()
  {
    // Get all reviews with relationships, paginated
    $reviews = Review::with(['client', 'artisan', 'order'])
      ->latest('created_at')
      ->paginate(10);

    // Calculate statistics
    $totalReviews = Review::count();
    $averageRating = Review::avg('rating');
    $pendingApprovalReviews = Review::where('status', 'pending')->count();
    $flaggedReviews = Review::where('status', 'flagged')->count();

    // Calculate rating distribution
    $fiveStarCount = Review::where('rating', 5)->count();
    $fourStarCount = Review::where('rating', 4)->count();
    $threeStarCount = Review::where('rating', 3)->count();
    $belowThreeCount = Review::where('rating', '<', 3)->count();

    return view('content.apps.admin-review-overview', [
      'reviews' => $reviews,
      'totalReviews' => $totalReviews,
      'averageRating' => round($averageRating, 1),
      'pendingApprovalReviews' => $pendingApprovalReviews,
      'flaggedReviews' => $flaggedReviews,
      'fiveStarCount' => $fiveStarCount,
      'fourStarCount' => $fourStarCount,
      'threeStarCount' => $threeStarCount,
      'belowThreeCount' => $belowThreeCount,
    ]);
  }
}
