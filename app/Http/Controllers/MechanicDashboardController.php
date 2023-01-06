<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Auth;

class MechanicDashboardController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(Request $request)
  {


    $users = Auth::user()->company()->first()->users()


    ->whereHas(
      'roles', function($q){
                $q->where('name', 'Mechanic');
            }
        )->get();
    return view('mechanic_dashboard.index', compact('users'));
  }

  public function orderPost(Request $request)
  {


  }
}
