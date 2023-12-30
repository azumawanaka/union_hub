<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();

        return view('notifications.index', compact('notifications'));
    }

    public function create($message)
    {
        Notification::create(['message' => $message]);

        return response()->json(['message' => 'Notification created successfully']);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }
}
