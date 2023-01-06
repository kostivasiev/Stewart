<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeterLog extends Model
{
      protected $fillable = ['current', 'equipment_id', 'user_id'];

      public function user()
      {
          return $this->belongsTo(User::class);
      }
}
