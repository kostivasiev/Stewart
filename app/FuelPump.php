<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelPump extends Model
{
  protected $fillable = ['name', 'station_id', 'calibration_number', 'pin_required',
            'equipment_id_required', 'meter_required', 'equipment_id_type', 'inactivity_time', 'fuel_type'
];


  public function fuel_logs()
  {
    return $this->hasMany('App\FuelLog');
  }

  public function tank_logs()
  {
    return $this->hasMany('App\TankLog');
  }

  public function station()
  {
    return $this->belongsTo('App\FuelStation', 'fuel_station_id');
  }

}
