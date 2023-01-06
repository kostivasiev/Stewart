<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Emodel;

class EmodelController extends Controller
{
  public function index_from_make(Request $request){

    // if($request->ajax()){
      // return Emodel::all();
      $contacts = Emodel::where(function($query) use ($request) {
        $query->where("make_id",$request->make_id);

      })->get();;

      return $contacts;
      // }
      return "";
  }

  public function store(Request $request)
  {
      // $this->validate($request, $this->rules);

    return Emodel::create($request->all());
      // $data = $request->all();
      // return $request->create($data);

      // return $request->equipmentType()->make()->create($data);
  }
}
