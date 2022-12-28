<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\ContactUs;

use App\Models\AboutUstranslation;
use DB;
class AboutUsController extends Controller
{
    //
    public function index(){
        $aboutus=AboutUs::find(1);
        $ContactUs=ContactUs::find(1);
        return view('front.aboutus',compact('aboutus','ContactUs'));
    }
}
