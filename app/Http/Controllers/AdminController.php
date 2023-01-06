<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AdminController extends Controller
{

  public function __construct(){
    $this->middleware(['auth']);
    // $this->roles = 'Super Admin';
    // $this->middleware('auth');
  }

  public function index(Request $request){

      // \DB::enableQueryLog();
      // listGroups($request->user()->id);
      // dd(\DB::getQueryLogs());

    $users = User::where(function($query) use ($request) {
      // $query->where("user_id",$request->user()->id);
          // if($group_id=($request->get('group_id'))){
          // 	$query->where('group_id', $group_id);
          // }

          // if( ($term = $request->get("term"))){

          // 	$keywords = '%' . $term . '%';
          // 	$query->orWhere("name", 'LIKE', $keywords);
          // 	$query->orWhere("company", 'LIKE', $keywords);
          // 	$query->orWhere("email", 'LIKE', $keywords);
          // }
            })
            ->paginate(10);

    return view('admin.index', compact('users'));
  }
  public function permissions(Request $request){
    $user = Auth::user();
    
    return view('auth.permissions');
  }
}
