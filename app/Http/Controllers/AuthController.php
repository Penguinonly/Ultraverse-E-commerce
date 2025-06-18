<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Pastikan ini ada

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Jika user sudah login, arahkan ke dashboard
        if (Auth::check()) {
            // Asumsikan 'dashboard' adalah rute umum setelah login
            $user = Auth::user();
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'penjual' => redirect()->route('penjual.dashboard'),
                'pembeli' => redirect()->route('pembeli.dashboard'),
                default => redirect()->route('home'), // Default jika role tidak dikenali
            };
        }
        return view('Home.signIn');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            // Validasi input
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Coba autentikasi pengguna
            // Auth::attempt akan memeriksa kredensial DAN status 'is_active' secara default
            // jika provider User Anda menggunakan model Eloquent dan memiliki kolom 'is_active'.
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate(); // Regenerasi sesi untuk keamanan
                $user = Auth::user(); // Dapatkan objek user yang sudah terautentikasi

                // Log informasi login berhasil (untuk audit/debugging di production)
                Log::info('✅ Login berhasil', [
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_active_status' => (bool)$user->is_active, // Konfirmasi status aktif dari objek user
                ]);

                // Ini adalah pengecekan lapisan kedua untuk is_active
                // Jika is_active diset false saat registrasi, blok ini akan memicu
                // dan mencegah user yang belum diaktifkan masuk.
                if (!$user->is_active) { //
                    Auth::logout(); // Logout user yang tidak aktif
                    Log::warning('⛔ User belum aktif (di-logout setelah berhasil Auth::attempt)', [
                        'email' => $user->email
                    ]);
                    return back()->withErrors([
                        'email' => 'Akun Anda belum diaktifkan. Silakan hubungi admin.',
                    ])->withInput($request->only('email'));
                }

                // Redirect berdasarkan role setelah login berhasil dan akun aktif
                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'penjual' => redirect()->route('penjual.dashboard'),
                    'pembeli' => redirect()->route('pembeli.dashboard'),
                    default => redirect()->route('home'), // Default jika role tidak dikenali
                };
            }

            // Jika Auth::attempt() gagal (kredensial tidak cocok atau user tidak ditemukan)
            Log::warning('❌ Login gagal: Email atau password salah', [
                'input_email' => $credentials['email']
            ]);
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi input form
            Log::warning('⚠️ Validasi login gagal: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput($request->only('email'));
        } catch (\Exception $e) {
            // Tangani error tak terduga lainnya
            Log::error('‼️ Login error tak terduga: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile(), ['exception' => $e]);
            return back()->withErrors([
                'error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'penjual' => redirect()->route('penjual.dashboard'),
                'pembeli' => redirect()->route('pembeli.dashboard'),
                default => redirect()->route('home'),
            };
        }
        return view('Home.create');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'no_telepon' => 'required|string|max:20',
            'nama_toko' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = $request->filled('nama_toko') ? 'penjual' : 'pembeli';

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'nama_toko' => $request->nama_toko,
            'role' => $role,
            'is_active' => false, // Default: user baru belum aktif, perlu diaktifkan admin
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan tunggu aktivasi oleh admin.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}