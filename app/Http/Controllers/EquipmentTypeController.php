<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EquipmentType;

class EquipmentTypeController extends Controller
{
	public function index(Request $request){

    	// $pieces = EquipmentType::where(function($query) use ($request) {
    		// $query->where("user_id",$request->user()->id);
    				// if($equipment_groups_id=($request->get('equipment_groups_id'))){
    				// 	$query->where('equipment_groups_id', $equipment_groups_id);
    				// }

    				// if( ($term = $request->get("term"))){

    				// 	$keywords = '%' . $term . '%';
    				// 	$query->orWhere("name", 'LIKE', $keywords);
    				// 	// $query->orWhere("email", 'LIKE', $keywords);
    				// 	// $query->orWhere("email", 'LIKE', $keywords);
    				// }
    				// 	})
    				// 	->paginate(10);
			$equipment = Auth::user()->company()->first()->equipment_types()->get();
			return $equipment;
    	return EquipmentType::all();
    }

    public function store(Request $request)
    {
			// return 1;
			$data = $request->all();

			$equipment_type = EquipmentType::create([
						'name' => $data['name'],
						'company_id' => $request->user()->company_id,
				]);
				// return $data['name'];


    	return $equipment_type;
    }
}
