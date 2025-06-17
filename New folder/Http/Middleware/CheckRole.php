<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->session()->has('user')) {
            return redirect('/signIn')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = $request->session()->get('user')['role'];

        if (empty($roles) || in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
