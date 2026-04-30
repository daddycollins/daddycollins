<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue');
        }

        // Check if user's role matches allowed roles
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Redirect unauthorized users based on their role
        return $this->redirectByRole(Auth::user()->role);
    }

    /**
     * Redirect user based on their role
     */
    private function redirectByRole($role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin-dashboard')->with('error', 'Unauthorized access'),
            'artisan' => redirect()->route('artisan-dashboard')->with('error', 'Unauthorized access'),
            'client' => redirect()->route('user-dashboard')->with('error', 'Unauthorized access'),
            default => redirect()->route('auth-login-cover')->with('error', 'Unauthorized access'),
        };
    }
}
