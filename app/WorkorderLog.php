<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkorderLog extends Model
{

  protected $fillable = [
     'notes',
     'status',
     'workorder_id',
     'user_id'
  ];
  public function workorder()
  {
    return $this->belongsTo('App\Workorder');
  }
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
