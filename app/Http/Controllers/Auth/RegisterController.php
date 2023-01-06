<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'company_name' => 'required|max:255',
            // 'company_email' => 'required|email|max:255|unique:users',
            // 'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    // protected function create(array $data)
    // {
    //   // var_dump($data);
    //   // die();
    //     $company = Company::create([
    //       'name' => $data['company_name'],
    //       'email' => $data['company_email'],
    //     ]);
    //     //Add Default company permissions.
    //
    //     $user = User::create([
    //         'first_name' => $data['first_name'],
    //         'cell_number' => $data['cell_number'],
    //         'last_name' => $data['last_name'],
    //         'company_id' => $company->id,
    //         'password' => bcrypt($data['password']),
    //     ]);
    //     //Add default user permissions
    //     $user->roles()->sync([5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]);
    //     return $user;
    // }

    public function order_subscription(Request $request)
    {
      $data = $request->all();

      \Stripe\Stripe::setApiKey("sk_test_3CKpehbJBslIsqjSZi9dL10O");
      $stripeToken = $data['stripeToken'];
      $company = Company::find($data['company_id']);
      $company->newSubscription('main', 'monthly')->create($stripeToken);
      $company->rights()->sync([2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]);
      return $company;

    }

    public function order_trial(Request $request)
    {
      $data = $request->all();
      // return $data['company_id'];
      $company = Company::find($data['company_id']);

      $company->update([
            'trial_ends_at' => Carbon::now()->addDays(15),
        ]);
        // return $company;
      $company->rights()->sync([2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]);

      return $company;

    }

    public function store_user(Request $request)
    {

      $data = $request->all();
      $this->validate($request, [
        'cell_number' => 'required|unique:users',
        'first_name' => 'required',
        'last_name' => 'required',
        'cell_provider' => 'required',
        'password' => 'required|min:8',
        'company_id' => 'required',
      ]);

      $user = User::create([
            'first_name' => $data['first_name'],
            'cell_number' => $data['cell_number'],
            'last_name' => $data['last_name'],
            'company_id' => $data['company_id'],
            'password' => bcrypt($data['password']),
      ]);
      $user->roles()->sync([5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]);
      return $user;
    }
}
