<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $redirectToRoute = null): Response
    {
        // Jika user belum login, arahkan ke halaman login
        if (! $request->user()) {
            return redirect()->route('auth.login');
        }

        // Daftar route yang tidak memerlukan verifikasi email
        $excludedRoutes = [
            'profile.*',
            'profile.show',
            'dokumen',
            'dokumen.index'
        ];

        // Cek apakah route saat ini termasuk dalam pengecualian
        foreach ($excludedRoutes as $route) {
            if ($request->routeIs($route)) {
                return $next($request);
            }
        }

        // Untuk route lain, cek verifikasi email
        if ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail()) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
