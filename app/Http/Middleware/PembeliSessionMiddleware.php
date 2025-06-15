<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembeliSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'pembeli') {
            Auth::logout();
            return redirect()->route('auth.login')
                ->with('error', 'Unauthorized access. Please login as a buyer.');
        }

        // Set session data for pembeli
        session([
            'role' => 'pembeli',
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'last_activity' => now(),
        ]);

        return $next($request);
    }
}
