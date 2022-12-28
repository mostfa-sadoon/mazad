<?php

namespace App\Http\Controllers\Site;

use Auth;
use Route;
use App\Models\Level;
use App\Models\Client;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Requests\ClientNewPasswordRequest;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Requests\ClientRegisterRequest;
use App\Models\Country;

class ClientLoginController extends Controller
{



  public function __construct()
  {
    //$this->middleware('guest:client', ['except' => ['logout']]);
  }


  public function otp() // Phone Page for Reset
  {
    // return explode('+966' , '+966665151')[1];
    return view('front.auth.otp');
  }


  public function checkClient(Request $request)
  {
    try {
        $country_code=$request->country_code;
        $phone=$request->phone;
    if(!isset($request->type)){
        // we use it in forget password

      $client = Client::where(['country_code' => $request->country_code, 'phone' =>$phone])->first();
      if (!$client) {
        return response()->json(['status' => 201, 'msg' => __('app/all.phone_number_with_country_code_does_not_exist')], 201);
      }
        // this is in case resete password
        $client->reset_password_token = str_random(50) . now() . $client->id . '' . str_random(5);
        $client->save();
        return response()->json(['status' => 200, 'reset_password_token' => $client->reset_password_token, 'msg' => 'Client is exists'], 200);
      }else{
        // we use it in
        $client = Client::where(['country_code' => $request->country_code, 'phone' => $phone])->first();
        if (!$client) {
          return response()->json(['status' => 201, 'msg' => __('app/all.phone_number_with_country_code_does_not_exist')], 201);
        }
        // this in case of register
        $client->verifycode = str_random(50) . now() . $client->id . '' . str_random(5);
        $client->save();
        return response()->json(['status' => 200, 'verifycode' => $client->verifycode, 'msg' => 'Client is exists'], 200);
      }
    } catch (\Throwable $th) {
      return response()->json(['status' => 201, 'msg' => __('app/all.phone_number_with_country_code_does_not_exist')], 201);
    }
  }

  public function resetPassword($country_code, $phone, $reset_password_token) // Code Page
  {
    try {

      $client = Client::where(['country_code' => $country_code, 'phone' => explode($country_code, $phone)[1], 'reset_password_token' => $reset_password_token])->first();
      if (!$client) {
        return redirect()->route('client.otp')->with(['error' => __('app/all.Client_does_not_exists')]);
      }

      return view('front.auth.reset_pass')->with(['country_code' => $country_code, 'phone' => $phone, 'reset_password_token' => $reset_password_token]);
    } catch (\Throwable $th) {
      return redirect()->back()->with(['error' => __('app/all.Client_does_not_exists')]);
    }
  }

  public function newPassword($country_code, $phone, $reset_password_token) // New Password Page
  {
    try {

      $client = Client::where(['country_code' => $country_code, 'phone' => explode($country_code, $phone)[1], 'reset_password_token' => $reset_password_token])->first();
      if (!$client) {
        return redirect()->route('client.otp')->with(['error' => __('app/all.Client_does_not_exists')]);
      }

      return view('front.auth.new_password')->with(['country_code' => $country_code, 'phone' => $phone, 'reset_password_token' => $reset_password_token]);
    } catch (\Throwable $th) {
      return redirect()->back()->with(['error' => __('app/all.Client_does_not_exists')]);
    }
  }

  public function updateNewPassword($country_code, $phone, $reset_password_token , ClientNewPasswordRequest $request) // New Password update
  {
    try {

      $client = Client::where(['country_code' => $country_code, 'phone' => explode($country_code, $phone)[1], 'reset_password_token' => $reset_password_token])->first();
      if (!$client) {
        return redirect()->route('client.otp')->with(['error' => __('app/all.Client_does_not_exists')]);
      }

      Client::find($client->id)->update([
        'password' => bcrypt($request->password),
      ]);

      return redirect()->route('client.login')->with('success_model', __('app/all.Password_has_been_changed'));

      return view('front.auth.new_password')->with(['country_code' => $country_code, 'phone' => $phone, 'reset_password_token' => $reset_password_token]);
    } catch (\Throwable $th) {
      return redirect()->back()->with(['error' => __('app/all.Client_does_not_exists')]);
    }
  }




