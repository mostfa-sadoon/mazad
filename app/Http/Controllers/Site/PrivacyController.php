<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyCondetion;
use App\Models\ContactUs;
class PrivacyController extends Controller
{
    //
    public function index(){
        $Privacy=PrivacyCondetion::find(1);
        $ContactUs=ContactUs::find(1);
        return view('front.Privacy',compact('Privacy','ContactUs'));
     }
}
