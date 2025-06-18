<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // Tambahkan ini jika perlu untuk debugging atau manipulasi session

class AdminLoginController extends Controller
{
    // Menampilkan form login admin
    public function showLoginForm()
    {
        // Jika admin sudah login (menggunakan guard 'web' dan role 'admin'), redirect langsung ke dashboard admin
        // Ini mencegah admin yang sudah login melihat form login lagi
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin-login'); // Sesuaikan path view Anda
    }

    // Memproses permintaan login admin
    public function login(Request $request)
    {
        // Validasi input email dan password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login menggunakan guard 'web' (karena semua user di tabel 'users')
        // Auth::attempt() akan mencoba mencocokkan kredensial dengan database.
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::guard('web')->user(); // Dapatkan objek user yang baru saja login

            // Setelah autentikasi berhasil, periksa apakah user memiliki peran 'admin'
            if ($user->role === 'admin') {
                // Regenerasi ID sesi untuk mencegah session fixation attacks
                $request->session()->regenerate();

                // Redirect ke dashboard admin yang dituju
                return redirect()->intended(route('admin.dashboard'));
            } else {
                // Jika user login tapi bukan admin, logout mereka dari guard 'web'
                Auth::guard('web')->logout();
                $request->session()->invalidate(); // Hancurkan semua data sesi
                $request->session()->regenerateToken(); // Regenerasi token CSRF

                // Redirect kembali ke halaman login dengan pesan error
                return back()->withErrors([
                    'email' => 'Anda tidak memiliki hak akses admin.',
                ])->onlyInput('email');
            }
        }

        // Jika Auth::attempt() gagal (kredensial tidak cocok)
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    // Logout admin
    public function logout(Request $request)
    {
        // Logout dari guard 'web' (yang digunakan admin)
        Auth::guard('web')->logout();

        $request->session()->invalidate(); // Hancurkan semua data sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect()->route('admin.login'); // Redirect kembali ke halaman login admin
    }
}