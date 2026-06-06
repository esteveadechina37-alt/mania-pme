<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        // Sécurité : vérifier que la notification appartient à l'utilisateur connecté
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        $notification->delete();
        return back()->with('success', 'Notification supprimée.');
    }
}