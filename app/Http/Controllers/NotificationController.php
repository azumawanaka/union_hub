<?php

namespace App\Http\Controllers;

use App\Actions\DeleteNotificationAction;
use App\Actions\GetAllNotificationsAction;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request, GetAllNotificationsAction $getAllNotificationsAction, int|string $limit = 5)
    {
        return view('pages.notifications.index', [
            'notifications' => $getAllNotificationsAction->execute()->paginate($limit),
        ]);
    }

    public function remove(int|string $notifId, DeleteNotificationAction $deleteNotificationAction): JsonResponse
    {
        $deleteNotificationAction->execute($notifId);
        return response()->json(['message' => 'Notification was successfully removed.']);
    }
}
