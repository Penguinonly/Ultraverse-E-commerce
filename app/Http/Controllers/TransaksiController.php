<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $transaksiSebagaiPembeli = $user->transaksiAsPembeli()->with(['properti', 'penjual'])->get();
        $transaksiSebagaiPenjual = $user->transaksiAsPenjual()->with(['properti', 'pembeli'])->get();

        return view('transaksi.index', compact('transaksiSebagaiPembeli', 'transaksiSebagaiPenjual'));
    }

    public function store(Request $request, Properti $properti)
    {
        $validated = $request->validate([
            'total_harga' => 'required|numeric'
        ]);

        $transaksi = Transaksi::create([
            'properti_id' => $properti->properti_id,
            'pembeli_id' => Auth::id(),
            'penjual_id' => $properti->user_id,
            'total_harga' => $validated['total_harga'],
            'status_transaksi' => 'pending'
        ]);

        return redirect()->route('transaksi.show', $transaksi);
    }

    public function show(Transaksi $transaksi)
    {
        $this->authorize('view', $transaksi);
        $transaksi->load(['properti', 'pembeli', 'penjual', 'pembayaran']);
        
        return view('transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $this->authorize('update', $transaksi);
        
        $validated = $request->validate([
            'status_transaksi' => 'required|in:pending,processed,completed,cancelled'
        ]);

        $transaksi->update([
            'status_transaksi' => $validated['status_transaksi']
        ]);

        return redirect()->route('transaksi.show', $transaksi);
    }

    public function destroy(Transaksi $transaksi)
    {
        $this->authorize('delete', $transaksi);
        $transaksi->delete();
        return redirect()->route('transaksi.index');
    }
}
