<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelStation extends Model
{
    protected $fillable = ['name', 'tunnel_port'];

    public function pumps()
    {
    	return $this->hasMany('App\FuelPump');
    }
}
