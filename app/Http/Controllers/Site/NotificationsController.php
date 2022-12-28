<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SentNotification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{


    public function index()
    {
        $notifications = SentNotification::where(['receiver_id'=> auth('client')->id()])->latest()->paginate(PAGINATION_COUNT);
        // return $notifications;
        return view('front.notifications' , compact('notifications'));
    }
}
