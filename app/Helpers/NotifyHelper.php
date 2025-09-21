<?php
namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Support\Facades\Cache;

class NotifyHelper
{
    public static function send($userId, $title, $message, $link = null)
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'is_read' => false, 
        ]);

        Cache::forget('user_notifications_' . $userId);
    }
}