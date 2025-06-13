<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Kemana redirect setelah register berhasil.
     */
    public function create()
    {
        return view('In_Home.Login.create'); // Sesuaikan path view
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:logins,email',
            'password' => 'required|string|min:6',
        ]);

        // Simpan ke database
        $login = Login::create([
            'fullname' => $validated['fullname'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // amankan password
        ]);

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat.');
    }
}
