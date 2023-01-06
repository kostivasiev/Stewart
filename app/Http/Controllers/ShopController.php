<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ShopController extends Controller
{
  public function index(Request $request){

    $this->middleware('roles:View Equipment');

    $pieces = $request->user()->company()->first()->equipment()->where(function($query) use ($request) {
      // $query->where("company_id",$request->user()->company()->find(1)->id);
    })->where(function($query) use ($request) {

      if( ($term = $request->get("term"))){
        $keywords = '%' . $term . '%';
        $query->orWhere("unit_number", 'LIKE', $keywords);
        $query->orWhere("name", 'LIKE', $keywords);
      }
        })
        ->orderBy("unit_number","asc")->limit(5)->get();
            // ->paginate(10);
            Redis::set('name', 'stephanie');
            $name = Redis::get('name');
            $data = [
              'event' => 'UserSignedUp',
              'data' => [
                'username' => 'greg stewart'
              ]
            ];

            Redis::publish('test-channel', json_encode($data));
    return view('shop.index', compact('pieces', 'name'));
  }
}
