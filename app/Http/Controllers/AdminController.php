<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Properti;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProperties = Properti::count();
        $pendingPayments = Pembayaran::where('konfirmasi_pembayaran', false)->count();

        return view('admin.dashboard', compact('totalUsers', 'totalProperties', 'pendingPayments'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $properti = Properti::where('user_id', $user->user_id)->get();
        $transaksi = Transaksi::where('user_id', $user->user_id)->get();
        
        return view('admin.users.show', compact('user', 'properti', 'transaksi'));
    }

    public function verifyUser(User $user)
    {
        $user->update(['verified' => true]);
        return back()->with('success', 'User berhasil diverifikasi');
    }

    public function properti()
    {
        $properties = Properti::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.properti.index', compact('properties'));
    }

    public function showProperti(Properti $properti)
    {
        $properti->load(['user', 'dokumen', 'gambar_properti']);
        return view('admin.properti.show', compact('properti'));
    }

    public function verifyProperti(Properti $properti)
    {
        $properti->update(['status' => 'verified']);
        return back()->with('success', 'Properti berhasil diverifikasi');
    }
}
