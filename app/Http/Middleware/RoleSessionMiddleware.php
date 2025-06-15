<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\SavedProperty;

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
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->role, $roles)) {
            return redirect()->route($user->role . '.dashboard')
                ->with('error', 'Unauthorized access.');
        }

        // Set common session data
        $sessionData = [
            'user_id' => $user->user_id,
            'nama' => $user->nama,
            'email' => $user->email,
            'role' => $user->role
        ];

        // Set role-specific session data
        try {
            switch ($user->role) {
                case 'admin':
                    $sessionData['total_users'] = User::count();
                    $sessionData['total_properties'] = Property::count();
                    $sessionData['pending_verifications'] = User::where('is_verified', false)->count();
                    break;

                case 'penjual':
                    $sessionData['properties_count'] = Property::where('user_id', $user->user_id)->count();
                    $sessionData['pending_transactions'] = Payment::where('seller_id', $user->user_id)
                        ->where('status', 'pending')
                        ->count();
                    break;

                case 'pembeli':
                    $sessionData['saved_properties'] = SavedProperty::where('user_id', $user->user_id)->count();
                    $sessionData['active_transactions'] = Payment::where('buyer_id', $user->user_id)
                        ->whereIn('status', ['pending', 'processing'])
                        ->count();
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Session data error: ' . $e->getMessage());
            // Continue without the additional session data
        }

        // Store session data
        $request->session()->put($sessionData);

        return $next($request);
    }
}
