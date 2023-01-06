<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuelGroup;
use App\User;
use Auth;

class FuelGroupController extends Controller
{
  public function index(Request $request){
    $pieces = $request->user()->company()->first()->stations()->paginate(10);
    return view('fuel_groups.index', compact('pieces'));
  }

  public function ajax_update (Request $request)
  {
    $data = $request->all();
    $fuel_group = FuelGroup::find($data['id']);
    $fuel_group->update($data);
    return $fuel_group;
  }

  public function store(Request $request)
  {
      $data = $request->all();
      $group = Auth::user()->company()->first()->fuel_groups()->create($data);
      return view('fuel_groups.partials.edit_group', compact('group'));
  }

  public function update_equipment_assignment(Request $request)
  {
      $data = $request->all();
      $fuel_group = FuelGroup::find($data['group_id']);
      if($data['checked']=="true"){
        $fuel_group->equipment()->attach($data['equipment_id']);
      }else{
        $fuel_group->equipment()->detach($data['equipment_id']);
      }
      return $fuel_group;
  }

  public function update_station_assignment(Request $request)
  {
      $data = $request->all();
      $fuel_group = FuelGroup::find($data['group_id']);
      if($data['checked']=="true"){
        $fuel_group->fuel_pump()->attach($data['pump_id']);
      }else{
        $fuel_group->fuel_pump()->detach($data['pump_id']);
      }
      return $fuel_group;
  }

  public function update_user_assignment(Request $request)
  {
      $data = $request->all();
      $fuel_group = FuelGroup::find($data['group_id']);
      $user = User::find($data['user_id']);

      $user->update([
            'fuel_group_id' => $data['group_id'],
        ]);


      // if($data['checked']=="true"){
      //   $fuel_group->fuel_pump()->attach($data['station_id']);
      // }else{
      //   $fuel_group->fuel_pump()->detach($data['station_id']);
      // }

      return $fuel_group;
  }

  public function ajax_destroy(Request $request){

      $data = $request->all();
      $fuel_group = FuelGroup::findOrFail($data['id']);
      $fuel_group->delete();
      return "Complete";
  }
}
