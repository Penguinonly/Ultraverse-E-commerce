<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            Auth::logout();
            Session::flush();
            
            return redirect()->route('auth.login')
                ->with('error', 'Unauthorized access. Please login with correct role.');
        }

        // Set role-based session data
        $user = Auth::user();
        $sessionData = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $role,
            'last_activity' => now(),
            'is_verified' => $user->is_verified
        ];

        // Add role-specific session data
        switch ($role) {
            case 'admin':
                $sessionData['admin_access_level'] = 'full';
                break;
                
            case 'penjual':
                $sessionData['properties_count'] = $user->properties()->count();
                $sessionData['pending_transactions'] = $user->sellerPayments()
                    ->where('status', 'pending')
                    ->count();
                break;
                
            case 'pembeli':
                $sessionData['saved_properties'] = $user->savedProperties()->count();
                $sessionData['active_transactions'] = $user->buyerPayments()
                    ->where('status', 'pending')
                    ->count();
                break;
        }

        session($sessionData);

        // Update last activity
        $user->session()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'last_activity' => now()->timestamp
            ]
        );

        return $next($request);
    }
}
