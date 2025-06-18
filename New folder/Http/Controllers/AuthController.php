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
                return view('penjua;.dashboard');
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

    // Proses login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Simpan user ke session
            $user = Auth::user();
            $request->session()->put('user', [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ]);
            // Redirect based on role
            if ($user->role === 'penjual') {
                return redirect()->intended('/dashboard_penjual');
            } else if ($user->role === 'pembeli') {
                return redirect()->intended('/dashboard_pembeli');
            }
            return redirect()->intended('/dashboard_search');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
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
