<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\ContactUs;

class TermController extends Controller
{
    //
    public function index(){
       $term=Term::find(1);
       $ContactUs=ContactUs::find(1);
       return view('front.term',compact('term','ContactUs'));
    }
}
