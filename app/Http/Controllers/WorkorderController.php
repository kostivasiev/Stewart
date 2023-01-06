<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Equipment;
use App\MeterLog;
use App\Interval;
use App\IntervalLog;
use App\Part;
use App\Year;
use App\User;
use App\Workorder;
use App\WorkorderLog;
use Carbon\Carbon;
use App\EquipmentTypeInterval;
use App\IntervalMake;
use App\EmodelInterval;
use App\IntervalYear;
use App\EquipmentInterval;
use App\WorkorderPhoto;
use Auth;
use Collection;
use DB;

class WorkorderController extends Controller
{

  private $upload_dir = 'public/uploads';

  public function __construct(){
    $this->middleware(['auth']);
    $this->middleware('roles:View Workorders');
    $this->upload_dir = base_path() . '/' . $this->upload_dir;
  }

  public function map(Request $request){


    return view('map.map');
  }

  public function index(Request $request){

    DB::enableQueryLog();
    $status=0;
    $workorders = Workorder::where('workorders.company_id', $request->user()->company()->first()->id)

    ->where(function($query) use ($request) {
      if( ($stat = $request->get("status"))){
        $status = $stat;
        $query->where('status', $stat);
      }else{
        $query->whereIn('status', [1,2]);
      }
      if( ($type_ids = $request->get("types"))){
        $query->whereIn('status', explode(",", $type_ids));
      }
      if( ($user_ids = $request->get("users"))){
        $query->whereIn('user_id', explode(",", $user_ids));
      }
      if( ($tag_ids = $request->get("tags"))){
        $query->whereIn('tag_workorder.tag_id', explode(",", $tag_ids));
      }
      if( ($equipment_id = $request->get("equipment_id"))){
        $query->where('equipment_id', $equipment_id);
      }
      // $query->where('workorders.id', '>', '915');
      
      
    })
    ->orderBy('workorders.created_at','desc')
    ->select('workorders.*')
    ->groupBy('workorders.id');

    if( ($tag_ids = $request->get("tags"))){
      $workorders = $workorders->join('tag_workorder', 'workorders.id', '=', 'tag_workorder.workorder_id')
      ->havingRaw("COUNT(DISTINCT(tag_workorder.tag_id)) > " . (count(explode(",", $request->get("tags")))- 2));
    }
    // $workorders->get();
    // dd(DB::getQueryLog());
    $workorders = $workorders->paginate(25);

    return view('workorders.index', compact('workorders', 'status', 'tag_ids'));
  }
  public function status_view(Request $request){

    $workorders = Workorder::where('company_id', $request->user()->company()->first()->id)
    ->orderBy('workorders.created_at','desc')
    ->get();

    return view('workorders.intervals_view', compact('workorders'), $this->current_intervals($request));
  }
  public function interval_view(Request $request){

    // $data = $request->all();
    $equipments = $request->user()->company()->first()->equipment()
    // ->where(function($query) use ($data) {
      // $query->wherein("equipment.id",$data['equipment']);
    // })
    // ->limit(10)
    ->get();

    foreach($equipments as $equipment){
      $equipment = $equipment->get_and_caluculate_intervals();
    }
    $equipments = $equipments->sortBy('name')->sortBy('delta_meter');

    // Workorder::find(1)->equipment();

    return view('workorders.intervals_view', compact('equipments'));
  }
  public function create()
  {
    $current_meter = 940;
    $intervals = Interval::all();
    $today = date("Y-m-d");
    foreach ($intervals as $interval) {
      $date = Carbon::parse($interval->date_due);
      $interval->date_next = $date->addDays($interval->date_interval);
      $interval->meter_next = $current_meter + $interval->meter_interval;
      $interval->today_time = strtotime($today);
      $interval->today_time_plus_alert = strtotime($today);
      $interval->date_due_st = strtotime($interval->date_due);
    }
    $parts = Part::all();
    return view("workorders.create", compact('intervals','parts', 'current_meter'));
  }

public function intervals_legend(Request $request){
  return $request->user()->company()->first()->calculated_intervals();
  return $this->current_intervals($request);
}
public function current_intervals(Request $request)
{
  $today = date("Y-m-d");
  $okay_status=0;
  $upcoming_status=0;
  $current_status=0;
  $overdue_status=0;
  $other=0;
  $cnt=0;
  $type = !empty($_GET['type']) ? $_GET['type'] : -1;
  $equipments = $request->user()->company()->first()->equipment()->get();
  foreach ($equipments as $equipment) {
    $current_meter = 1;
    $meter_log = $equipment->meter()->orderBy('created_at', 'desc')->first();
    if(!empty($meter_log)){
      $current_meter = $meter_log->current;
    }
    $intervals= array();
    foreach ($equipment->intervals()->get() as $interval) {
      $cnt++;
      $interval->due_in_text="";



      $interval->meter_next = $current_meter + $interval->meter_interval;

      $interval->interval_status=-1;
      if($interval->meter_interval!=0){
        if($current_meter + $interval->meter_alert < $interval->meter_due){
          $interval->interval_status=0; //"Okay";
        }else if($current_meter < $interval->meter_due){
          $interval->interval_status=1; //"Upcomming";
        }else if($current_meter < $interval->meter_due + $interval->meter_alerts){
          $interval->interval_status=2; //"Current";
        }else{
          $interval->interval_status=3; //"Overdue";
        }
        $due_in_meter_reading = $interval->meter_due - $current_meter;
        if($due_in_meter_reading<0){
          $due_in_meter_reading*=-1;
          $interval->due_in_text = "Overdue by $due_in_meter_reading hours";
        }else{
          $interval->due_in_text = "Due In $due_in_meter_reading hours";
        }
      }

      if($interval->date_interval!=0){
        $date_due = Carbon::parse($interval->date_due);
        $interval->date_due_in_days = $date_due->diffInDays(\Carbon\Carbon::now());
        $interval->date_next = Carbon::parse($today)->addDays($interval->date_interval);
        $date_due_in_text="";
        if(Carbon::parse($today)->addDays($interval->date_alert) < Carbon::parse($interval->date_due)){
          if($interval->interval_status<=0){
            $interval->interval_status=0;
          }
          $date_due_in_text = "Due in $interval->date_due_in_days days";
        }elseif(Carbon::parse($today) < Carbon::parse($interval->date_due)){
          if($interval->interval_status<=1){
            $interval->interval_status=1;
          }
          $date_due_in_text = "Due in $interval->date_due_in_days days";
        }elseif(Carbon::parse($today) < Carbon::parse($interval->date_due)->addDays($interval->date_alert)){
          if($interval->interval_status<=2){
            $interval->interval_status=2;
          }
          $date_due_in_text = "Due in $interval->date_due_in_days days";//Potential Problem
        }else{
          if($interval->interval_status<=3){
            $interval->interval_status=3;
          }
          $date_due_in_text = "Overdue by $interval->date_due_in_days days";
        }
        if($interval->due_in_text==""){
          $interval->due_in_text = $date_due_in_text;
        }else{
          $interval->due_in_text .= " OR $date_due_in_text";
        }
      }
      switch($interval->interval_status){
        case 0:
          $okay_status++;
          $equipment->okay_status++;
        break;
        case 1:
          $upcoming_status++;
          $equipment->upcoming_status++;
        break;
        case 2:
          $current_status++;
          $equipment->current_status++;
        break;
        case 3:
          $overdue_status++;
          $equipment->overdue_status++;
          break;
        default:
          $other++;
        break;
      }

      array_push($intervals,$interval);
    }
    $equipment->intervals=$intervals;
  }

  // echo "okay_status:$okay_status<br>";
  // echo "upcoming_status:$upcoming_status<br>";
  // echo "current_status:$current_status<br>";
  // echo "overdue_status:$overdue_status<br>";
  // echo "other:$other<br>";
  // echo "cnt:$cnt<br>";
  return compact('okay_status','upcoming_status','current_status','overdue_status','cnt','equipments');
  return json_encode(array("okay_status"=>$okay_status,"upcoming_status"=>$upcoming_status,
  "current_status"=>$current_status));;
}
public function ajax_store(Request $request)
{
  // $this->validate($request, $this->rules);

  $data = $request->all();
  if( $data['due_date']==''){
    $data['due_date'] = 0;
  }
  $workorder = Workorder::create([
        'equipment_id' => $data['equipment_id'],
        'company_id' => $request->user()->company()->first()->id,
        'user_id' => $data['user_id'],
        'due_date' => $data['due_date'],
        'status' => 1
    ]);
    if($data['notes']==""){
      $data['notes']=" ";
    }
    WorkorderLog::create([
          'notes' => $data['notes'],
          'status' => 1,
          'workorder_id' => $workorder->id,
          'user_id' => $request->user()->id,

      ]);

  return $workorder->id;
  }
  public function store(Request $request)
  {
    if($request->workorder_id!=-1){
      return $this->update($request->workorder_id, $request);
    }

    $sync_labor_data = [];
    for($i = 0; $i < count($request->labor); $i++){
      if($request->labor_hours[$i]==0
      || $request->labor_hours[$i]=="") continue;
      $sync_labor_data[$request->labor[$i]] = ['labor' => $request->labor_hours[$i]];
    }

    $data = $request->all();
    if( $data['due_date']==''){
      $data['due_date'] = 0;
    }
    $workorder = Workorder::create([
          'company_id' => Auth::user()->company()->first()->id,
          'status' => $data['workorder_status'],
          'equipment_id' => $data['equipment_id'],
          'user_id' => $data['user_id'],
          'due_date' => $data['due_date']
      ]);
      $workorder->labor()->attach($sync_labor_data);
      if($data['notes']==""){
        $data['notes']=" ";
      }
      WorkorderLog::create([
            'notes' => $data['notes'],
            'status' => 1,
            'workorder_id' => $workorder->id,
            'user_id' => $request->user()->id,
        ]);
        $meter_log = MeterLog::create([
              'current' => $request->current_meter,
              'equipment_id' => $data['equipment_id'],
              'user_id' => $request->user()->id
          ]);
    if($request->tags!=null){
      $workorder->tags()->sync($request->tags);
    }

    return redirect('workorders')->with('message', 'Work Order Saved!');
  }

