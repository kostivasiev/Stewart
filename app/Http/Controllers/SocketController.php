<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;
use App\User;
use App\MeterLog;
use App\TankLog;
use App\FuelLog;
use App\FuelPump;

class SocketController extends Controller
{

    public function validate_equipment(Request $request)
    {
      $equipment = Equipment::where(function($query) use ($request) {
    		$query->where("unit_number",$request->unit_number);
      })->first();
      if(!empty($equipment)){
        return $equipment;
      }else{
        return "false";
      }
    }

    //url:http://192.168.135.6:8000/socket/validate_session?pin=1002&unit_number=1234&fuel_pump_id=1&meter=1000
    public function validate_session(Request $request)
    {

      $request->tank_log_id=-1;
      $request->user_id=-1;
      $request->equipment_id=-1;
      $request->meter_log_id=-1;
      $request->consumed_gallons=-1;
      $request->message="";
      $request->type=-1;


      $user = User::where(function($query) use ($request) {
    		$query->where("PIN",$request->pin);
      })->first();
      if(empty($user)){
        $request->type = 3003;
        $request->message = "Entered PIN: " . $request->pin;
        return $this->fuel_log_insert($request);
      }
      $request->user_id = $user->id;

      $equipment = $user->fuel_group->equipment->where('unit_number', '=', $request->unit_number)->first();
      if(empty($equipment)){
        $request->type = 3003;
        $request->message = "Entered Unit ID: " . $request->unit_number;
        return $this->fuel_log_insert($request);
      }
      $request->equipment_id = $equipment->id;

      $pump = $user->fuel_group->fuel_pump->where('id', '=', $request->fuel_pump_id)->first();
      if(empty($pump)){
        $request->type = 3002;
        $this->fuel_log_insert($request);
        return "Not Authorized for this pump";
      }
      // $request->fuel_pump_id = $pump->id;

      $this->fuel_log_insert($request);
      return $pump;
    }

    //http://192.168.135.6:8000/socket/complete_session?user_id=1&equipment_id=2&fuel_pump_id=1&current_meter=1000&consumed_gallons=30&type=3001
    public function complete_session(Request $request)
    {

      $meter_log = MeterLog::create([
            'current' => $request->current_meter,
            'equipment_id' => $request->equipment_id,
            'user_id' => $request->user_id
        ]);
        $request->meter_log_id = $meter_log->id;

      $current_tank_gallons = FuelPump::find(1)->tank_logs()->orderBy('created_at', 'desc')->first()->current_gallons;
      $tank_log = TankLog::create([
            'fuel_pump_id' => $request->fuel_pump_id,
            'current_gallons' => ($current_tank_gallons - $request->consumed_gallons)
        ]);
      $request->tank_log_id = $tank_log->id;
      $request->message="";
      $fuelLog = $this->fuel_log_insert($request);
      return $fuelLog;
    }

    private function fuel_log_insert($request)
    {

      $fuelLog = FuelLog::create([
            'fuel_pump_id' => $request->fuel_pump_id,
            'tank_log_id' => $request->tank_log_id,
            'user_id' => $request->user_id,
            'equipment_id' => $request->equipment_id,
            'meter_log_id' => $request->meter_log_id,
            'consumed_gallons' => $request->consumed_gallons,
            'message' => $request->message,
            'type' => $request->type,
        ]);
      return $fuelLog;
    }
}
