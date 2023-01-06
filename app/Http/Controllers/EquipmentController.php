<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EquipmentType;
use App\Make;
use App\Emodel;
use App\User;
use App\Year;
use App\DefaultEquipmentType;
use App\FuelPump;
use App\FuelGroup;
use App\Equipment;
use App\Part;
use App\Interval;
use App\DefaultInterval;
use App\MeterLog;
use App\DefaultPart;
use App\Variable;
use App\VariableValue;
use App\EquipmentVariableValue;
use App\EquipmentTypeInterval;
use App\IntervalMake;
use App\EmodelInterval;
use App\IntervalYear;
use App\EquipmentInterval;
use DB;
use Auth;
use Carbon\Carbon;

class EquipmentController extends Controller
{
    private $rules = [
            'name' => ['required', 'min:5'],
            'unit_number' => ['required'],
            'photo' => ['mimes:jpg,jpeg,png,bmp'],
            'equipment_groups_id' => ['required'],
            'current_meter' => ['required'],


        ];

    private $upload_dir = 'public/uploads';

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('roles:View Equipment')->except("store", "update");
        $this->middleware('roles:Edit Equipment')->only("store", "update");
        $this->upload_dir = base_path() . '/' . $this->upload_dir;
    }

    private function emodel_query($query){
      $query->whereHas(
        'emodel', function($q){
                  $q->where('emodels.id', $_GET['group_id']);
              }
        );
    }

    private function year_query($query){
      $query->whereHas(
        'year', function($q){
                  $this->emodel_query($q);
                  // $q->where('years.id', $_GET['group_id']);
              }
        );
    }

    public function index(Request $request){

      $num_of_items = !empty($_GET['size']) ? $_GET['size'] : 10;
      $this->middleware('roles:View Equipment');

      // $pieces = DB::select("SELECT equipment.name FROM equipment INNER JOIN years ON equipment.year_id = years.id INNER JOIN emodels ON years.emodel_id = emodels.id INNER JOIN makes ON emodels.make_id = makes.id INNER JOIN equipment_types ON makes.equipment_type_id = equipment_types.id WHERE equipment_types.id = 2");

      $pieces = $request->user()->company()->first()->equipment();
      //   ->join('years', function($join)
      //     {
      //         $join->on('years.id', '=', 'equipment.year_id');
      //     })
      //   ->join('emodels', function($join)
      //     {
      //         $join->on('emodels.id', '=', 'years.emodel_id');
      //     })
      //   ->join('makes', function($join)
      //     {
      //         $join->on('makes.id', '=', 'emodels.make_id');
      //     })
      //   ->join('equipment_types', function($join)
      //     {
      //         $join->on('equipment_types.id', '=', 'makes.equipment_type_id');
      //     });
    	$pieces = $pieces->where(function($query) use ($request) {
    		// $query->where("company_id",$request->user()->company()->find(1)->id);
      })->where(function($query) use ($request) {

        if( ($term = $request->get("term"))){
          $keywords = '%' . $term . '%';
          $query->orWhere("unit_number", 'LIKE', $keywords);
          $query->orWhere("equipment.name", 'LIKE', $keywords);
        }
        if(!empty($_GET['group_id'])){
          // $this->year_query($query);
          $query->whereIn('equipment_type_id', explode(",", $_GET['group_id']));
        }
        if(!empty($_GET['meter_type'])){
          $query->whereIn('meter_type', explode(",", $_GET['meter_type']));
        }
        if(empty($_GET['equipment-in-view'])){
        $query->whereHas(
          'users', function($q){
                    $q->where('users.id', Auth::user()->id);
                }
          );
        }

          })
          ->orderBy("unit_number","asc")
          ->paginate($num_of_items, array('equipment.*'));

    	return view('equipment.index', compact('pieces'));
    }

    public function table(Request $request){

      $pieces = $request->user()->company()->first()->equipment()
      ->orderBy("equipment_type_id")
      ->orderBy("unit_number")
      ->get();

      $equipment_types = Auth::user()->company()->first()->equipment_types()->get();
      return view('equipment.table', compact('pieces', 'equipment_types'));
    }

    public function table_update (Request $request)
    {

      $data = $request->all();

      $equipment = Equipment::find($data['id']);
      // return 1;
      $equipment->update($data);
      return $equipment;
    }

    public function makes(Request $request){
      $data = $request->all();
      $makes = EquipmentType::find($data['equipment_type_id'])->makes;
      return $makes;
    }

    public function emodels(Request $request){
      $data = $request->all();
      return Make::find($data['make_id'])->models;
    }

    public function years(Request $request){
      $data = $request->all();
      return Emodel::find($data['emodel_id'])->years;
    }


    public function autocomplete(Request $request)
    {
    	// if($request->ajax){
    		return Equipment::select(['id', DB::raw('CONCAT("(" , unit_number, ") ", name) AS value')])->where(function($query) use ($request) {

    				if( ($term = $request->get("term"))){

    					$keywords = '%' . $term . '%';
    					$query->orWhere("unit_number", 'LIKE', $keywords);
    					$query->orWhere("name", 'LIKE', $keywords);
    				}
    					})
              ->where('company_id',Auth::user()->company()->first()->id)
    					->orderBy('unit_number', 'asc')
    					->take(5)
    					->get();
    	// }

    }

    // public function parts(Request $request){
    //     $parts = Part::all();
    //     $equipment = Equipment::find($request->id);
    //
    //     return view('equipment.parts', compact('parts'), compact('equipment'));
    // }

    // public function intervals(Request $request){

    //     $intervals = Interval::all();
    //     $parts = Part::all();
    //     $equipment = Equipment::find($request->id);

    //     $parts = Interval::find(1)->parts;

    //     return view('equipment.intervals', compact('parts','intervals','equipment'));
    // }

    public function create()
    {
      $current_meter="";
      $fuel_groups = FuelGroup::where('company_id',Auth::user()->company()->first()->id)->get();
      $equipment_types = EquipmentType::orderBy('name','asc')->get();
      // $first = DB::table('equipment_types');

      // $equipment_types = DB::table('default_equipment_types')->union($first)->get();

      // $equipment_types = DefaultEquipmentType::all()->union($first);
      // $equipment_types = DB::select("SELECT name, id, 1 as def FROM st_laravel.equipment_types union SELECT name, id, 2 as def FROM st_laravel.default_equipment_types ORDER BY name");
      // $equipment_types = DB::select("SELECT name, id, 1 as def FROM equipment_types;");
      $equipment_types = Auth::user()->company()->first()->equipment_types()->get();
      // $equipment_types = DB::table('default_equipment_types')
      // ->raw("")
      //       ->get();
      $fuel_pumps = FuelPump::all();
      $mechanics = User::whereHas(
        'roles', function($q){
                  $q->where('name', 'Mechanic');
              }
          )->get();
    	return view("equipment.create", compact('current_meter', 'fuel_groups', 'equipment_types', 'fuel_pumps', 'mechanics'));
    }

    public function validate_unit_number(Request $request)
    {
      $number_cnt = $request->user()->company()->first()->equipment()->where(function($query) use ($request) {
    		$query->where("unit_number",$request->unit_number);

          })->count();
    	return $number_cnt;
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $data = $this->getRequest($request);
        if(!$data['make_id']){
          $data['make_id'] = 0;
        }
        if(!$data['vin']){
          $data['vin'] = '';
        }
        if(!$data['plate_number']){
          $data['plate_number'] = '';
        }
        if(!$data['notes']){
          $data['notes'] = '';
        }

        $equipment = $request->user()->company()->first()->equipment()->create($data);
        $meter_log = MeterLog::create([
              'current' => $request->current_meter,
              'equipment_id' => $equipment->id,
              'user_id' => $request->user()->id
          ]);

        $equipment->fuel_groups()->sync($request->fuel_groups);
        $equipment->users()->sync($request->assigned);
        return redirect('equipment')->with('message', 'Equipment Saved!');
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

    public function update ($id, Request $request)
    {

        $this->validate($request, $this-> rules);
        $equipment = Equipment::findOrFail($id);
        // $this->authorize('modify', $equipment);
        $oldPhoto = $equipment->photo;

        $data = $this->getRequest($request);

        $equipment->users()->sync($request->assigned);

        foreach ($data as $key => $value) {

          if (strpos($key, 'variable_id_') !== false){
            $arr = explode('variable_id_', $key);
            $variable = Variable::find($arr[1]);
            echo $variable->type;
            $variable->values()->get();
            $variableValues = VariableValue::where('name', $value)->where('variable_id',$variable->id)->get();
            echo $variableValues;
            $found_equipment_value_relationship = false;
            foreach ($variableValues as $vv){
              $equipment_variable_value = EquipmentVariableValue::where('variable_value_id', $vv->id)->where('equipment_id', $equipment->id)->count();
              if($equipment_variable_value>0){
                echo "FOUND<br>";
                $found_equipment_value_relationship=true;
              }else{
                echo "*NOT FOUND<br>";
              }
            }
            if($found_equipment_value_relationship){
              echo "NOT FOUND<br>";
            }
            // foreach ($variable->values()->get() as $v_value) {
            //   echo "$v_value<br>";
            //   if($variable->type=="text"){
            //
            //
            //   }
            // }

            // echo "$key:$arr[1]-$value[" . $variable->type . "]<br>";
          }
        }
        $arr = explode('variable_id_', 'variable_id_1');
        // return $arr[1];
        $equipment->update($data);
        if($oldPhoto !== $equipment->photo){
            $this->removePhoto($oldPhoto);
        }
        $meter_log = MeterLog::create([
              'current' => $request->current_meter,
              'equipment_id' => $id,
              'user_id' => $request->user()->id
          ]);
        $equipment->fuel_groups()->sync($request->fuel_groups);

        // daily_reports

        return redirect('equipment')->with('message', 'Equipment Updated!');
    }

    public function destroy($id){

        $equipment = Equipment::findOrFail($id);
        // $this->authorize('modify', $equipment);
        $equipment->delete();
        $this->removePhoto($equipment->photo);
        return redirect('equipment')->with('message','Equipment Deleted!');
    }

    public function edit($id)
    {
        $equipment = Equipment::find($id);

        // $user = User::where('id',4)->first();
        // echo $user->equipment()->count();

        $meter_log = $equipment->meter()->orderBy('created_at', 'desc')->first();
        $current_meter = 0;
        if(!empty($meter_log)){
          $current_meter = $meter_log->current;
        }

        $fuel_groups = FuelGroup::where('company_id',Auth::user()->company()->first()->id)->get();
        $assigned_fuel_groups = $equipment->fuel_groups()->get();
        foreach ($fuel_groups as $fuel_group) {
          $fuel_group->checked=false;
          foreach ($assigned_fuel_groups as $assigned_fuel_group) {
            if($fuel_group->id==$assigned_fuel_group->id){
              $fuel_group->checked=true;
              break;
            }
          }
        }
        $fuel_pumps = FuelPump::all();
        // $equipment_types = DB::select("SELECT name, id, 1 as def FROM st_laravel.equipment_types WHERE company_id=? union SELECT name, id, 2 as def FROM st_laravel.default_equipment_types ORDER BY name", [Auth::user()->company()->first()->id]);
        $equipment_types = Auth::user()->company()->first()->equipment_types()->get();
        if(empty($equipment->year_id)){
          $equipment->year_id=1;
        }
        // $emodel_id = Year::where('id',$equipment->year_id)->select('emodel_id')->first()->emodel_id;
        // $make_id = Emodel::where('id',$emodel_id)->select('make_id')->first()->make_id;
        // $equipment_type_id = Make::where('id',$make_id)->select('equipment_type_id')->first()->equipment_type_id;
        // echo $emodel_id;
        // die();
        $years = Year::pluck('year', 'id');
        $emodels = Emodel::pluck('name', 'id');
        $makes = Make::pluck('name', 'id');
        $mechanics = User::whereHas(
          'roles', function($q){
                    $q->where('name', 'Mechanic');
                }
            )->get();
        // $this->authorize('modify', $equipment);
        return view("equipment.edit", compact('equipment', 'makes', 'years', 'make_id', 'current_meter', 'fuel_groups', 'fuel_pumps', 'equipment_types', 'emodels', 'emodels', 'mechanics'));
    }

    public function editparts($id)
    {
        $equipment = Equipment::find($id);
        $this->authorize('modify', $equipment);
        return view("equipment.editpart", compact('equipment'));
    }

    private function removePhoto($photo)
    {
        if( ! empty($photo)){
            $file_path = $this->upload_dir . '/' . $photo;
            if( file_exists($file_path) ) unlink($file_path);
        }
    }

    private function is_assigned($part, $assigned_parts){
      foreach ($assigned_parts as $assigned_part) {

        if($part->id == $assigned_part->id) return true;
      }
      return false;
    }

    public function parts($id, Request $request){

      $equipment = Equipment::findOrFail($id);

      $showAll = false;
      if($request->edit){
        $showAll = true;
        $parts = Auth::user()->company()->first()->parts()->get();
      }else {
        $parts = $equipment->get_parts();
      }
      return view('equipment.parts', compact('parts', 'equipment', 'showAll'));
    }


    public function assign_equipment_parts(Request $request){
      $equipment = Equipment::find($request->equipment_id);

      return $equipment->parts()->sync($request->checked);
    }

    public function assign_parts_years(Request $request){
      $year = Year::find($request->year_id);
      return $year->parts()->sync($request->checked);
    }

    public function history($id, Request $request){

  				$equipment = Equipment::find($id);
          return view('equipment.history', compact('equipment'));
      }
    //******INTERVALS***********
    public function intervals($id, Request $request){

  				$equipment = Equipment::find($id);
          return view('equipment.intervals', compact('equipment'));
      }

      public function intervals_create($id, Request $request)
      {
  			$parts = Year::find(1)->parts;
  			$equipment = Equipment::find($id);
      	return view("equipment.createinterval", compact('parts', 'equipment'));
      }

      public function intervals_edit($id, Request $request)
      {
          $interval = Interval::find($request->interval_id);
          $defaultInterval = DefaultInterval::find($interval->default_interval_id);
          $equipment = Equipment::findOrFail($id);
  				$assigned_parts = $interval->parts;
  				$parts = Year::find($equipment->year_id)->parts;
  	      foreach ($parts as $part) {
  	          if($this->is_assigned($part, $assigned_parts)){
  	            $part->assigned = true;
  	          }else{
  	            $part->assigned = false;
  	          }
  	      }
          // $this->authorize('modify', $equipment);
          return view("equipment.editinterval", compact('interval', 'equipment', 'defaultInterval', 'parts'));
      }



      public function intervals_store(Request $request)
      {
          // $this->validate($request, $this->rules);

          Interval::create($request->all());
          // $request->part()->create($data);
          return $this->intervals_redirect($request->equipment_id, $request);
      }

      public function intervals_redirect($id, Request $request){

            $equipment = Equipment::find($id);
            $intervals = $equipment->intervals;

            $defaultIntervals = DefaultInterval::where(function($query) use ($request,$equipment) {
              $query->where("year_id",$equipment->year_id);
            })->get();

            $defaultIntervals = DefaultInterval::where(function($query) use ($request,$equipment) {
              $query->whereNotIn("id", function($q) use ($equipment){
                  $q->select('default_interval_id')
                    ->from('intervals');

            });

          })->where("year_id",$equipment->year_id)
            ->get();

            foreach ($intervals as $interval) {
              $interval->parts = Interval::find($interval->id)->parts;
            }
            $id = $equipment->id;
            return redirect()->route('equipment.intervals', compact('intervals', 'defaultIntervals', 'id'));
        }
}