  public function edit($id)
  {

    

      $workorder = Workorder::find($id);
      $equipment = Equipment::findOrFail($workorder->equipment_id);
      $meter_log = $equipment->meter()->orderBy('created_at', 'desc')->first();
      $current_meter = 1;

      if(!empty($meter_log)){
        $current_meter = $meter_log->current;
      }
      $intervals = Interval::all();
      foreach ($intervals as $interval) {
        $interval->next_date = $interval->date_due;
        $interval->next_meter = 23;
      }
      $mechanics = User::whereHas(
        'roles', function($q){
                  $q->where('name', 'Mechanic');
              }
          )->get();
      // $pieces = Equipment::where(function($query) use ($request) {
      //   $query->where("user_id",$request->user()->id);
      // $this->authorize('modify', $equipment);
      return view("workorders.edit", compact('workorder','intervals', 'current_meter', 'mechanics'));
  }

  public function intervals(Request $request)
  {
      // $request->equipment_id=34;
      $equipment = Equipment::find($request->equipment_id ); //$request->equipment_id 34
      // $equipment->delta_meter = 99999999;
      // $equipment->current_meter = $equipment->current_meter();
      $equipment = $equipment->get_and_caluculate_intervals();

      // foreach($equipment->intervals as $interval){
      //   if($equipment->delta_meter>=$interval->delta_meter){
      //     $equipment->delta_meter = $interval->delta_meter;
      //   }
      // }
      $intervals = $equipment->intervals;
      $current_meter = $equipment->current_meter;
      if($request->hour_flag==1){
        return view("workorders.partials.intervals_by_meter", compact('intervals','current_meter'));
      }else if($request->hour_flag==3){
        return view("workorders.partials.intervals_table", compact('intervals','current_meter'));
      }else{
        return view("workorders.partials.intervals", compact('equipment'));
      }
  }



