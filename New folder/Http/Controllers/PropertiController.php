<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertiController extends Controller
{
    public function showUploadForm($section = 'rumah')
    {
        // Validate section
        if (!in_array($section, ['rumah', 'dokumen', 'jadwal'])) {
            $section = 'rumah';
        }

        $user = Auth::user();
        $data = [
            'section' => $section,
            'user' => [
                'name' => $user->name,
                'role' => $user->role,
            ]
        ];

        return view('Agen_Properti.upload_properti', $data);
    }

    public function saveRumah(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'luas_bangunan' => 'required|string',
            'unit' => 'required|string',
            'harga' => 'required|numeric',
            'lokasi' => 'required|string',
            'foto.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Save logic here
        return response()->json([
            'status' => 'success',
            'message' => 'Data rumah berhasil disimpan',
            'redirect' => route('properti.upload', ['section' => 'dokumen'])
        ]);
    }

    public function saveDokumen(Request $request)
    {
        $validated = $request->validate([
            'dokumen.*' => 'required|mimes:pdf,doc,docx|max:10240',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kk' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Save logic here
        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen berhasil disimpan',
            'redirect' => route('properti.upload', ['section' => 'jadwal'])
        ]);
    }

    public function saveJadwal(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date|after:today',
            'waktu' => 'required|string',
            'agreement' => 'required|accepted'
        ]);

        // Save logic here
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal inspeksi berhasil disimpan',
            'redirect' => route('dashboard_search')
        ]);
    }
}
