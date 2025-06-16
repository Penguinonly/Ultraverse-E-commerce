<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Properti;
use App\Models\Pembayaran;
use App\Models\Favorit;

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
        $userRole = $user->peran()->first();
        
        if (!$userRole || !in_array($userRole->nama_peran, $roles)) {
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // Set common session data
        $sessionData = [
            'user_id' => $user->user_id,
            'nama' => $user->nama,
            'email' => $user->email,
            'role' => $userRole->nama_peran
        ];

        // Set role-specific session data
        try {
            switch ($userRole->nama_peran) {
                case 'admin':
                    $sessionData['total_users'] = User::count();
                    $sessionData['total_properti'] = Properti::count();
                    $sessionData['pending_pembayaran'] = Pembayaran::where('status_pembayaran', 'pending')
                        ->whereNull('konfirmasi_pembayaran')
                        ->count();
                    break;

                case 'penjual':
                    $propertiIds = Properti::where('user_id', $user->user_id)->pluck('properti_id');
                    $sessionData['total_properti'] = $propertiIds->count();
                    $sessionData['pending_transaksi'] = Pembayaran::whereIn('transaksi_id', function($query) use ($propertiIds) {
                        $query->select('transaksi_id')
                            ->from('transaksi')
                            ->whereIn('properti_id', $propertiIds);
                    })
                    ->where('status_pembayaran', 'pending')
                    ->count();
                    break;

                case 'pembeli':
                    $sessionData['favorit'] = Favorit::where('user_id', $user->user_id)->count();
                    $sessionData['active_pembayaran'] = Pembayaran::whereIn('transaksi_id', function($query) use ($user) {
                        $query->select('transaksi_id')
                            ->from('transaksi')
                            ->where('user_id', $user->user_id);
                    })
                    ->whereIn('status_pembayaran', ['pending', 'proses'])
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
