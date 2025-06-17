<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Menampilkan notifikasi (gabungan dari NotificationController & NotifikasiController)
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        // Jika kamu memakai Laravel built-in notification system:
        $laravelNotifications = $user->notifications ?? collect();

        // Jika kamu punya model notifikasi sendiri
        $customNotifikasi = $user->notifikasi()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifikasi.index', [
            'notifikasi' => $customNotifikasi,
            'laravelNotifications' => $laravelNotifications
        ]);
    }

    // Tandai satu notifikasi sebagai dibaca
    public function markAsRead(Notifikasi $notifikasi)
    {
        $this->authorize('update', $notifikasi);

        $notifikasi->update([
            'dibaca' => true
        ]);

        return back()->with('success', 'Notification marked as read');
    }

    // Tandai semua notifikasi sebagai dibaca
    public function markAllAsRead()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->notifikasi()
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return back()->with('success', 'All notifications marked as read');
    }
}
