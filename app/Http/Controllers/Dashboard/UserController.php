<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\SentNotification;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Cache;
use Illuminate\Support\Facades\Http;

class UserController // extends NotificationController
{

    public function allUsers(Request $request)
    {

        $users = Client::with('country')->when($request->search, function ($q) use ($request) {

            return $q->where(function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('f_name', 'like', '%' . $request->search . '%')
                    ->orWhere('l_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });

        })->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

        return view('dashboard.users.index', compact('users'));
    }


    public function changeActive($id)
    {
        $user = Client::find($id);
        if (!$user)
            return redirect()->back()->with(['error' => 'هذا العميل غير موجود ']);

        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with(['success' => __('admin/forms.updated_successfully')]);
    }


    public function sendNotificationToUserPage($id)
    {
        $user = User::find($id);

        if (!$user)
            return redirect()->route('dashboard.users.index')->with(['error' => 'هذا العميل غير موجود ']);

        return view('dashboard.users.show', compact(['user']));
    }


    public function sendNotificationToUser($id, Request $request)
    {
        $sourceKey = self::$sourceKey;

        $user = User::find($id);

        if (!$user)
            return redirect()->route('dashboard.users.index')->with(['error' => 'هذا العميل غير موجود ']);

        $res = $this->sendSingleNotificationToAnyOne($sourceKey, $request, $user);

        # Save Notification to DB
        SentNotification::create([
            'sender_model' => 'admin',
            'receiver_id' => $user->id,
            'receiver_model'  => 'user',
            'message' => $request->body,
        ]);

        return redirect()->back()->with(['success' => 'تم ارسال الاشعار']);
    }


    public function sendSingleNotificationToAnyOne($sourceKey, Request $request, $user)
    {

        $header = [
            'Authorization' => 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];

        $data = [
            'title' => $request->title,
            'body'  => $request->body,
            'sound' => 'default'
        ];


        //send notifications for android device
        if ($user->mobile_id == 0) {
            $body = [
                'data' => $data,
                'to' => $user->fcm_token,
                "periority" => "high"
            ];
        }

        //send notifications for ios device
        if ($user->mobile_id == 1) {
            $body = [
                'data' => $data,
                'notification' => $data,
                'to' => $user->fcm_token
            ];
        }

        if ($user->fcm_token != null) {
            $res = Http::withHeaders($header)->post('https://fcm.googleapis.com/fcm/send', $body);
            return $res;
        }
    }

}
