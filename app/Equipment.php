<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Equipment extends Model
{
    protected $fillable = ['name', 'unit_number', 'company_id', 'equipment_groups_id', 'meter_type', 'equipment_type_id', 'make_id', 'emodel_id', 'year_id', 'photo', 'plate_number', 'vin', 'notes', 'fuel_type'];

    public function group()
    {
    	return $this->belongsTo('App\EquipmentGroup');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function photos()
    {
    	return $this->hasMany('App\EquipmentPhoto');
    }
    public function intervals()
    {
    	return $this->hasMany('App\Interval', 'equipment_id', 'id');
    }

    public function parts()
    {
    	return $this->belongsToMany('App\Part', 'equipment_parts', 'equipment_id', 'part_id');
    }

    public function get_parts(){
      $parts = [];
      // echo $this->parts()->pluck('part_id')->toArray();
      $eq_parts = $this->parts()->pluck('part_id')->toArray();
      $parts = array_unique(array_merge($parts, $eq_parts));
      $et_parts = EquipmentTypePart::where('equipment_type_id', $this->equipment_type_id)->pluck('part_id')->toArray();
      $parts = array_unique(array_merge($parts, $et_parts));
      $m_parts = PartMake::where('make_id', $this->make_id)->pluck('part_id')->toArray();
      $parts = array_unique(array_merge($parts, $m_parts));
      $e_parts = EmodelPart::where('emodel_id', $this->emodel_id)->pluck('part_id')->toArray();
      $parts = array_unique(array_merge($parts, $e_parts));
      $y_parts = PartYear::where('year_id', $this->year_id)->pluck('part_id')->toArray();
      $parts = array_unique(array_merge($parts, $y_parts));
      $parts = Part::whereIn('id', $parts)->get();//Removed where clause
      return $parts;
    }

    public function get_intervals(){

      $intervals = [];
      $et_intervals = EquipmentTypeInterval::where('equipment_type_id', $this->equipment_type_id)->pluck('interval_id')->toArray();
      $m_intervals = IntervalMake::where('make_id', $this->make_id)->pluck('interval_id')->toArray();
      $intervals = array_unique(array_merge($et_intervals, $m_intervals));
      $e_intervals = EmodelInterval::where('emodel_id', $this->emodel_id)->pluck('interval_id')->toArray();
      $intervals = array_unique(array_merge($intervals, $e_intervals));
      $y_intervals = IntervalYear::where('year_id', $this->year_id)->pluck('interval_id')->toArray();
      $intervals = array_unique(array_merge($intervals, $y_intervals));
      $intervals = Interval::whereIn('id', $intervals)->where('status', 1)->get();
      return $intervals;
    }

    private function create_intervals_if_needed($intervals){
      $today = date("Y-m-d");
      foreach ($intervals as $interval) {
        $sub_interval = EquipmentInterval::where('interval_id', $interval->id)->where('equipment_id', $this->id);
        if($sub_interval->count()==0){
        //
        // }else{
          $interval->meter_due = $interval->meter_interval + $this->current_meter;
          $interval->date_due = Carbon::parse($today)->addDays($interval->date_interval);
          $interval->equipment_id = $this->id;
          // echo "empty: $interval->date_due<br>";
          EquipmentInterval::create([
                'interval_id' => $interval->id,
                'equipment_id' => $this->id,
                'meter_due' => $interval->meter_due,
                'date_due' => $interval->date_due
            ]);
        }else{
          // echo "Not empty<br>";
          $sub_interval = $sub_interval->first();
          $interval->meter_due  = $sub_interval->meter_due;
          $interval->date_due   = $sub_interval->date_due;
          $interval->equipment_id   = $sub_interval->equipment_id;
        }
        // echo $sub_interval->first() . "<br>";
      }
      return $intervals;
    }

    public function get_and_caluculate_intervals(){
      $this->delta_meter = 99999999;
      $this->current_meter = $this->current_meter();
      $intervals = $this->get_intervals();
      $intervals = $this->create_intervals_if_needed($intervals);

      $this->current_meter_old_value = false;
      foreach($intervals as $interval){

        if($interval->meter_interval!=0){
          $interval->delta_meter = $interval->meter_due - $this->current_meter;
          if(abs($interval->delta_meter) > $interval->meter_interval * 2){
            $this->current_meter_old_value = $this->current_meter;
            $this->current_meter = $this->previous_current_meter();
            $interval->delta_meter = $interval->meter_due - $this->current_meter;
          }
        }else{
          $this->delta_meter=999999;
        }
      }

      $this->intervals = $this->check_interval_status($intervals, $this->current_meter);

      foreach($this->intervals as $interval){
        if($this->delta_meter>=$interval->delta_meter){
          $this->delta_meter = $interval->delta_meter;
        }
      }

      return $this;
    }

    private function check_interval_status($intervals, $current_meter){
      $today = date("Y-m-d");
      $hour_meter_intervals = collect();
      $current_meter_interval = 0;
      foreach ($intervals as $interval) {


        $interval_log = IntervalLog::join('meter_logs', 'interval_logs.meter_id', '=', 'meter_logs.id')
        ->where('interval_id', $interval->id)->where('equipment_id', $this->id)->orderby('interval_logs.created_at', 'desc')->first();
        // $this = Equipment::findOrFail($request->equipment_id);
        // $meter_log = $this->meter()->orderBy('created_at', 'desc')->first();

        // $interval->last_interval_date = $interval_log->created_at;
        if(!empty($interval_log)){
          $interval->last_interval_date = $interval_log->current;
          $interval->interval_log = $interval_log;
        }else{
          $interval->last_interval_date = "";
        }

        if($current_meter_interval != $interval->meter_interval){

          $hour_meter_intervals = collect();
          $hour_meter_intervals->push($interval);

          $interval->hour_meter_intervals = $hour_meter_intervals;
          $interval->hour_meter_intervals_flag=0;
        }else{
          // $hour_meter_intervals->push($interval);
          $interval->hour_meter_intervals_flag++;
        }
        $current_meter_interval = $interval->meter_interval;
        $interval->meter_next = $current_meter + $interval->meter_interval;

        //INSERTED

        $okay     = 0;
        $upcoming = 0;
        $current  = 0;
        $overdue  = 0;
        if ($interval->meter_interval != 0){
          if($this->current_meter + $interval->meter_alert < $interval->meter_due){
            $okay = 1;
            $interval->meter_status = "Okay";
          }else if($this->current_meter < $interval->meter_due){
            $upcoming += 1;
            $interval->meter_status = "Upcomming";
          }else if($this->current_meter < $interval->meter_due + $interval->meter_alert){
            $current += 1;
            $interval->meter_status = "Current";
          }else{
            $overdue += 1;
            $interval->meter_status = "Overdue";
          }
        }

        if ($interval->date_interval != 0){
          $date_due = Carbon::parse($interval->date_due);
          $interval->date_due_in_days = $date_due->diffInDays(\Carbon\Carbon::now());
          // $interval->date_due_in_days = Carbon::now()->diffInDays($date_due);
          $interval->date_next = Carbon::parse($today)->addDays($interval->date_interval);

          if(Carbon::parse($today)->addDays($interval->date_alert) < Carbon::parse($interval->date_due)){
            $okay = 1;
            $interval->date_status="Okay";
          }elseif(Carbon::parse($today) < Carbon::parse($interval->date_due)){
            $upcoming += 1;
            $interval->date_status="Upcomming";
          }elseif(Carbon::parse($today) < Carbon::parse($interval->date_due)->addDays($interval->date_alert)){
            $current += 1;
            $interval->date_status="Current";
          }else{
            $overdue += 1;
            $interval->date_status="Overdue";
          }
        }
        //vvvvvvvvvv
        if($okay && !$upcoming && !$current && !$overdue){
          $this->okay += 1;
        }
        if($upcoming && !$current && !$overdue){
          $this->upcoming += 1;
        }
        if($current && !$overdue){
          $this->current += 1;
        }
        if($overdue){
          $this->overdue += 1;
        }
        //^^^^^^^^^
        $interval->today_time = strtotime($today);
        $interval->today_time_plus_alert = strtotime($today);
        $interval->date_due_st = strtotime($interval->date_due);

        $interval->date_due_formatted = Carbon::parse($interval->date_due)->format('M d, y');
        // $interval->date_due_formatted = $interval->date_next;
      }
      return $intervals;
    }

    public function current_meter(){
      $current_meter = 1;

      $meter_log = $this->meter()->orderBy('created_at', 'desc')->first();
      if(!empty($meter_log)){
        $current_meter = $meter_log->current;
      }
      return $current_meter;
    }

    public function previous_current_meter(){
      $current_meter = 1;

      $meter_log = $this->meter()->orderBy('created_at', 'desc')->skip(1)->first();
      if(!empty($meter_log)){
        $current_meter = $meter_log->current;
      }
      return $current_meter;
    }

    public function last_service(){
      $intervals = $this->get_intervals();
      foreach ($intervals as $interval){
        // echo $interval->logs()->orderBy('id', 'desc')->limit(1)->first();
      }
      return 1;
    }

    public function meter()
    {
    	return $this->hasMany('App\MeterLog');
    }

    public function make()
    {
    	return $this->belongsTo(Make::class);
    }
    public function model()
    {
    	return $this->belongsTo('App\Emodel', 'emodel_id', 'id');
    }
    public function year()
    {
    	return $this->belongsTo(Year::class);
    }
    public function fuel_groups()
    {
    	return $this->belongsToMany('App\FuelGroup');
    }
    public function fuel_logs()
    {
    	return $this->hasMany('App\FuelLog');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function workorders()
    {
    	return $this->hasMany('App\Workorder');
    }
}
