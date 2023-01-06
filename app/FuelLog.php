<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
  protected $fillable = ['fuel_pump_id', 'tank_log_id', 'user_id', 'equipment_id'
, 'meter_log_id', 'consumed_gallons', 'message', 'type'];

  public function tankLog()
  {
    return $this->hasOne('App\TankLog');
  }

  public function meterLog()
  {
    return $this->belongsTo('App\MeterLog');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function equipment()
  {
    return $this->belongsTo('App\Equipment');
  }

  public function pump()
  {
    return $this->belongsTo('App\FuelPump', 'fuel_pump_id');
  }
}
