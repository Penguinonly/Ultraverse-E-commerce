<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'penjual') {
            return redirect()->route('auth.login')->with('error', 'Unauthorized access. Please login as a seller.');
        }

        // Check if session is still valid
        if (!$request->session()->has('penjual_session')) {
            $request->session()->put('penjual_session', true);
            $request->session()->put('last_activity', now());
        }

        // Update last activity
        $request->session()->put('last_activity', now());

        return $next($request);
    }
}
