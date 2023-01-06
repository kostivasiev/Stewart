<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

/*
  This class uses GuzzleHttp
  https://medium.com/laravel-5-the-right-way/using-guzzlehttp-with-laravel-1dbea1f633da
*/
class MapController extends Controller
{

    public function map()
    {
    	return view('map.map');
    }

    public function index()
    {
      $client = new Client();
      $result = $client->get('https://apistaging.orbitbhyve.com/v1/devices?user_id=5942e65de4b0bab832e0207e', [
          'headers' => [
              'orbit-app-id' => 'Orbit Support Dashboard',
              'orbit-api-key' => ' eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXUyJ9.eyJ1c2VyLWlkIjoiNTYwZWUzODVlNGIwYmY1NDhkODg3ZWE4IiwiYXBwLWlkIjoiT3JiaXQgU3VwcG9ydCBEYXNoYm9hcmQifQ.nUfLvoI_1Fohs9pMzxdjcid3C6i3jop8Nv4dFJKMkmo',
              'Content-Type' => 'application/json'
          ]
      ]);
      // echo $result->getBody() . "<br>";
      $devices = json_decode($result->getBody(),false);
      usort($devices, function($a, $b) { //Sort the array using a user defined function
    return $a->name < $b->name ? -1 : 1; //Compare the scores
});
      $a = array();

      //react-native log-android
      //react-native log-ios
      foreach ($devices as $device) {
        // echo $device->type . "<br><br><br>";
        if($device->type=="center_pivot"){
          if($device->name=="Platt Half") {
            $width = 180;
            $azimuth = 90;
          }else if($device->name=="Pacman") {
            $width = 310;
            $azimuth=5;
          }else if($device->name=="South Bar V") {
            $width = 188;
            $azimuth=-33;
          }else{
            $width = 360;
            $azimuth=0;
          }
          $element = array('id'=>$device->id,
                'lat'=>$device->location->coordinates[1],
                'lng'=>$device->location->coordinates[0],
                'radius'=>$device->pivot_length,
                'name'=>$device->name,
                'control_mode'=>$device->status->control_mode,
                'speed_percent'=>$device->status->speed_percent,
                'pressure'=>round($device->status->pressure,1),
                'is_connected'=>$device->is_connected,
                'width'=>$width,
                'azimuth'=>$azimuth,
                'drive_status'=>$device->status->drive_status,
                'pump_status' => $device->status->pump_status,
                'angle' => $device->status->position);
            array_push($a, $element);
        }
      }
      // echo $json->name;
      // $a = array(
      //   array('id'=>$json->id,
      //         'lat'=>$json->location->coordinates[1],
      //         'lng'=>$json->location->coordinates[0],
      //         'radius'=>$json->pivot_length,
      //         'pressure'=>$json->status->pressure,
      //         'width'=>360,
      //         'azimuth'=>0,
      //         'drive_status'=>$json->status->drive_status,
      //         'pump_status' => $json->status->pump_status,
      //         'angle' => $json->status->position),
      //
      //   array('id'=>'asdf123','lat'=>37.718379,'lng'=>-113.669644, 'radius'=>1300, 'pressure'=>12, 'width'=>338, 'azimuth'=>350,'drive_status'=>'reverse', 'pump_status' => 'off', 'angle' => 10)
      // );
      $encoded = json_encode($a);
      return $encoded;
    }
}
