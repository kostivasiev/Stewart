<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;
use App\FuelStation;
use App\FuelPump;
use App\User;
use App\TankLog;

class StationController extends Controller
{

  private $upload_dir = 'public/uploads';

  // public function __construct(){
  //     $this->middleware('auth');
  //     $this->middleware('roles:View Stations');
  //     $this->upload_dir = base_path() . '/' . $this->upload_dir;
  // }

  public function index(Request $request){

    $stations = $request->user()->company()->first()->stations()->paginate(10);;

    return view('stations.index', compact('stations'));
  }

  public function edit($id)
  {
    $station = FuelStation::findOrFail($id);
      // $this->authorize('modify', $contact);
    return view("stations.edit", compact('station'));
  }

  public function update ($id, Request $request)
  {
    // $this->validate($request, $this-> rules);
    $station = FuelStation::findOrFail($id);
    //   // $this->authorize('modify', $contact);
    // $oldPhoto = $contact->photo;
    //
    $data = $request->all();
  // dump($data);
  //   die();

    
    $station->update([
      'name' => $data['name'],
      'tunnel_port' => $data['tunnel_port']
    ]);
    $cnt=0;
    foreach ($data['fuel_pump_ids'] as $pump_id) {

      if(!empty($data['pin_required' . $pump_id])){
        $pin_required=1;
      }else{
        $pin_required=0;
      }
      if(!empty($data['equipment_id_required' . $pump_id])){
        $equipment_id_required=1;
      }else{
        $equipment_id_required=0;
      }
      if(!empty($data['meter_required' . $pump_id])){
        $meter_required=1;
      }else{
        $meter_required=0;
      }
      $pump = FuelPump::findOrFail($pump_id);

      
      $pump->update([
        'name' => $data['pump_names'][$cnt],
        'calibration_number' => $data['calibration_numbers'][$cnt],
        'inactivity_time' => $data['inactivity_times'][$cnt],
        'pin_required' => $pin_required,
        'equipment_id_required' => $equipment_id_required,
        'meter_required' => $meter_required,
        'fuel_type' => $data['fuel_types'][$cnt],
      ]);
      $tanke_log = TankLog::create([
            'fuel_pump_id' => $pump_id,
            'current_gallons' => $data['current_gallons'][$cnt],
        ]);
      $cnt++;

    }
    // $contact->update($data);
    // if($oldPhoto !== $contact->photo){
    //   $this->removePhoto($oldPhoto);
    // }



    return redirect('stations')->with('message', 'Station Updated!');
  }
  public function mirror(Request $request)
  {

    // $invertal_array = app('App\Http\Controllers\WorkorderController')->current_intervals();
    return view('stations.partials.mirror');
  }
}
