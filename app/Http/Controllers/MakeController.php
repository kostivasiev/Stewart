<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Make;

class MakeController extends Controller
{

  public function index_from_type(Request $request){

    if($request->ajax()){
      // return Make::all();
      $contacts = Make::where(function($query) use ($request) {
    		$query->where("equipment_type_id",$request->equipment_type_id);

      })->get();;

    	return $contacts;
      }
      return "";
  }

    public function store(Request $request)
    {
        // $this->validate($request, $this->rules);

    	return Make::create($request->all());
        // $data = $request->all();
        // return $request->create($data);

        // return $request->equipmentType()->make()->create($data);
    }
}
