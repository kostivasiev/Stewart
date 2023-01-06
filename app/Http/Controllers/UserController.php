<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\User;
use Auth;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    private $rules = [
    		'first_name' => ['required'],
        'last_name' => ['required'],
    		'photo' => ['mimes:jpg,jpeg,png,bmp'],
    	];
    private $upload_dir = 'public/uploads';

    public function __construct(){
    	$this->middleware('auth');
      $this->middleware('roles:View Users');
    	$this->upload_dir = base_path() . '/' . $this->upload_dir;
    }

    public function autocomplete(Request $request)
    {
    	// if($request->ajax){
    		return User::select(['id', DB::raw('CONCAT(last_name, ", ", first_name) AS value')])->where(function($query) use ($request) {

    				if( ($term = $request->get("term"))){

    					$keywords = '%' . $term . '%';
    					$query->orWhere("first_name", 'LIKE', $keywords);
    					$query->orWhere("last_name", 'LIKE', $keywords);
    					$query->orWhere("email", 'LIKE', $keywords);
    				}
    					})
              ->where('company_id',Auth::user()->company()->first()->id)
    					->orderBy('last_name', 'asc')
    					->take(5)
    					->get();
    	// }

    }

    public function index(Request $request){

        // \DB::enableQueryLog();
        // listGroups($request->user()->id);
        // dd(\DB::getQueryLogs());

    	$users = $request->user()->company()->first()->users()->where(function($query) use ($request) {

    		// $query->where("company_id",$request->user()->company()->first()->id);
        })->where(function($query) use ($request){


    				if( ($term = $request->get("term"))){
              $term = $request->get("term");

    					$keywords = '%' . $term . '%';
    					$query->orWhere("first_name", 'LIKE', $keywords);
    					$query->orWhere("last_name", 'LIKE', $keywords);
    					$query->orWhere("email", 'LIKE', $keywords);
    				}
          })
          ->orderBy('last_name')
          ->orderBy('first_name')
          ->paginate(15);

    	return view('users.index', compact('users'));
    }

    public function create()
    {
    	return view("users.create");
    }

    public function edit($id)
    {
    	$user = User::findOrFail($id);
      // $user = User::find(1);

      // $user->newSubscription('main', 'monthly')->create($stripeToken);
        // $this->authorize('modify', $contact);
    	return view("users.edit", compact('user'));
    }

    public function validate_pin(Request $request)
    {
      $user_cnt = $request->user()->company()->first()->users()
      ->where(function($query) use ($request) {
    		  $query->where("pin",$request->pin);
        })->count();
    	return $user_cnt;
    }

    private function sync_assignments($user, $request){
      $request_assignment_array = [];
      if(count($request->equipment_assignment)){
        $request_assignment_array = $request->equipment_assignment;
      }
      $equipment_assignment = array_fill(0, count($request->equipment_assignment), ['daily' => 0, 'weekly' => 0]);
      $assignment_array   = array_combine($request_assignment_array, $equipment_assignment);
      $user->equipment()->sync($assignment_array);


      $equipment_daily  = array_fill(0, count($request->equipment_daily), ['daily' => 1]);
      $equipment_weekly = array_fill(0, count($request->equipment_weekly), ['weekly' => 1]);
      if($request->equipment_daily){
        $daily_array   = array_combine($request->equipment_daily, $equipment_daily);
        $user->equipment()->syncWithoutDetaching($daily_array);
      }
      if($request->equipment_weekly){
        $weekly_array  = array_combine($request->equipment_weekly, $equipment_weekly);
        $user->equipment()->syncWithoutDetaching($weekly_array);
      }
    }

    public function update ($id, Request $request)
    {
    	$this->validate($request, $this-> rules);
    	$user = User::findOrFail($id);
        // $this->authorize('modify', $contact);
    	$oldPhoto = $user->photo;

      $data = $this->getRequest($request);
      $this->sync_assignments($user, $request);
      // $request_assignment_array = [];
      // if(count($request->equipment_assignment)){
      //   $request_assignment_array = $request->equipment_assignment;
      // }
      // $equipment_assignment = array_fill(0, count($request->equipment_assignment), ['daily' => 0, 'weekly' => 0]);
      // $assignment_array   = array_combine($request_assignment_array, $equipment_assignment);
      // $user->equipment()->sync($assignment_array);
      //
      //
      // $equipment_daily  = array_fill(0, count($request->equipment_daily), ['daily' => 1]);
      // $equipment_weekly = array_fill(0, count($request->equipment_weekly), ['weekly' => 1]);
      // if($request->equipment_daily){
      //   $daily_array   = array_combine($request->equipment_daily, $equipment_daily);
      //   $user->equipment()->syncWithoutDetaching($daily_array);
      // }
      // if($request->equipment_weekly){
      //   $weekly_array  = array_combine($request->equipment_weekly, $equipment_weekly);
      //   $user->equipment()->syncWithoutDetaching($weekly_array);
      // }








      if($data['password']==$user->password){
        $password = $data['password'];
      }else{
        $password = bcrypt($data['password']);
      }
      if($data['email']==""){
        $data['email']=" ";
      }
      if(!empty($data['send_text_at_fueling'])){
        $send_text_at_fueling=1;
      }else{
        $send_text_at_fueling=0;
      }
      if(!empty($data['send_email_at_fueling'])){
        $send_email_at_fueling=1;
      }else{
        $send_email_at_fueling=0;
      }
      if($data['cell_number']==""){
        $data['cell_number'] = "**" . str_random(40);
      }
      if($data['cell_provider']==""){
        $data['cell_provider'] = "";
      }
      if(!empty($data['fuel_group_id'])){
        if($data['fuel_group_id']==""){
          $data['fuel_group_id'] = "";
        }
      }else{
        $data['fuel_group_id'] = "";
      }
      $login_account_id = 0;

    	// $user->update($data);
      $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $password,
            'cell_number' => $data['cell_number'],
            'cell_provider' => $data['cell_provider'],
            'login_account_id' => $login_account_id,
            'fuel_group_id' => $data['fuel_group_id'],
            'send_text_at_fueling' => $send_text_at_fueling,
            'send_email_at_fueling' => $send_email_at_fueling,
            'PIN' => $data['PIN'],
        ]);

      if(!empty($data['photo'])){
        $user->update([
          'photo' => $data['photo'],
        ]);
      }
      $roles_array = $request->roles;
      if(Auth::user()->id==4 && $user->id==4){
        array_push($roles_array,4);
      }
      $user->roles()->sync($roles_array);
    	return redirect('users')->with('message', 'User Updated!');
    }

    private function getRequest(Request $request){

    	$data = $request->all();
    	if($request->hasFile('photo')){
    		$photo = $request->file('photo');
        $fileName = Carbon::now()->format('d-m-Y-H-i-s-' . Auth::user()->id);
    		$destination = $this->upload_dir;
    		$photo->move($destination,$fileName);
    		$data['photo'] = $fileName;
    	}

    	return $data;
    }

    public function store(Request $request)
    {
    	$this->validate($request, $this->rules);

    	$data = $this->getRequest($request);
    	// $request->user()->users()->create($data);
    	// User::create($request->all());
      if($data['email']==""){
        $data['email']=" ";
      }
      if(!empty($data['send_text_at_fueling'])){
        $send_text_at_fueling=1;
      }else{
        $send_text_at_fueling=0;
      }
      if(!empty($data['send_email_at_fueling'])){
        $send_email_at_fueling=1;
      }else{
        $send_email_at_fueling=0;
      }
      if($data['cell_number']==""){
        $data['cell_number'] = "**" . str_random(40);
      }
      if(!empty($data['cell_provider'])){
        if($data['cell_provider']==""){
          $data['cell_provider'] = "";
        }
      }else{
        $data['cell_provider'] = "";
      }
      if(!empty($data['login_account_id'])){
        if($data['login_account_id']==""){
          $data['login_account_id'] = "";
        }
      }else{
        $data['login_account_id'] = "";
      }
      if(!empty($data['fuel_group_id'])){
        if($data['fuel_group_id']==""){
          $data['fuel_group_id'] = "";
        }
      }else{
        $data['fuel_group_id'] = "";
      }

    	$user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'cell_number' => $data['cell_number'],
            'cell_provider' => $data['cell_provider'],
            'login_account_id' => $data['login_account_id'],
            'fuel_group_id' => $data['fuel_group_id'],
            'company_id' => $request->user()->company()->first()->id,
            'send_text_at_fueling' => $send_text_at_fueling,
            'send_email_at_fueling' => $send_email_at_fueling,
            'PIN' => $data['PIN'],
        ]);
        if(!empty($data['photo'])){
          $user->update([
            'photo' => $data['photo'],
          ]);
        }
        $user->roles()->sync($request->roles);
        $this->sync_assignments($user, $request);

    	return redirect('users')->with('message', 'User Saved!');
    }

    public function destroy($id){

    	$contact = User::findOrFail($id);
        // $this->authorize('modify', $contact);
    	$contact->delete();
    	$this->removePhoto($contact->photo);
    	return redirect('users')->with('message','User Deleted!');
    }

    private function removePhoto($photo)
    {
    	if( ! empty($photo)){
    		$file_path = $this->upload_dir . '/' . $photo;
    		if( file_exists($file_path) ) unlink($file_path);
    	}
    }
}
