<?php

namespace App\Http\Controllers; // ✅ HANYA INI untuk controller

use App\Models\Pesan; // ✅ Mengimpor model Pesan dari folder Models
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Pesan::where('pengirim_id', $user->id)
            ->orWhere('penerima_id', $user->id)
            ->orderBy('timestamp', 'desc')
            ->get()
            ->groupBy(function ($pesan) use ($user) {
                return $pesan->pengirim_id === $user->id
                    ? $pesan->penerima_id
                    : $pesan->pengirim_id;
            });

        return view('pesan.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $messages = Pesan::where(function ($query) use ($user) {
                $query->where('pengirim_id', Auth::id())
                      ->where('penerima_id', $user->id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('pengirim_id', $user->id)
                      ->where('penerima_id', Auth::id());
            })
            ->orderBy('timestamp')
            ->get();

        return view('pesan.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'isi_pesan' => 'required|string'
        ]);

        Pesan::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $user->id,
            'isi_pesan' => $validated['isi_pesan'],
            'dibaca' => false,
            'timestamp' => now()
        ]);

        return back()->with('success', 'Message sent successfully');
    }
}