  public function intervalnotes(Request $request)
  {
    $workorder = Workorder::find($request->workorder_id);
    return view("workorders.partials.intervalnotes", compact('workorder'));
  }

  public function add_labor_fields(Request $request)
  {
    $workorder = Workorder::find($request->workorder_id);

    $mechanics = User::whereHas(
      'roles', function($q){
                $q->where('name', 'Mechanic');
            }
        )->get();

    return view("workorders.partials.labor", compact('workorder', 'mechanics'));
  }

  public function reset_interval(Request $request){


    $interval = Interval::findOrFail($request->interval_id);
    $equipment_interval = EquipmentInterval::where('interval_id', $request->interval_id)->where('equipment_id', $request->equipment_id)->first();

    $equipment_interval->meter_due = $request->meter_due;
    $equipment_interval->date_due = $request->date_due;
    $equipment_interval->save();
    if(!$request->current_meter){
      return 1;
    }

    $meter_log = MeterLog::create([
          'current' => $request->current_meter,
          'equipment_id' => $request->equipment_id,
          'user_id' => $request->user()->id
      ]);
    // return $equipment_interval->equipment_id;
    if($request->workorder_id>0){
      IntervalLog::create([
            'meter_id' => $meter_log->id,
            'interval_id' => $request->interval_id,
            'user_id' => $request->user()->id,
            'workorder_id' => $request->workorder_id
        ]);
    }

    // return $request->meter_due;
    return $request->current_meter;
  }

