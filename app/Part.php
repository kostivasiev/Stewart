<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['name', 'manufacture_part_number', 'description', 'link', 'company_id'];

    public function intervals()
    {
        return $this->belongsToMany('intervals');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_parts');
    }

    public function years()
    {
        return $this->belongsToMany(Year::class, 'part_years');
    }

    public function equipment_types()
    {
        return $this->belongsToMany(EquipmentType::class, 'equipment_type_parts');
    }

		public function makes()
    {
        return $this->belongsToMany(Make::class, 'part_makes');
    }

		public function models()
    {
        return $this->belongsToMany(Emodel::class, 'emodel_parts');
    }
}
