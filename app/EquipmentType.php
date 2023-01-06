<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    protected $fillable = ['name', 'company_id'];

    public function makes() {
        return $this->hasMany('App\Make','equipment_type_id','id') ;
    }
    public function equipment() {
        return $this->hasMany('App\Equipment');
    }
}
