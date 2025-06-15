<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Property;
use App\Models\SavedProperty;
use App\Models\Payment;
use App\Models\User;

class UltraverseSessionMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('auth.login')
                    ->with('error', 'Silakan login terlebih dahulu.');
            }

            $user = Auth::user();

            if ($user->role !== $role) {
                Auth::logout();
                Session::flush();
                return redirect()->route('auth.login')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Base session data for all roles
            $sessionData = [
                'user_id' => $user->user_id,
                'nama' => $user->nama,
                'email' => $user->email,
                'role' => $user->role,
                'no_telepon' => $user->no_telepon,
                'alamat' => $user->alamat,
                'last_activity' => now()
            ];

            // Add role-specific session data
            switch ($role) {
                case 'admin':
                    $sessionData['admin_level'] = 'super_admin';
                    $sessionData['admin_permissions'] = ['manage_users', 'manage_properties', 'manage_transactions'];
                    $sessionData['stats'] = [
                        'total_users' => User::count(),
                        'pending_verifications' => User::where('verifikasi_wajah', null)->count(),
                        'total_properties' => Property::count(),
                        'total_transactions' => Payment::count(),
                    ];
                    break;

                case 'penjual':
                    $sessionData['verifikasi_status'] = !empty($user->verifikasi_wajah);
                    $sessionData['dokumen_status'] = !empty($user->foto_ktp);
                    $sessionData['stats'] = [
                        'listed_properties' => Property::where('user_id', $user->user_id)->count(),
                        'active_listings' => Property::where('user_id', $user->user_id)
                            ->where('status', 'active')
                            ->count(),
                        'total_transactions' => Payment::whereHas('property', function($query) use ($user) {
                            $query->where('user_id', $user->user_id);
                        })->count(),
                        'pending_verifications' => Property::where('user_id', $user->user_id)
                            ->where('status', 'pending')
                            ->count()
                    ];
                    break;

                case 'pembeli':
                    $sessionData['pendapatan_perbulan'] = $user->pendapatan_perbulan;
                    $sessionData['stats'] = [
                        'saved_properties' => SavedProperty::where('user_id', $user->user_id)->count(),
                        'active_transactions' => Payment::where('user_id', $user->user_id)
                            ->whereIn('status', ['pending', 'processing'])
                            ->count(),
                        'completed_transactions' => Payment::where('user_id', $user->user_id)
                            ->where('status', 'completed')
                            ->count()
                    ];
                    break;
            }

            session($sessionData);

            // Log session activity
            Log::info("User session started", [
                'user_id' => $user->user_id,
                'role' => $role,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return $next($request);
        } catch (\Exception $e) {
            Log::error("Session middleware error", [
                'error' => $e->getMessage(),
                'user_id' => Auth::id() ?? 'not_authenticated',
                'role' => $role
            ]);

            Auth::logout();
            Session::flush();
            
            return redirect()->route('auth.login')
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }
}
