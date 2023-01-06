<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FuelStation;
use App\FuelLog;
use App\User;
use App\Equipment;
use App\EquipmentTypeInterval;
use App\IntervalMake;
use App\EmodelInterval;
use App\Interval;
use App\IntervalYear;
use App\EquipmentInterval;
use App\IntervalLog;
use App\UserWorkorder;
use App\WorkorderLog;
use App\Workorder;
use Carbon\Carbon;
use Excel;
use Auth;

class ReportController extends Controller
{
  public function __construct(){
    $this->middleware(['auth']);
    $this->middleware('roles:View Reports');
  }

  public function downloadExcel($type, Request $request)
	{
		$logs = FuelLog::where(function($query) {
      $query->where("created_at",">", '2017-03-01');
      $query->wherein("type",[3100,3101]);
    })
      ->get();

      // $data = array();
      foreach ($logs as $log) {
        $log->name = "Smith, John";//$log->user()->first()->last_name . ", " . $log->user()->first()->first_name;
        // $log->forget("meter_log");
        // array_push($data,$log);
      }


     return Excel::create('Report', function($excel) use ($logs,$request) {

      // Set the title
      $excel->setTitle('Our new awesome title');

      // Chain the setters
      $excel->setCreator('You')
            ->setCompany('Stewart Tech');

      // Call them separately
      $excel->setDescription('A demonstration to change the file properties');
      $excel->sheet('Sheet 1', function($sheet) use ($logs, $request)
	        {
				// $sheet->fromArray($logs);
        $data = $request->all();
        $logs = FuelLog::where(function($query) use ($data) {
          $query->where("created_at",">", $data['start_date']);
          $query->where("created_at","<", $data['end_date'] . " 24:00:00");
          $query->wherein("user_id",$data['users']);
          $query->wherein("equipment_id",$data['equipment']);
          $query->wherein("fuel_pump_id",$data['pumps']);
          $query->wherein("type",$data['entries']);
                })
                ->get();
        $sheet->loadView('reports.partials.fuel', compact('logs'));
	        });


    })->download($type);

	}

  public function pivot(Request $request){

    $logs = FuelLog::where(function($query) {
      $query->where("created_at",">", '2017-03-01');
      $query->wherein("type",[3100,3101]);
    })
      ->get();
    return view('reports.pivot', compact('logs'));
  }

  public function index(Request $request){
    return view('reports.index');
  }

