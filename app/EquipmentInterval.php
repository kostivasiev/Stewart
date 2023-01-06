<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipmentInterval extends Model
{
    protected $fillable = ['interval_id', 'equipment_id', 'meter_due', 'date_due'];
}
