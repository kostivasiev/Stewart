<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interval;
use App\Part;
use App\Equipment;
use App\Emodel;
use App\Year;
use App\DefaultInterval;
use Auth;

class IntervalController extends Controller
{
	private function is_assigned($part, $assigned_parts){
    foreach ($assigned_parts as $assigned_part) {

      if($part->id == $assigned_part->id) return true;
    }
    return false;
  }

	public function index(Request $request){
		$intervals = Interval::where('status', 1)->get();
		$equipment_types = Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
		return view('intervals.index', compact('intervals', 'equipment_types'));
	}



		public function add_default_interval(Request $request)
    {
			// 'name', 'notes', 'meter_interval', 'meter_alert', 'meter_due', 'date_interval', 'date_alert', 'date_due', 'default_interval_id', 'year_id'

        // $interval = Interval::create($id);
				$defaultInterval = DefaultInterval::find($request->interval_id);
				$interval = Interval::create([
              'name' => $defaultInterval->name,
			        'notes' => $defaultInterval->notes,
							'meter_interval' => $defaultInterval->meter_interval,
							'meter_alert' => $defaultInterval->meter_alert,
							'date_interval' => $defaultInterval->date_interval,
							'date_alert' => $defaultInterval->date_alert,
							'default_interval_id' => $defaultInterval->id,
							'equipment_id' => $request->equipment_id,
          ]);
        $defaultInterval = DefaultInterval::find($interval->default_interval_id);
        $equipment = Equipment::findOrFail(1);
				$assigned_parts = DefaultInterval::find($interval->default_interval_id)->parts;
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

		public function ajax_update (Request $request)
    {
      // echo "moere";
      // die();
        // $this->validate($request, $this-> rules);
        $interval = Interval::find($request->interval_id);
        // $this->authorize('modify', $equipment);

        $data = $request->all();
        $interval->update($data);
        $request->id = $request->equipment_id;

        return $this->intervals($request->equipment_id, $request);

    }

		public function update ($id, Request $request)
    {
      // echo "moere" . $id;
      // die();
        // $this->validate($request, $this-> rules);
        $interval = Interval::find($id);
        // $this->authorize('modify', $equipment);

        $data = $request->all();
        $interval->update($data);

				$interval->equipment_types()->sync($request->equipment_types);
				$interval->makes()->sync($request->makes);
				$interval->models()->sync($request->models);
				$interval->years()->sync($request->years);

        return redirect('intervals')->with('message', 'Interval Updated!');

    }

		public function intervals($id, Request $request){

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

		public function edit($id){
			$interval = Interval::find($id);
			$parts = [];
			$equipment_types = Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
			return view("intervals.edit", compact('interval', 'parts', 'equipment_types'));
		}

		public function create(){
			$parts = [];
			$equipment_types = Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
			return view("intervals.create", compact('parts', 'equipment_types'));

		}

		public function store(Request $request){


			$data = $request->all();
			$interval = $request->user()->company()->first()->intervals()->create($data);


			// $interval = Interval::find($id);
			$parts = [];
			$equipment_types = Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
			return view("intervals.edit", compact('interval', 'parts', 'equipment_types'));
		}

		public function destroy($id){

        $interval = Interval::findOrFail($id);
				$interval->status = 0;
				$interval->save();
        return redirect('intervals')->with('message','Interval Removed!');
    }



}
