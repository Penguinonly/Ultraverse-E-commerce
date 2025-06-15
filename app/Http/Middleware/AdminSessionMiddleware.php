<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('auth.login')->with('error', 'Unauthorized access. Please login as admin.');
        }

        // Check if session is still valid
        if (!$request->session()->has('admin_session')) {
            $request->session()->put('admin_session', true);
            $request->session()->put('last_activity', now());
        }

        // Update last activity
        $request->session()->put('last_activity', now());

        return $next($request);
    }
}
