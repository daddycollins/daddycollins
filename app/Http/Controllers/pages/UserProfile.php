<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserProfile extends Controller
{
  public function index()
  {
    // If user is authenticated and has a role-specific profile page, redirect them
    if (Auth::check()) {
      if (Auth::user()->role === 'artisan') {
        return redirect()->route('artisan-profile');
      } elseif (Auth::user()->role === 'client') {
        return redirect()->route('user-profile');
      }
    }

    // For unauthenticated or admin users, show the generic profile page
    return view('content.pages.pages-profile-user');
  }
}
