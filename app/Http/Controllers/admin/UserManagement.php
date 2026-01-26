<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ArtisanVerification;

class UserManagement extends Controller
{
  public function index()
  {
    // Get paginated users with artisan profile eager loaded
    $users = User::with('artisanProfile')
      ->paginate(15); // 15 users per page

    // Calculate statistics
    $totalUsers = User::count();
    $activeUsers = User::where('status', 'active')->count();
    $suspendedUsers = User::where('status', 'suspended')->count();
    $verifiedArtisans = User::whereHas('artisanProfile', function ($query) {
      $query->where('verified', true);
    })->count();

    // Calculate percentages
    $activePercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0;
    $suspendedPercentage = $totalUsers > 0 ? round(($suspendedUsers / $totalUsers) * 100, 1) : 0;
    $verifiedPercentage = $totalUsers > 0 ? round(($verifiedArtisans / $totalUsers) * 100, 1) : 0;

    return view('content.apps.user-management', [
      'users' => $users,
      'totalUsers' => $totalUsers,
      'activeUsers' => $activeUsers,
      'suspendedUsers' => $suspendedUsers,
      'verifiedArtisans' => $verifiedArtisans,
      'activePercentage' => $activePercentage,
      'suspendedPercentage' => $suspendedPercentage,
      'verifiedPercentage' => $verifiedPercentage,
    ]);
  }
}
