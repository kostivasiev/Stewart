<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Part;
use App\Year;

class YearController extends Controller
{
  public function assign_parts(Request $request){
    $part = Part::find($request->part_id);
    return $part->years()->sync($request->checked);
  }
  public function index_from_model(Request $request){

    // if($request->ajax()){
      // return Emodel::all();
      $contacts = Year::where(function($query) use ($request) {
        $query->where("emodel_id",$request->model_id);

      })->get();;

      return $contacts;
      // }
      return "";
  }

  public function store(Request $request)
  {
      // $this->validate($request, $this->rules);

    return Year::create($request->all());
      // $data = $request->all();
      // return $request->create($data);

      // return $request->equipmentType()->make()->create($data);
  }

}
