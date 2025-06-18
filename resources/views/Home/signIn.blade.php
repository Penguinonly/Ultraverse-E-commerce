<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Pastikan ini di-import jika Anda menggunakan Session

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Sesuaikan dengan path view login Anda
    }

    /**
     * Menangani percobaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba melakukan autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Debugging (opsional, bisa dihapus setelah masalah teratasi)
            // Uncomment baris ini untuk melihat data user setelah login
            // dd($user->role, $user->is_active);

            if ($user->is_active) { // Pastikan user aktif
                // Logika pengalihan berdasarkan role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->intended(route('admin.dashboard'));
                    case 'penjual':
                        return redirect()->intended(route('penjual.dashboard'));
                    case 'pembeli':
                        return redirect()->intended(route('pembeli.dashboard'));
                    default:
                        // Fallback jika role tidak dikenali
                        Auth::logout();
                        return back()->withErrors([
                            'email' => 'Role pengguna tidak valid atau tidak dikenali.',
                        ])->onlyInput('email');
                }
            } else {
                // Jika user tidak aktif, logout dan kirim pesan error
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    /**
     * Menangani logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect ke halaman utama atau login
    }
}