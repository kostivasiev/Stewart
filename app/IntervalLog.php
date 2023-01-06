<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntervalLog extends Model
{
    protected $fillable = [
      'meter_id',
      'interval_id',
      'user_id',
      'workorder_id'
    ];
    public function user()
    {
      return $this->belongsTo('App\User');
    }
    public function interval()
    {
      return $this->belongsTo('App\Interval');
    }
}
