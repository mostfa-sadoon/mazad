<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index()
    {
        // return 'Admin Home Page';
        return view('dashboard.index');
    }
}