  public function users(Request $request){

    $data = $request->all();
    $users = $request->user()->company()->first()->users()->orderBy('last_name')->orderBy('first_name')->get();
    if(!empty($data['download'])){
      return Excel::create('Report', function($excel) use ($users) {

             $excel->setTitle('Our new awesome title');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription('A demonstration to change the file properties');

             $excel->sheet('Sheet 1', function($sheet) use ($users){
               $sheet->loadView('reports.partials.users', compact('users'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.users', compact('users'));
  }

  public function intervals_all_(Request $request){

    $data = $request->all();
    $users = $request->user()->company()->first()->users()->orderBy('last_name')->orderBy('first_name')->get();
    if(!empty($data['download'])){
      return Excel::create('Report', function($excel) use ($users) {

             $excel->setTitle('Our new awesome title');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription('A demonstration to change the file properties');

             $excel->sheet('Sheet 1', function($sheet) use ($users){
               $sheet->loadView('reports.partials.users', compact('users'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.users', compact('users'));
  }

  public function intervals_all(Request $request)
  {
      $data = $request->all();
      $equipments = $request->user()->company()->first()->equipment()
      ->where(function($query) use ($data) {
        $query->wherein("equipment.id",$data['equipment']);
      })
      // ->limit(10)
      ->get();

      foreach($equipments as $equipment){
        $equipment = $equipment->get_and_caluculate_intervals();
      }
      $equipments = $equipments->sortBy('name')->sortBy('delta_meter');

      if(!empty($data['download'])){
        return Excel::create('Report', function($excel) use ($users) {

               $excel->setTitle('Intervals Report');
               $excel->setCreator('Stewart Tech')
                     ->setCompany('Stewart Tech');
               $excel->setDescription('Shows all equipment with accompanying intervals');

               $excel->sheet('Sheet 1', function($sheet) use ($users){
                 $sheet->loadView('reports.partials.intervals_all', compact('equipments'));
               });
             })->download($data['type']);
      }

      return view('reports.partials.intervals_all', compact('equipments'));
  }

  public function adjusted_intervals(Request $request)
  {
      $data = $request->all();
      $equipments = $request->user()->company()->first()->equipment()
      ->where(function($query) use ($data) {
        $query->wherein("equipment.id",$data['equipment']);
      })
      ->get();

      foreach($equipments as $equipment){
        $equipment = $equipment->get_and_caluculate_intervals();
      }
      $equipments = $equipments->sortBy('name')->sortBy('delta_meter');
      if(!empty($data['download'])){
        return Excel::create('Report', function($excel) use ($equipments) {

               $excel->setTitle('Intervals Report');
               $excel->setCreator('Stewart Tech')
                     ->setCompany('Stewart Tech');
               $excel->setDescription('Shows all equipment with accompanying intervals');

               $excel->sheet('Sheet 1', function($sheet) use ($equipments){
                 $sheet->loadView('reports.partials.intervals_all', compact('equipments'));
               });
             })->download($data['type']);
      }

      return view('reports.partials.adjusted_intervals', compact('equipments'));
  }

  public function equipment_assignment(Request $request)
  {
      $data = $request->all();
      $equipment_array = $data['equipment'];
      $equipment_types = $request->user()->company()->first()->equipment_types()->orderBy('name')->get();

      return view('reports.partials.equipment_assignment', compact('equipment_types', 'equipment_array'));
  }
  public function equipment_assignment_by_user(Request $request)
  {
      $users = $request->user()->company()->first()->assigned_equipment_users()->orderBy('last_name')->orderBy('first_name')->get();
      foreach($users as $user){
        $user->equipment = User::findOrFail($user->id)->equipment()->where('daily','=', 1)->orderBy('unit_number')->get();
      }

      return view('reports.partials.equipment_assignment_by_user', compact('users'));
  }

  public function fuel_group_users(Request $request){

    $data = $request->all();
    $users = $request->user()->company()->first()->users()->orderBy('last_name')->orderBy('first_name')->get();
    if(!empty($data['download'])){
      return Excel::create('Report', function($excel) use ($users) {

             $excel->setTitle('Our new awesome title');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription('A demonstration to change the file properties');

             $excel->sheet('Sheet 1', function($sheet) use ($users){
               $sheet->loadView('reports.partials.fuel_group_users', compact('users'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.fuel_group_users', compact('users'));
  }

  public function fuel_group_equipment(Request $request){

    $data = $request->all();
    $equipment = $request->user()->company()->first()->equipment()->orderBy("unit_number")->get();
    if(!empty($data['download'])){
      return Excel::create('Report', function($excel) use ($equipment) {

             $excel->setTitle('Our new awesome title');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription('A demonstration to change the file properties');

             $excel->sheet('Sheet 1', function($sheet) use ($equipment){
               $sheet->loadView('reports.partials.fuel_groups_equipment', compact('equipment'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.fuel_groups_equipment', compact('equipment'));
  }

  public function equipment(Request $request){

    $data = $request->all();
    $equipment = $request->user()->company()->first()->equipment()->orderBy("unit_number")->get();
    if(!empty($data['download'])){
      return Excel::create('Report', function($excel) use ($equipment) {

             $excel->setTitle('Our new awesome title');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription('A demonstration to change the file properties');

             $excel->sheet('Sheet 1', function($sheet) use ($equipment){
               $sheet->loadView('reports.partials.equipment', compact('equipment'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.equipment', compact('equipment'));
  }

  public function equipment_all(Request $request){

    $data = $request->all();
    $equipment = $request->user()->company()->first()->equipment()
    ->where(function($query) use ($data) {
      $query->wherein("equipment.id",$data['equipment']);
    })
    ->orderBy("unit_number")->get();
    if(!empty($data['download'])){
      return Excel::create('Report', function($excel) use ($equipment) {

             $excel->setTitle('Our new awesome title');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription('A demonstration to change the file properties');

             $excel->sheet('Sheet 1', function($sheet) use ($equipment){
               $sheet->loadView('reports.partials.equipment_all', compact('equipment'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.equipment_all', compact('equipment'));
  }

  public function workorders_labor_by_user(Request $request){
    $data = $request->all();

    $logs = UserWorkorder::join('users', 'users.id', '=', 'user_workorder.user_id')
    ->join('workorders', 'workorders.id', '=', 'user_workorder.workorder_id')
    ->join('equipment', 'workorders.equipment_id', '=', 'equipment.id')
    ->where(function($query) use ($data) {
      $query->where("workorders.created_at",">", $data['start_date']); //$data['start_date'] '2017-04-06'
      $query->where("workorders.created_at","<", $data['end_date'] . " 24:00:00");
      $query->wherein("users.id",$data['users']);
      $query->wherein("equipment.id",$data['equipment']);

    })
    ->orderby('last_name')->orderby('first_name')
    ->orderby('workorders.updated_at', 'desc')
    ->get(['first_name',
           'last_name',
           'workorders.updated_at',
           'workorder_id',
           'equipment.unit_number',
           'equipment.name',
           'labor']);
                                                    //  echo $data['equipment'];

    // echo "download:" . $data['download'] . "<br><br>";
    if(!empty($data['download'])){

      return Excel::create('Report', function($excel) use ($logs) {

             $excel->setTitle('Work Orders by User');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription(' ');

             $excel->sheet('Sheet 1', function($sheet) use ($logs){
               $sheet->loadView('reports.partials.workorders_by_user', compact('logs'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.workorders_by_user', compact('logs'));
  }
  public function workorders_by_user(Request $request){
    $data = $request->all();

    $logs = Workorder::where('workorders.company_id','=',1)
    ->leftJoin('user_workorder', 'workorders.id', '=', 'user_workorder.workorder_id')
    ->join('workorder_logs', 'workorders.id', '=', 'workorder_logs.workorder_id')
    ->leftJoin('users', 'users.id', '=', 'workorder_logs.user_id')
    ->join('equipment', 'workorders.equipment_id', '=', 'equipment.id')
    ->where(function($query) use ($data) {
      $query->where("workorders.created_at",">", $data['start_date']); //$data['start_date'] '2017-04-06'
      $query->where("workorders.created_at","<", $data['end_date'] . " 24:00:00");
      $query->wherein("users.id",$data['users']);
      $query->wherein("equipment.id",$data['equipment']);

    })
    ->orderBy('last_name')
    ->orderBy('workorder_logs.created_at')
    ->get(['first_name',
           'last_name',
           'workorders.updated_at',
           'workorder_logs.workorder_id',
           'equipment.unit_number',
           'equipment.name',
           'labor']);
                                                    //  echo $data['equipment'];
    // echo "download:" . $data['download'] . "<br><br>";
    if(!empty($data['download'])){

      return Excel::create('Report', function($excel) use ($logs) {

             $excel->setTitle('Work Orders by User');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription(' ');

             $excel->sheet('Sheet 1', function($sheet) use ($logs){
               $sheet->loadView('reports.partials.workorders_by_user', compact('logs'));
             });
           })->download($data['type']);
    }
    return view('reports.partials.workorders_by_user', compact('logs'));
  }

  // select first_name, last_name,workorder_id,labor
  //  from user_workorder
  // inner join users
  // on user_workorder.user_id = users.id
  // order by workorder_id;

  public function workorders_by_equipment(Request $request){

    $data = $request->all();
    $logs = UserWorkorder::join('users', 'users.id', '=', 'user_workorder.user_id')
    ->join('workorders', 'workorders.id', '=', 'user_workorder.workorder_id')
    ->join('equipment', 'workorders.equipment_id', '=', 'equipment.id')
    ->where(function($query) use ($data) {
      $query->where("workorders.created_at",">", $data['start_date']); //$data['start_date'] '2017-04-06'
      $query->where("workorders.created_at","<", $data['end_date'] . " 24:00:00");
      $query->wherein("users.id",$data['users']);
      $query->wherein("equipment.id",$data['equipment']);

    })
    ->orderby('equipment.unit_number')
    ->orderby('workorders.updated_at', 'desc')->get(['first_name',
                                                     'last_name',
                                                     'workorders.updated_at',
                                                     'workorder_id',
                                                     'equipment.unit_number',
                                                     'equipment.name',
                                                     'labor']);
                                                    //  echo $data['equipment'];
    // echo "download:" . $data['download'] . "<br><br>";
    if(!empty($data['download'])){

      return Excel::create('Report', function($excel) use ($logs) {

             $excel->setTitle('Work Orders by User');
             $excel->setCreator('You')
                   ->setCompany('Stewart Tech');
             $excel->setDescription(' ');

             $excel->sheet('Sheet 1', function($sheet) use ($logs){
               $sheet->loadView('reports.partials.workorders_by_user', compact('logs'));
             });
           })->download($data['type']);
    }
      // $logs = Equipment::find(151)->get();
    return view('reports.partials.workorders_by_equipment', compact('logs'));
  }
  public function fuel_report(Request $request){

      $data = $request->all();

      // $workorders = Workorder::join('equipment', 'equipment.id', '=', 'workorders.equipment_id')
      // ->where('company_id', $request->user()->company()->first()->id)
      // ->orderBy('workorders.created_at','desc')
      // ->select('workorders.*')
      // ->get();


      $logs = FuelLog::join('fuel_pumps', 'fuel_pumps.id', '=', 'fuel_logs.fuel_pump_id')
      ->join('fuel_stations', 'fuel_stations.id', '=', 'fuel_pumps.fuel_station_id')
      ->where('company_id', $request->user()->company()->first()->id)
      ->select('fuel_logs.*')

      ->where(function($query) use ($data) {
        $query->where("fuel_logs.created_at",">", $data['start_date']); //$data['start_date'] '2017-04-06'
        $query->where("fuel_logs.created_at","<", $data['end_date'] . " 24:00:00");
        $query->wherein("fuel_logs.user_id",$data['users']);
        $query->wherein("fuel_logs.equipment_id",$data['equipment']);
        $query->wherein("fuel_logs.fuel_pump_id",$data['pumps']);
        $query->wherein("fuel_logs.type",$data['entries']);
      })->orderBy("fuel_logs.created_at")->get();


      if(!empty($data['download'])){
        return Excel::create('Report', function($excel) use ($logs) {

               $excel->setTitle('Our new awesome title');
               $excel->setCreator('You')
                     ->setCompany('Stewart Tech');
               $excel->setDescription('A demonstration to change the file properties');

               $excel->sheet('Sheet 1', function($sheet) use ($logs){
                 $sheet->loadView('reports.partials.fuel', compact('logs'));
               });
             })->download($data['type']);
      }
    return view('reports.partials.fuel', compact('logs'));
  }
}
