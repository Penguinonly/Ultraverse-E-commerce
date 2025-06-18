<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Properti;
use App\Models\Transaksi;
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
            // Log for debugging
            Log::warning('RoleSessionMiddleware: User not authenticated. Redirecting to login.');

            // Jika user mencoba mengakses rute admin tanpa login, arahkan ke login admin
            if ($request->routeIs('admin.*')) {
                return redirect()->route('admin.login');
            }
            // Untuk rute lain (umum), redirect ke login umum
            return redirect()->route('login'); // Sesuaikan nama rute login umum Anda jika berbeda
        }

        /** @var \App\Models\User $user */
        $user = Auth::user(); // Dapatkan objek user yang sedang login

        // Pengecekan tambahan: Pastikan user aktif
        // Logika ini SEHARUSNYA sudah ditangani di AuthController.
        // Namun, sebagai lapisan pengaman, kita bisa tambahkan di sini juga.
        if (!$user->is_active) {
            Auth::logout(); // Logout user yang tidak aktif
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::warning('RoleSessionMiddleware: Inactive user tried to access, logging out.', ['user_id' => $user->user_id]);
            return redirect()->route('login')->with('error', 'Akun Anda belum aktif. Mohon hubungi administrator.');
        }

        // 2. Cek apakah user memiliki peran yang diizinkan untuk rute ini.
        if (!in_array($user->role, $roles)) {
            Log::warning('RoleSessionMiddleware: User role mismatch. User: ' . $user->role . ', Required: ' . implode(', ', $roles), ['user_id' => $user->user_id, 'path' => $request->path()]);
            // Jika user tidak memiliki peran yang dibutuhkan, arahkan ke dashboard mereka atau halaman 403.
            // Gunakan redirect ke dashboard utama yang akan mengarahkan ulang berdasarkan role.
            return redirect()->route('dashboard') // Menggunakan 'dashboard' rute umum
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            // Alternatif yang lebih ketat: abort(403, 'Unauthorized action.');
        }

        // --- START: Logika manajemen sesi ---
        $request->session()->put('is_logged_in_session', true);
        $request->session()->put('last_activity', now());
        // --- END: Logika manajemen sesi ---

        // 3. Set data sesi umum dari user yang login.
        $sessionData = [
            'user_id' => $user->user_id,
            'nama' => $user->nama,
            'email' => $user->email,
            'role' => $user->role,
            'no_telepon' => $user->no_telepon,
            'alamat' => $user->alamat,
            'nama_toko' => $user->nama_toko,
            'is_active' => $user->is_active,
            'pendapatan_perbulan' => $user->pendapatan_perbulan ?? 0, // Berikan default jika null
        ];

        // 4. Set data sesi spesifik peran.
        try {
            switch ($user->role) {
                case 'admin':
                    $sessionData['total_users'] = User::count();
                    $sessionData['total_properti'] = Properti::count();
                    // Pastikan kolom 'konfirmasi_pembayaran' ada dan sesuai tipenya (boolean atau tinyint)
                    $sessionData['pending_pembayaran'] = Pembayaran::where('konfirmasi_pembayaran', false)->count();
                    break;

                case 'penjual':
                    // Pastikan relasi $user->properti() ada di model User
                    // Dan pastikan user_id di tabel 'properti' cocok dengan primary key di tabel 'users'
                    $propertiIds = $user->properti()->pluck('properti_id');
                    $sessionData['total_properti'] = $propertiIds->count();

                    // Pastikan struktur tabel 'transaksi' (kolom properti_id) dan 'pembayaran' (kolom transaksi_id, status_pembayaran, konfirmasi_pembayaran) cocok
                    $sessionData['pending_transaksi'] = Pembayaran::whereIn('transaksi_id', function ($query) use ($propertiIds) {
                        $query->select('transaksi_id')
                            ->from('transaksi')
                            ->whereIn('properti_id', $propertiIds);
                    })
                    ->where('status_pembayaran', 'pending')
                    ->where('konfirmasi_pembayaran', false) // Ini sudah ada, tapi jika 'konfirmasi_pembayaran' bisa null, sesuaikan
                    ->count();
                    break;

                case 'pembeli':
                    // Pastikan relasi $user->favorit() ada di model User
                    $sessionData['total_favorit'] = $user->favorit()->count();

                    // Pastikan struktur tabel 'transaksi' (kolom pembeli_id) dan 'pembayaran' cocok
                    $sessionData['active_pembayaran'] = Pembayaran::whereIn('transaksi_id', function ($query) use ($user) {
                        $query->select('transaksi_id')
                            ->from('transaksi')
                            ->where('pembeli_id', $user->user_id); // Asumsi kolom foreign key di 'transaksi' adalah 'pembeli_id'
                    })
                    // Logika ini terlihat sedikit membingungkan:
                    // ->whereNull('konfirmasi_pembayaran')
                    // ->orWhere('status_pembayaran', 'pending')
                    // Biasanya, kita ingin transaksi yang *belum selesai* atau *menunggu konfirmasi*
                    // Mari kita perjelas:
                    ->where(function($query) {
                        $query->whereNull('konfirmasi_pembayaran') // Belum dikonfirmasi (misal: masih menunggu bukti bayar)
                              ->orWhere('status_pembayaran', 'pending'); // Atau status pembayaran masih pending
                    })
                    ->count();
                    break;
            }
        } catch (\Exception $e) {
            Log::error('RoleSessionMiddleware - Session data error: ' . $e->getMessage() . ' for user_id: ' . ($user->user_id ?? 'N/A'));
            // Jangan hentikan request, biarkan berlanjut tanpa data sesi spesifik jika ada error query database.
            // Anda bisa menambahkan data default jika terjadi error:
            // $sessionData['total_users'] = 0; // atau sesuai default yang Anda inginkan
        }

        // 5. Simpan semua data sesi ke session Laravel.
        // HATI-HATI: Jangan menimpa seluruh session dengan $sessionData.
        // Sebaiknya gunakan put() untuk menambahkan atau memperbarui key tertentu.
        // Jika Anda hanya ingin menyimpan data ini di bawah satu key, misalnya 'user_session_data':
        // $request->session()->put('user_session_data', $sessionData);
        // Jika Anda ingin setiap key dari $sessionData langsung di root session:
        foreach ($sessionData as $key => $value) {
            $request->session()->put($key, $value);
        }

        return $next($request);
    }
}