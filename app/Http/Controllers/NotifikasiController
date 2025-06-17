<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $notifikasi = $user->notifikasi()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        $this->authorize('update', $notifikasi);

        $notifikasi->update([
            'dibaca' => true
        ]);

        return back()->with('success', 'Notification marked as read');
    }    public function markAllAsRead()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->notifikasi()
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return back()->with('success', 'All notifications marked as read');
    }
}
