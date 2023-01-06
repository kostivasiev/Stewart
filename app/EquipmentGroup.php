<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentGroup extends Model
{
    protected $fillable = ['name'];

    public function pieces()
    {
    	return $this->hasMany('App\Equipment');
    }
}
