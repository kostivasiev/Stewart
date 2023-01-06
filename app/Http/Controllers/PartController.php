<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DefaultPart;
use App\Part;
use App\Equipment;
use App\EquipmentType;
use App\Emodel;
use App\Interval;
use App\Year;
use Auth;

class PartController extends Controller
{
    public function assign_intervals(Request $request){

      $interval = Interval::find($request->interval_id);
      $interval->parts()->sync($request->checked);
      return "done ";
    }

    public function destroy($id){

        $equipment = Equipment::findOrFail($id);
        $this->authorize('modify', $equipment);
        $equipment->delete();
        $this->removePhoto($contact->photo);
        return redirect('equipment')->with('message','Equipment Deleted!');
    }

    public function create(Request $request)
    {
      $equipment_types = Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
      $equipment = Equipment::findOrFail($request->equipment_id);
    	return view("equipment.createpart", compact('equipment_types', 'equipment'));
    }

    public function store(Request $request)
    {
      if(!$request->link){
        $request->link="";
      }
      if(!$request->description){
        $request->description="";
      }
      $part = Part::create([
            'name' => $request->name,
		        'manufacture_part_number' => $request->manufacture_part_number,
						'description' => $request->description,
						'link' => $request->link,
						'company_id' => Auth::user()->company()->first()->id,
        ]);
      return $this->edit($part->id, $request);
    }

    public function edit($id, Request $request)
    {
        $part = Part::find($id);
        $equipment = Equipment::findOrFail($request->equipment_id);
        $equipment_types = Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
        $interval = $part;
        return view("equipment.editpart", compact('part', 'equipment', 'equipment_types', 'interval'));
    }

    public function update ($id, Request $request)
    {
        $part = Part::findOrFail($id);
        $equipment = Equipment::findOrFail(1);

        $data = $request->all();
        $part->update($data);
        $parts = Part::all();

				$part->equipment_types()->sync($request->equipment_types);
				$part->makes()->sync($request->makes);
				$part->models()->sync($request->models);
				$part->years()->sync($request->years);
        $part->equipment()->sync($request->equipment_assignment);

        return redirect('equipment/' . $request->equipment_id . '/parts')->with('message', 'Part Updated!');
    }
}