  public function showVerificationCode()
  {
    return view('front.auth.verification_code');
  }

  public function verifyCode(Request $request)
  {
    return $request;
  }





  public function showLoginForm()
  {
    return view('front.auth.login');
  }

  public function login(Request $request)
  {
    try {
      $request['phone'] = $request->phone;
    } catch (\Throwable $th) {
      return redirect()->back()->withInput($request->only('email', 'remember'))->with(['error' => __('app/all.phone_number_with_country_code_is_invalid_format')]);
    }
    $remember_me = $request->has('remember_me') ? true : false;
    // Attempt to log the user in
    if (Auth::guard('client')->attempt(['phone' =>$request['phone'], 'password' => $request->password], $remember_me)) {
      // if successful, then redirect to their intended location
      // return redirect()->route('client.home');
         if(Auth::guard('client')->user()->verified_at==null){
            Auth::guard('client')->logout();
            return redirect()->back()->withInput($request->only('email', 'remember'))->with(['error' => __('app/all.please_verfy_your_number_first'),'redirect'=>true]);
         }
      return redirect()->intended(route('client.home'));
    }
    // if failed, then redirect back to the login with the form data
    return redirect()->back()->withInput($request->only('email', 'remember'))->with(['error' => __('app/all.phone_and_password_are_invalid') ,'redirect'=>'']);
  }
  public function logout()
  {
    Auth::guard('client')->logout();
    return redirect()->route('client.home');
  }


  public function showRegisterForm()
  {
    $countries = Country::all();
    return view('front.auth.register', compact('countries'));
  }

  public function register(ClientRegisterRequest $request)
  {
   // $request['phone'] = explode($request->country_code, $request->phone)[1];
    // return $request;
    $client = Client::create([
      'f_name' => $request['f_name'],
      'l_name' => $request['l_name'],
      'country_code' => $request['country_code'],
      'phone' => $request['phone'],
      'email' => $request['email'],
      'country_id' => $request['country_id'],
      'city_id' => $request['city_id'],
      'photo' => 'not.png',
      'password' => Hash::make($request['password']),
    ]);
    if ($client) {
        $phone=$request->phone; $country_code=$request->country_code;
        $register=true;
        $client->verifycode = str_random(50) . now() . $client->id . '' . str_random(5);
        $client->save();
        return view('front.auth.register.sendotp')->with(['country_code' => $country_code, 'phone' =>  $phone, 'verifycode' => $client->verifycode ]);
        //return redirect()->back()->with(['success' => 'Registered successfully'])->with('phone', $client->phone);
    } else {
      return redirect()->back()->withInput($request->only('f_name', 'l_name'))->with(['error' => __('admin/forms.wrong')]);
    }
  }

   public function sendphonepage(){
       return view('front.auth.register.sendphone');
   }

   public function sendphone(Request $request){

        $country_code=$request->country_code;
        $phone=$request->phone;
        // we use it in forget password
      $client = Client::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();
      if (!$client) {
        return redirect()->back()->with(['error' => __('app/all.phone_number_with_country_code_does_not_exist')]);
      }
        // this is in case resete password
        $client->verifycode = str_random(50) . now() . $client->id . '' . str_random(5);
        $client->save();
        return view('front.auth.register.sendotp')->with(['country_code' => $country_code, 'phone' => $phone, 'verifycode' => $client->verifycode ]);
   }

  // we use this function after user send otp success to verify account
  public function verifyphone($country_code, $phone, $verifycode, Request $request){
   // dd($phone);
        try {
            $client = Client::where(['country_code' => $country_code, 'phone' => explode($country_code,$phone)[1], 'verifycode' => $verifycode])->first();
            if (!$client) {
            return redirect()->route('client.otp')->with(['error' => __('app/all.Client_does_not_exists')]);
            }
            $client->update([
            'verified_at'=>Carbon::now(),
            ]);
            return redirect()->route('client.login')->with('success_model', __('app/all.Your_account_has_been_created_successfully'))->with('phone', $client->phone);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => __('app/all.Client_does_not_exists')]);
        }
  }
}
