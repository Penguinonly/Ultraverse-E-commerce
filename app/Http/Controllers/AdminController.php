<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Properti;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\LaporanInspeksi;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_properti' => Properti::count(),
            'pending_verifications' => User::whereNull('verivikasi_wajah')->count(),
            'total_transaksi' => Transaksi::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_properti' => Properti::with('user')->latest()->take(5)->get(),
            'recent_transaksi' => Transaksi::with(['properti', 'pembeli', 'penjual'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }    public function users()
    {
        $users = User::withCount(['properti', 'favorit', 'transaksiAsPembeli', 'transaksiAsPenjual'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }

    public function properti()
    {
        $properti = Properti::with(['user', 'gambar'])
            ->withCount('favorit')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.properti.index', compact('properti'));
    }

    public function transaksi()
    {
        $transaksi = Transaksi::with(['properti', 'pembeli', 'penjual', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.transaksi.index', compact('transaksi'));
    }    public function showUser(User $user)
    {
        $user->load(['properti', 'transaksiAsPembeli', 'transaksiAsPenjual']);
        return view('admin.users.show', compact('user'));
    }

    public function verifyUser(User $user)
    {
        $user->update([
            'verivikasi_wajah' => now()
        ]);

        return back()->with('success', 'User verified successfully');
    }

    public function showProperti(Properti $properti)
    {
        $properti->load(['user', 'gambar', 'dokumen', 'transaksi']);
        return view('admin.properti.show', compact('properti'));
    }

    public function verifyProperti(Properti $properti)
    {
        $properti->update([
            'status' => 'verified'
        ]);

        // Also update related documents if any
        if ($properti->dokumen()->exists()) {
            $properti->dokumen()->update(['status' => 'verified']);
        }

        return back()->with('success', 'Property verified successfully');
    }

    public function showTransaksi(Transaksi $transaksi)
    {
        $transaksi->load(['properti', 'pembeli', 'penjual', 'pembayaran']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function laporan()
    {
        $laporanInspeksi = LaporanInspeksi::with(['properti', 'inspector'])
            ->latest()
            ->paginate(10);
            
        return view('admin.laporan.index', compact('laporanInspeksi'));
    }
}
