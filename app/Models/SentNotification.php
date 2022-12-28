<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SentNotification extends Model
{
    protected $table = 'sent_notifications';

    protected $fillable = ['sender_id', 'sender_model', 'receiver_id', 'receiver_model', 'type', 'type_id', 'message_id', 'message'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }

    ////////////////////////// Relations \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
}
