<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interval extends Model
{
	protected $fillable = ['name', 'notes', 'meter_interval', 'meter_alert', 'meter_due', 'date_interval', 'date_alert', 'date_due', 'default_interval_id', 'year_id', 'equipment_id'];

    public function parts()
    {
        return $this->belongsToMany(Part::class);
    }

		public function equipment_types()
    {
        return $this->belongsToMany(EquipmentType::class, 'equipment_type_intervals');
    }

		public function makes()
    {
        return $this->belongsToMany(Make::class, 'interval_makes');
    }

		public function models()
    {
        return $this->belongsToMany(Emodel::class, 'emodel_intervals');
    }

		public function years()
    {
        return $this->belongsToMany(Year::class, 'interval_years');
    }
		public function logs_for_equipment($id)
    {
        return $this->hasMany(IntervalLog::class)
				->join('workorders', 'interval_logs.workorder_id', '=', 'workorders.id')
				->where('workorders.equipment_id', '=', $id)
				->select('interval_logs.*');
    }
		public function logs()
    {
        return $this->hasMany(IntervalLog::class)->select('interval_logs.*');
    }
		public function last_service($equipment_id){
				return $this->logs_for_equipment($equipment_id)->orderBy('id', 'desc')->limit(1)->first();
		}
}
