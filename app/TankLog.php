<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TankLog extends Model
{
    protected $fillable = ['fuel_pump_id', 'current_gallons'];
}
