<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Properti $properti)
    {
        // Memastikan properti valid
        if (!$properti->exists) {
            abort(404);
        }

        $dokumen = Dokumen::where('properti_id', $properti->properti_id)->get();
        return view('dokumen.index', compact('dokumen', 'properti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen' => 'required|file|max:10240', // max 10MB
            'properti_id' => 'required|exists:properti,properti_id'
        ]);

        $path = $request->file('dokumen')->store('dokumen');

        $dokumen = new Dokumen();
        $dokumen->properti_id = $request->properti_id;
        $dokumen->file_path = $path;
        $dokumen->tanggal_upload = now();
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah');
    }

    public function show(Dokumen $dokumen)
    {
        // Memastikan pengguna memiliki akses
        $user = Auth::user();
        $properti = Properti::find($dokumen->properti_id);

        if (!$properti || ($properti->user_id !== $user->user_id && !$this->isAdminUser($user))) {
            abort(403);
        }

        return Storage::download($dokumen->file_path);
    }

    public function destroy(Dokumen $dokumen)
    {
        // Memastikan pengguna memiliki akses
        $user = Auth::user();
        $properti = Properti::find($dokumen->properti_id);

        if (!$properti || ($properti->user_id !== $user->user_id && !$this->isAdminUser($user))) {
            abort(403);
        }

        Storage::delete($dokumen->file_path);
        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }

    public function updateStatus(Request $request, Dokumen $dokumen)
    {
        // Memastikan pengguna adalah admin
        if (!$this->isAdminUser(Auth::user())) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,verified,rejected'
        ]);

        $dokumen->status = $request->status;
        $dokumen->save();

        return redirect()->back()->with('success', 'Status dokumen berhasil diperbarui');
    }

    /**
     * Check if user is admin
     */
    private function isAdminUser(User $user): bool
    {
        return $user->peran()
            ->where('nama_peran', 'admin')
            ->exists();
    }
}
