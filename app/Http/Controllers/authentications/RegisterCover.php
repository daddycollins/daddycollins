<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use App\Models\ArtisanProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterCover extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function store(Request $request)
  {
    // Validate the request
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8|confirmed',
      'role' => 'required|in:artisan,client',
      'terms' => 'accepted',
      // Artisan-specific fields
      'business_name' => 'required_if:role,artisan|string|max:255',
      'category' => 'required_if:role,artisan|string|max:255',
      'location' => 'required_if:role,artisan|string|max:255',
      'bio' => 'nullable|string|max:1000',
    ], [
      'business_name.required_if' => 'Business name is required for artisans',
      'category.required_if' => 'Category is required for artisans',
      'location.required_if' => 'Location is required for artisans',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    // Create the user
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
      'status' => 'active',
      'email_verified_at' => now(),
    ]);

    // If registering as artisan, create artisan profile
    if ($request->role === 'artisan') {
      ArtisanProfile::create([
        'user_id' => $user->id,
        'business_name' => $request->business_name,
        'category' => $request->category,
        'location' => $request->location,
        'bio' => $request->bio,
        'verified' => false,
        'average_rating' => 0,
      ]);
    }

    // Log the user in
    auth()->login($user);

    // Redirect based on role
    if ($user->role === 'artisan') {
      return redirect()->route('artisan-dashboard')->with('success', 'Registration successful! Welcome to ArtisanConnect.');
    } else {
      return redirect()->route('user-dashboard')->with('success', 'Registration successful! Welcome to ArtisanConnect.');
    }
  }
}
