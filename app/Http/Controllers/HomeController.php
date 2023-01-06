<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      // $invertal_array = app('App\Http\Controllers\WorkorderController')->current_intervals();
      return view('home');
        return view('home',app('App\Http\Controllers\WorkorderController')->current_intervals($request));
    }

    public function orderPost(Request $request)
    {


    }
}
