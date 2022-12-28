<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quetion;


class Qutioncontroller extends Controller
{
    //
    public function index(){
        $quetions=Quetion::get();
        return view('front.faqs',compact('quetions'));
    }
}
