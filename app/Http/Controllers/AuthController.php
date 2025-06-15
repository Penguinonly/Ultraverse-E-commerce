<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'noktp' => 'required|string|unique:users',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg',
            'verifikasi_wajah' => 'required|image|mimes:jpeg,png,jpg',
            'pendapatan_perbulan' => 'required|numeric',
            'role' => 'required|in:admin,penjual,pembeli'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Handle file uploads
            $fotoKtpPath = $request->file('foto_ktp')->store('ktp_photos', 'public');
            $verifikasiWajahPath = $request->file('verifikasi_wajah')->store('face_verifications', 'public');

            $user = User::create([
                'noktp' => $request->noktp,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'foto_ktp' => $fotoKtpPath,
                'verifikasi_wajah' => $verifikasiWajahPath,
                'pendapatan_perbulan' => $request->pendapatan_perbulan,
                'role' => $request->role
            ]);

            if ($user) {
                Auth::login($user);
                Log::info('User registered successfully', ['user_id' => $user->user_id]);
                return redirect()->route($user->role . '.dashboard')
                    ->with('success', 'Registration successful. Welcome to Ultraverse!');
            }
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    // Proses login
    public function authenticate(Request $request)
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
                Log::info('User logged in', [
                    'user_id' => $user->user_id,
                    'email' => $user->email
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
            Log::error('Login error: ' . $e->getMessage());
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
        $userId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out', ['user_id' => $userId]);
        return redirect()->route('login')
            ->with('success', 'You have been successfully logged out.');
    }
}
