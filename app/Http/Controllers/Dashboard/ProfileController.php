<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editProfile()
    {

        $admin = Admin::find(auth('admin')->user()->id);

        return view('dashboard.admins.edit', compact('admin'));

    }

    public function updateProfile(ProfileRequest $request)
    {
        //validate
        // db

        try {
            $admin = Admin::find(auth('admin')->user()->id);


            if ($request->has('password') && $request->password != null) {
                $request->merge(['password' => bcrypt($request->password)]);
            }else{
                unset($request['password']);
            }

            unset($request['id']);
            unset($request['password_confirmation']);

//return $request;

            $admin->update($request->all());

            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }

    }


}
