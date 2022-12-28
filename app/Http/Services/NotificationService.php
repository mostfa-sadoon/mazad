<?php

namespace App\Http\Services;

use App\Models\Admin;
use App\Models\Client;
use App\Models\SentNotification;

class NotificationService
{


    # Save Single Notification to any Guard
    public static function sendSingleNotification($sender_id = null, $sender_model = null, $message_id, $message = null, $type = null, $type_id = null, $receiver_id = null, $receiver_model = null)
    {
        $sender = '';
        $receiver = '';

        if ($sender_model == 'client') {
            $sender = Client::findOrFail($sender_id);
        } elseif ($sender_model == 'admin') {
            $sender = Admin::findOrFail($sender_id);
        }

        if ($receiver_model == 'client') {
            $receiver = Client::findOrFail($receiver_id);
        } elseif ($sender_model == 'admin') {
            $receiver = Admin::findOrFail($sender_id);
        }

        # Save Notification to DB
        SentNotification::create([
            'sender_id'  => $sender_id,
            'sender_model' => $sender_model,
            'message_id' => $message_id,
            'message' => $message,
            'type'  => $type,
            'type_id' => $type_id,
            'receiver_id' => $receiver_id,
            'receiver_model'  => $receiver_model,
        ]);
    }
}
