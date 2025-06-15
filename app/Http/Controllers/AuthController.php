<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        $user =  Auth::user(); // Ambil user yang login

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');
            case 'penjual':
                return view('Home.signIn');
            case 'pembeli':
                return view('pembeli.dashboard');
            default:
                abort(403, 'Role tidak dikenal.');
        }
        // return view('Home.signIn'); // Ganti dengan lokasi view login kamu
    }

    // Menampilkan halaman register
    public function showRegister()
    {
        return view('Home.create'); // Ganti dengan lokasi view register kamu
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:penjual,pembeli',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        // Simpan user ke session
        $request->session()->put('user', [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ]);

        // Redirect based on role
        if ($user->role === 'penjual') {
            return redirect()->route('dashboard.penjual');
        } else if ($user->role === 'pembeli') {
            return redirect()->route('dashboard.pembeli');
        }
        return redirect()->route('dashboard_search');
    }

    // Proses login    public function authenticate(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                /** @var \App\Models\User $user */
                $user = Auth::user();
                
                // Set session data
                session([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'last_activity' => now(),
                    'is_verified' => $user->is_verified
                ]);

                // Log the login
                \Log::info('User logged in', [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'ip' => $request->ip()
                ]);

                // Redirect based on role
                switch($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'penjual':
                        return redirect()->route('penjual.dashboard');
                    case 'pembeli':
                        return redirect()->route('pembeli.dashboard');
                    default:
                        return redirect()->route('home');
                }
            }

            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->except('password'));
                
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat login. Silakan coba lagi.'])
                ->withInput($request->except('password'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}
