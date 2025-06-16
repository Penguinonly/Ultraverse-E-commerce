<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function store(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'metode_pembayaran' => 'required|string'
        ]);

        $pembayaran = Pembayaran::create([
            'transaksi_id' => $transaksi->transaksi_id,
            'jumlah' => $validated['jumlah'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'konfirmasi_pembayaran' => false
        ]);

        return redirect()->route('transaksi.show', $transaksi)
            ->with('success', 'Payment submitted successfully');
    }

    public function confirm(Request $request, Pembayaran $pembayaran)
    {
        $this->authorize('confirm', $pembayaran);

        $pembayaran->update([
            'konfirmasi_pembayaran' => true
        ]);

        return redirect()->route('transaksi.show', $pembayaran->transaksi)
            ->with('success', 'Payment confirmed successfully');
    }
}
