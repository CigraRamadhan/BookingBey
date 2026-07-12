<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Dropdown navbar admin: ambil 10 notifikasi terbaru (dipanggil lewat AJAX)
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    // Tandai satu notifikasi sudah dibaca, lalu arahkan ke booking terkait
    public function read($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        if ($notification->booking_id) {
            return redirect()->route('admin.booking.show', $notification->booking_id);
        }

        return redirect()->route('dashboard');
    }

    // Tandai semua sudah dibaca
    public function readAll()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update(['read_at' => now()]);

        return back();
    }

    // Helper: kirim notifikasi ke semua akun admin sekaligus
    public static function kirimKeAdmin($bookingId, $judul, $pesan)
    {
        $adminIds = User::where('role', 'admin')->pluck('id');

        foreach ($adminIds as $adminId) {
            Notification::create([
                'user_id' => $adminId,
                'booking_id' => $bookingId,
                'judul' => $judul,
                'pesan' => $pesan,
            ]);
        }
    }
}
