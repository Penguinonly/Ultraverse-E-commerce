<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Properti $properti)
    {
        if (!$properti->exists) {
            abort(404);
        }

        $documents = Document::where('properti_id', $properti->properti_id)->get();
        return view('document.index', compact('documents', 'properti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|max:10240',
            'properti_id' => 'required|exists:properti,properti_id'
        ]);

        $path = $request->file('document')->store('dokumen');

        Document::create([
            'properti_id' => $request->properti_id,
            'file_path' => $path,
            'tanggal_upload' => now(),
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah');
    }

    public function show(Document $dokumen)
    {
        $user = Auth::user();
        $properti = Properti::find($dokumen->properti_id);

        if (!$properti || ($properti->user_id !== $user->id && !$this->isAdminUser($user))) {
            abort(403);
        }

        $fullPath = storage_path('app/private/' . $dokumen->file_path);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        return response()->file($fullPath, [
            'Content-Disposition' => 'inline; filename="' . $dokumen->filename . '"'
        ]);
    }



    public function destroy(Document $dokumen)
    {
        $user = Auth::user();
        $properti = Properti::find($dokumen->properti_id);

        if (!$properti || ($properti->user_id !== $user->id && !$this->isAdminUser($user))) {
            abort(403);
        }

        Storage::delete($dokumen->file_path);
        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }

    public function updateStatus(Request $request, Document $dokumen)
    {
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

    private function isAdminUser(User $user): bool
    {
        return method_exists($user, 'peran') && $user->peran()->where('nama_peran', 'admin')->exists();
    }
}
