<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Pesan::where('pengirim_id', $user->user_id)
            ->orWhere('penerima_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($pesan) use ($user) {
                return $pesan->pengirim_id === $user->user_id
                    ? $pesan->penerima_id
                    : $pesan->pengirim_id;
            });

        return view('pesan.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $messages = Pesan::where(function ($query) use ($user) {
                $query->where('pengirim_id', Auth::id())
                    ->where('penerima_id', $user->user_id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('pengirim_id', $user->user_id)
                    ->where('penerima_id', Auth::id());
            })
            ->orderBy('created_at')
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
            'penerima_id' => $user->user_id,
            'isi_pesan' => $validated['isi_pesan'],
            'dibaca' => false,
            'timestamp' => now()
        ]);

        return back()->with('success', 'Message sent successfully');
    }
}
