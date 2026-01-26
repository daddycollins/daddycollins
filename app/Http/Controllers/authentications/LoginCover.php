<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginCover extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-cover', ['pageConfigs' => $pageConfigs]);
  }

  public function store(Request $request)
  {
    // Validate the request
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:8',
    ]);

    // Attempt to authenticate
    if (Auth::attempt($credentials, $request->filled('remember'))) {
      $request->session()->regenerate();
      $user = auth()->user();

      // Redirect based on role
      if ($user->role === 'admin') {
        return redirect()->route('admin-dashboard')->with('success', 'Login successful!');
      } elseif ($user->role === 'artisan') {
        return redirect()->route('artisan-dashboard')->with('success', 'Login successful!');
      } else {
        return redirect()->route('user-dashboard')->with('success', 'Login successful!');
      }
    }

    return redirect()->back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }
}
