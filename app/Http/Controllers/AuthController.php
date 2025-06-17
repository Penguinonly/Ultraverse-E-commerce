<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('Home.signIn');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            Log::info('🟡 Attempting login with:', ['email' => $credentials['email']]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();

                Log::info('✅ Auth successful for:', ['email' => $user->email, 'role' => $user->role, 'is_active' => $user->is_active]);

                if (!$user->is_active) {
                    Auth::logout();
                    Log::warning('⛔ User not active:', ['email' => $user->email]);
                    return back()->withErrors([
                        'email' => 'Akun Anda belum diaktifkan. Silakan hubungi admin.',
                    ])->withInput($request->only('email'));
                }

                return match($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'penjual' => redirect()->route('penjual.dashboard'),
                    'pembeli' => redirect()->route('pembeli.dashboard'),
                    default => redirect()->route('home'),
                };
            }

            Log::warning('❌ Login failed for:', ['email' => $credentials['email']]);

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        } catch (\Exception $e) {
            Log::error('‼️ Login error: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan. Silakan coba lagi.'
            ]);
        }
    }

    // public function login(Request $request)
    // {
    //     try {
    //         $credentials = $request->only('email', 'password');

    //         $request->validate([
    //             'email' => ['required', 'email'],
    //             'password' => ['required'],
    //         ]);

    //         if (Auth::attempt($credentials, $request->boolean('remember'))) {
    //             $request->session()->regenerate();

    //             $user = Auth::user();

    //             // Check if user is active
    //             if (!$user->is_active) {
    //                 Auth::logout();
    //                 return back()->withErrors([
    //                     'email' => 'Akun Anda belum diaktifkan. Silakan hubungi admin.',
    //                 ])->withInput($request->only('email'));
    //             }

    //             // Redirect based on role
    //             return match($user->role) {
    //                 'admin' => redirect()->route('admin.dashboard'),
    //                 'penjual' => redirect()->route('penjual.dashboard'),
    //                 'pembeli' => redirect()->route('pembeli.dashboard'),
    //                 default => redirect()->route('home'),
    //             };
    //         }

    //         return back()->withErrors([
    //             'email' => 'Email atau password salah.',
    //         ])->withInput($request->only('email'));
    //     } catch (\Exception $e) {
    //         Log::error('Login error: ' . $e->getMessage());
    //         return back()->withErrors([
    //             'error' => 'Terjadi kesalahan. Silakan coba lagi.'
    //         ]);
    //     }
    // }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
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
            'nama_toko' => 'nullable|string|max:255', // boleh kosong
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tentukan role berdasarkan nama_toko
        $role = $request->filled('nama_toko') ? 'penjual' : 'pembeli';

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'nama_toko' => $request->nama_toko,
            'role' => $role,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
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
