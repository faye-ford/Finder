<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Access denied. Admin privileges required.');
        }

        // Store role in session for easy access
        session(['role' => 'admin', 'is_admin' => true]);

        return $next($request);
    }
}