  public function tags(Request $request)
  {
    $tags = $request->user()->company()->first()->tags()->orderBy('name')->get();
    if($request->workorder_id==-1){
      return view("workorders.partials.tags", compact('tags'));
    }
      $workorder = Workorder::find($request->workorder_id);

      $assigned_tags = $workorder->tags()->get();
      foreach ($tags as $tag) {
        $tag->checked=false;
        foreach ($assigned_tags as $assigned_tag) {
          if($tag->id==$assigned_tag->id){
            $tag->checked=true;
            break;
          }
        }
      }
      return view("workorders.partials.tags", compact('tags'));
  }

  public function parts(Request $request)
  {
      $equipment = Equipment::find($request->equipment_id);
      // $parts = Year::find($equipment->year_id)->parts;
      $parts=[];
      $parts = $equipment->get_parts();
      return view("workorders.partials.parts", compact('parts'));
  }

  public function currentMeter(Request $request)
  {
    // return 1;
    if($request->ajax()){
      $equipment = Equipment::findOrFail($request->equipment_id);
      $meter_log = $equipment->meter()->orderBy('created_at', 'desc')->first();
      $current_meter = 1;
      if(!empty($meter_log)){
        $current_meter = $meter_log->current;
      }

      return $current_meter;
    }
  }

