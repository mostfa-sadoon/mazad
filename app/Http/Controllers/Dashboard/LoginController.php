<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminResetPasswordRequest;
use App\Mail\AdminResetPassword;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    
    public function postLogin(AdminLoginRequest $request){

        $remember_me = $request->has('remember_me') ? true : false;

        if ( auth()->guard('admin')->attempt(['email' => $request->email , 'password' => $request->password] , $remember_me )) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with(['error' => 'هناك خطأ بالبيانان']);

    }

    public function logout(){

        auth('admin')->logout();
        return redirect()->route('admin.login');
    }




  


}
