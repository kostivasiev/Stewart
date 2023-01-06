<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelGroup extends Model
{

    protected $fillable = ['name'];

    public function users()
    {
    	return $this->hasMany('App\User');
    }

		public function equipment()
    {
    	return $this->belongsToMany('App\Equipment');
    }

		public function fuel_pump()
    {
    	return $this->belongsToMany('App\FuelPump');
    }
}
