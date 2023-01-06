<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    protected $fillable = ['name', 'equipment_type_id'];

    public function equipmentType()
    {
    	return $this->belongsTo(EquipmentType::class);
    }
    public function models() {
        return $this->hasMany('App\Emodel','make_id','id');
    }
}
