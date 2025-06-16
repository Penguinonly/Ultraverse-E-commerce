<?php

namespace App\Http\Controllers;

use App\Models\LaporanInspeksi;
use App\Models\Properti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspeksiController extends Controller
{
    public function index()
    {
        $inspeksi = LaporanInspeksi::with(['properti', 'inspector'])
            ->where('inspector_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('inspeksi.index', compact('inspeksi'));
    }

    public function create(Properti $properti)
    {
        return view('inspeksi.create', compact('properti'));
    }

    public function store(Request $request, Properti $properti)
    {
        $validated = $request->validate([
            'hasil_inspeksi' => 'required|string',
            'status_laporan' => 'required|in:pending,approved,rejected'
        ]);

        $laporan = LaporanInspeksi::create([
            'properti_id' => $properti->properti_id,
            'inspector_id' => Auth::id(),
            'hasil_inspeksi' => $validated['hasil_inspeksi'],
            'status_laporan' => $validated['status_laporan']
        ]);

        if ($validated['status_laporan'] === 'rejected') {
            $properti->update(['status' => 'inspection_failed']);
        } elseif ($validated['status_laporan'] === 'approved') {
            $properti->update(['status' => 'verified']);
        }

        return redirect()->route('inspeksi.show', $laporan)
            ->with('success', 'Inspection report created successfully');
    }

    public function show(LaporanInspeksi $laporan)
    {
        $laporan->load(['properti', 'inspector']);
        return view('inspeksi.show', compact('laporan'));
    }

    public function edit(LaporanInspeksi $laporan)
    {
        $this->authorize('update', $laporan);
        return view('inspeksi.edit', compact('laporan'));
    }

    public function update(Request $request, LaporanInspeksi $laporan)
    {
        $this->authorize('update', $laporan);

        $validated = $request->validate([
            'hasil_inspeksi' => 'required|string',
            'status_laporan' => 'required|in:pending,approved,rejected'
        ]);

        $laporan->update($validated);

        // Update property status based on inspection result
        if ($validated['status_laporan'] === 'rejected') {
            $laporan->properti->update(['status' => 'inspection_failed']);
        } elseif ($validated['status_laporan'] === 'approved') {
            $laporan->properti->update(['status' => 'verified']);
        }

        return redirect()->route('inspeksi.show', $laporan)
            ->with('success', 'Inspection report updated successfully');
    }
}
