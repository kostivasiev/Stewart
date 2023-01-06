<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentFuelGroup extends Model
{
  public function groups()
  {
    return $this->hasMany('App\FuelGroup');
  }
}
