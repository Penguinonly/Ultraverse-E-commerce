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
        return view('Home.signIn'); // Ganti dengan lokasi view login kamu
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
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Simpan user ke session
        $request->session()->put('user', [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ]);

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
            ]);
            return redirect()->intended('/dashboard_search');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/signIn');
    }
}
