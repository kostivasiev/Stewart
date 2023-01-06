<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/workorders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    // protected function sendLoginResponse(Request $request)
    // {
    //     $request->session()->regenerate();
    //
    //     $this->clearLoginAttempts($request);
    //     foreach ($this->guard()->user()->roles as $role) {
    //       if($role->name == 'Admin'){
    //         return redirect('admin/home');
    //       }elseif($role->name == 'Mechanic'){
    //         return redirect('workorders/index');
    //       }
    //     }
    // }

    public function username()
    {
      return 'cell_number';
    }
}
