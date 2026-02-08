<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagement extends Controller
{
  public function index()
  {
    $users = User::with('artisanProfile')
      ->withCount(['orders', 'reviews'])
      ->paginate(15);

    $totalUsers = User::count();
    $activeUsers = User::where('status', 'active')->count();
    $suspendedUsers = User::where('status', 'suspended')->count();
    $verifiedArtisans = User::whereHas('artisanProfile', function ($query) {
      $query->where('verified', true);
    })->count();

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

  public function suspend(User $user, Request $request)
  {
    $user->update(['status' => 'suspended']);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Suspended user: ' . $user->name . ' (ID: ' . $user->id . ')',
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', $user->name . ' has been suspended successfully.');
  }

  public function activate(User $user, Request $request)
  {
    $user->update(['status' => 'active']);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Activated user: ' . $user->name . ' (ID: ' . $user->id . ')',
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', $user->name . ' has been activated successfully.');
  }

  public function update(User $user, Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255|unique:users,email,' . $user->id,
      'role' => 'required|in:artisan,client,admin',
      'status' => 'required|in:active,suspended',
    ]);

    $user->update($validated);

    SystemLog::create([
      'user_id' => Auth::id(),
      'action' => 'Updated user details: ' . $user->name . ' (ID: ' . $user->id . ')',
      'ip_address' => $request->ip(),
    ]);

    return redirect()->back()->with('success', $user->name . '\'s details have been updated successfully.');
  }
}
