<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    

    public function __construct()
    {
        //$this->middleware('auth:client');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "fdsdfs";
        // return view('front.home');
        // return view('front.auth.register');
        // return view('front.auth.login');
    }


}
