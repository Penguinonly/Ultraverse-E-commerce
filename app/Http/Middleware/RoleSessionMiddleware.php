<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session; // Pastikan ini di-import jika menggunakan Session::put() langsung
use App\Models\User;
use App\Models\Properti;
use App\Models\Transaksi; // Pastikan model Transaksi sudah ada
use App\Models\Pembayaran;
use App\Models\Favorit;
use Symfony\Component\HttpFoundation\Response;

class RoleSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles // Untuk menerima multiple roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login.
        if (!Auth::check()) {
            Log::warning('RoleSessionMiddleware: User not authenticated. Redirecting to login.');
            // Jika user mencoba mengakses rute admin tanpa login, arahkan ke login admin
            if ($request->routeIs('admin.*')) {
                return redirect()->route('admin.login'); // Pastikan rute ini ada
            }
            // Untuk rute lain (umum), redirect ke login umum
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user(); // Dapatkan objek user yang sedang login

        // Pengecekan tambahan: Pastikan user aktif. Logika ini SEHARUSNYA sudah ditangani di AuthController.
        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::warning('RoleSessionMiddleware: Inactive user tried to access, logging out.', ['user_id' => $user->user_id]);
            return redirect()->route('login')->with('error', 'Akun Anda belum aktif. Mohon hubungi administrator.');
        }

        // 2. Cek apakah user memiliki peran yang diizinkan untuk rute ini.
        if (!in_array($user->role, $roles)) {
            Log::warning('RoleSessionMiddleware: User role mismatch. User: ' . $user->role . ', Required: ' . implode(', ', $roles), ['user_id' => $user->user_id, 'path' => $request->path()]);
            // Arahkan ke dashboard mereka atau halaman 403.
            return redirect()->route('dashboard') // Menggunakan 'dashboard' rute umum
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            // Alternatif yang lebih ketat: abort(403, 'Unauthorized action.');
        }

        // --- START: Logika manajemen sesi umum ---
        // Ini adalah contoh data sesi yang bisa digunakan di seluruh aplikasi
        Session::put('is_logged_in_session', true);
        Session::put('last_activity', now());
        Session::put('user_id', $user->user_id);
        Session::put('nama', $user->nama);
        Session::put('email', $user->email);
        Session::put('role', $user->role);
        Session::put('no_telepon', $user->no_telepon);
        Session::put('alamat', $user->alamat);
        Session::put('nama_toko', $user->nama_toko);
        Session::put('is_active', $user->is_active);
        Session::put('pendapatan_perbulan', $user->pendapatan_perbulan ?? 0); // Berikan default jika null
        // --- END: Logika manajemen sesi umum ---

        // 3. Set data sesi spesifik peran.
        try {
            switch ($user->role) {
                case 'admin':
                    Session::put('total_users', User::count());
                    Session::put('total_properti', Properti::count());
                    Session::put('pending_pembayaran', Pembayaran::where('konfirmasi_pembayaran', false)->count());
                    break;

                case 'penjual':
                    // Pastikan relasi $user->properti() ada di model User
                    // Menggunakan ID user langsung untuk relasi
                    Session::put('total_properti', Properti::where('user_id', $user->user_id)->count());

                    // Ambil transaksi_id yang terkait dengan properti milik penjual
                    $transaksiIdsDariPropertiPenjual = Transaksi::whereIn('properti_id', function ($query) use ($user) {
                        $query->select('properti_id')
                              ->from('properti')
                              ->where('user_id', $user->user_id);
                    })->pluck('transaksi_id'); // Ambil koleksi transaksi_id

                    // Hitung pembayaran yang pending untuk transaksi tersebut
                    Session::put('pending_transaksi', Pembayaran::whereIn('transaksi_id', $transaksiIdsDariPropertiPenjual)
                        ->where(function($query) {
                            $query->where('status_pembayaran', 'pending')
                                  ->orWhere('konfirmasi_pembayaran', false); // Jika 'konfirmasi_pembayaran' bisa null, ini perlu
                        })
                        ->count());
                    break;

                case 'pembeli':
                    // Pastikan relasi $user->favorit() ada di model User
                    Session::put('total_favorit', $user->favorit()->count());

                    // Ambil transaksi_id yang terkait dengan pembeli
                    $transaksiIdsDariPembeli = Transaksi::where('pembeli_id', $user->user_id)
                                                    ->pluck('transaksi_id');

                    // Hitung pembayaran aktif untuk pembeli
                    Session::put('active_pembayaran', Pembayaran::whereIn('transaksi_id', $transaksiIdsDariPembeli)
                        ->where(function($query) {
                            $query->whereNull('konfirmasi_pembayaran') // Belum dikonfirmasi (misal: masih menunggu bukti bayar)
                                  ->orWhere('status_pembayaran', 'pending'); // Atau status pembayaran masih pending
                        })
                        ->count());
                    break;
            }
        } catch (\Exception $e) {
            Log::error('RoleSessionMiddleware - Session data error: ' . $e->getMessage() . ' for user_id: ' . ($user->user_id ?? 'N/A') . ' at line ' . $e->getLine());
            // Dalam produksi, Anda mungkin ingin melakukan hal lain jika ada error fatal di sini,
            // seperti me-redirect ke halaman error atau hanya melewati data sesi jika gagal.
            // Untuk debugging, Log::error() sudah cukup.
        }

        return $next($request);
    }
}