  public function update_meter(Request $request)
  {
    $meter_log = MeterLog::create([
          'current' => $request->current_meter,
          'equipment_id' => $request->equipment_id,
          'user_id' => $request->user()->id
      ]);
      return $request->equipment_id;
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

  public function add_photo_to_workorder(Request $request){

    

    $file = $request->photo('pic');
    $fileName = Carbon::now()->format('d-m-Y-H-i-s-' . Auth::user()->id);
    $destination = $this->upload_dir;
    return $file;
    $photo->move($destination,$fileName);
    return 1;

    $data = $this->getRequest($request);
    $workorder = Workorder::findOrFail($data['workorder_id']);
    return $request;
    return $workorder->id;
    $workorder_photo = WorkorderPhoto::create([
      'file_path' => $data['photo'],
      'workorder_id' => $workorder->id,
      'name' => $data['photo'],
    ]);

    return $workorder_photo;
  }

  public function update ($id, Request $request)
  {
    $sync_labor_data = [];
    for($i = 0; $i < count($request->labor); $i++){
      if($request->labor_hours[$i]==0
      || $request->labor_hours[$i]=="") continue;

      $sync_labor_data[$request->labor[$i]] = ['labor' => $request->labor_hours[$i]];
    }
      $workorder = Workorder::findOrFail($id);

      // echo $sync_labor_data[1]['labor'];
      // die();
      $workorder->labor()->sync($sync_labor_data);
      $data = $this->getRequest($request);
      // $data = $request->all();
      $data['status'] = $data['workorder_status'];
      $workorder->update($data);
      if($data['notes']==""){
        $data['notes']=" ";
      }
      WorkorderLog::create([
            'notes' => $data['notes'],
            'status' => 1,
            'workorder_id' => $workorder->id,
            'user_id' => $request->user()->id,
        ]);
        $meter_log = MeterLog::create([
              'current' => $request->current_meter,
              'equipment_id' => $data['equipment_id'],
              'user_id' => $request->user()->id
          ]);
      if($request->tags!=null){
        $workorder->tags()->sync($request->tags);
      }
      if($request->hasFile('photo')){
        WorkorderPhoto::create([
          'file_path' => $data['photo'],
          'workorder_id' => $workorder->id,
          'name' => $data['photo'],
        ]);
        // $workorder->photos()->attach($data['photo']);
      }
      // http://localhost:8000/workorders/1890/edit?tags=6,5
      // http://localhost:8000/workorders?tags=4,7,9,3&types=2,1&users=90,91,430,446
      // $get_params = $request->get("tags");
      // echo implode(",", $request->get("tags"));
      // die();
      // echo "tag_filters:" . $request->tag_filters;
      // echo "types:" . sizeof($request->input("types"));
      // echo "users:" . sizeof($request->get("users"));
      $get_params['tags'] = $request->tag_filters;
      $get_params['types'] = $request->type_filters;
      $get_params['users'] = $request->user_filters;
      // echo "equipment_id:" . sizeof($request->get("equipment_id"));
      // if(sizeof($request->get("tags")))
      //   $get_params['tags'] = implode(",", $request->get("tags"));
      // if(sizeof($request->get("types")))
      //   $get_params['types'] = implode(",", $request->get("types"));
      // if(sizeof($request->get("users")))
      //   $get_params['users'] = implode(",", $request->get("users"));
      // die();
      return redirect()->route('workorders.index', $get_params)->with('message', 'Work Order Updated!');
  }


  public function equipment_history(Request $request)
  {
    //151
      $equipment = Equipment::find($request->equipment_id);

      $i=0;
      foreach ($equipment->meter()->get() as $meter_log) {
         $timestamps[$i]  = $meter_log;
      }
      // $fuel_logs = $equipment->meter()->orderBy('created_at', 'DESC')->limit(5)->get();
      $fuel_logs = $equipment->fuel_logs()->wherein('type', [3100, 3101])->orderBy('created_at', 'DESC')->limit(5)->get();

      $workorder_logs = $equipment->workorders()->orderBy('created_at', 'DESC')->limit(10)->get();

      $intervals = $equipment->get_intervals();

      foreach ($intervals as $interval){
        $interval->interval_log = IntervalLog::join('meter_logs', 'interval_logs.meter_id', '=', 'meter_logs.id')
        ->where('interval_id', $interval->id)->where('equipment_id', $equipment->id)->orderby('interval_logs.created_at', 'desc')->limit(5)->get();

      }

      return view("workorders.partials.history", compact('fuel_logs', 'workorder_logs', 'intervals'));
  }

}
