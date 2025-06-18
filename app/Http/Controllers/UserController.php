<?php

namespace App\Http\Controllers; // Pastikan namespace ini benar untuk controller

use App\Models\User;
use App\Models\Properti; // Import model Properti
use App\Models\Transaksi; // Import model Transaksi
use App\Models\Pembayaran; // Import model Pembayaran
use App\Models\Favorit;    // Import model Favorit
use App\Models\Pesan;      // Import model Pesan (jika relasi pesan di User.php digunakan)
use App\Models\Notifikasi; // Import model Notifikasi (jika relasi notifikasi di User.php digunakan)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session; // Import Session facade untuk mengambil data dari middleware

class UserController extends Controller
{
    /**
     * Menampilkan dashboard untuk role Pembeli.
     * Dipanggil oleh route 'pembeli.dashboard' di web.php.
     */
    public function pembeliDashboard()
    {
        $user = Auth::user();
        if (!$user) {
            // Ini seharusnya tidak tercapai karena rute dilindungi oleh middleware 'auth'
            return redirect()->route('login');
        }

        // Ambil data dari session yang sudah disiapkan oleh RoleSessionMiddleware
        $totalFavorit = Session::get('total_favorit', 0);
        $activePembayaran = Session::get('active_pembayaran', 0);

        // Pastikan nama view sesuai dengan struktur folder Anda.
        // Berdasarkan screenshot image_a8b122.png, view ada di resources/views/pembeli/dashboard_search.blade.php
        return view('pembeli.dashboard_search', compact('user', 'totalFavorit', 'activePembayaran'));
    }

    /**
     * Menampilkan dashboard untuk role Penjual.
     * Dipanggil oleh route 'penjual.dashboard' di web.php.
     */
    public function penjualDashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil data dari session yang sudah disiapkan oleh RoleSessionMiddleware
        $totalProperti = Session::get('total_properti', 0);
        $pendingTransaksi = Session::get('pending_transaksi', 0);

        // Pastikan nama view sesuai dengan struktur folder Anda.
        // Berdasarkan screenshot image_a8b122.png, view ada di resources/views/penjual/dashboard.blade.php
        return view('penjual.dashboard', compact('user', 'totalProperti', 'pendingTransaksi'));
    }

    /**
     * Menampilkan halaman analitik untuk role Penjual.
     * Dipanggil oleh route 'penjual.analytics' di web.php.
     */
    public function penjualAnalytics()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        // Logic untuk analitik penjual
        return view('penjual.analytics'); // Sesuaikan dengan view analitik penjual Anda
    }

    /**
     * Menampilkan properti favorit pembeli.
     * Dipanggil oleh route 'pembeli.favorit' di web.php.
     */
    public function pembeliFavorit()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        // Garis merah pada `$user->favorit()` (image_b72e3c.png, image_b6d4a4.png, image_b663e8.png)
        // akan hilang setelah Anda memastikan relasi 'favorit()' ada di model User
        // dan relasi 'properti()' ada di model Favorit, dengan primary/foreign key yang benar.
        $favoritProperties = $user->favorit()->with('properti')->get();

        return view('pembeli.favorit', compact('favoritProperties')); // Sesuaikan view Anda
    }

    /**
     * Menampilkan halaman profil user.
     * Dipanggil oleh route 'profile' di web.php.
     */
    public function profile()
    {
        return view('user.profile', ['user' => Auth::user()]); // Sesuaikan view Anda
    }

    /**
     * Memperbarui informasi profil user.
     * Dipanggil oleh route 'profile.update' di web.php.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->user_id.',user_id', // Memastikan email unik kecuali untuk user_id ini
            'no_telepon' => 'required|string',
            'alamat' => 'nullable|string|max:255',
            'nama_toko' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * Memperbarui password user.
     * Dipanggil oleh route 'password.update' di web.php.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}