<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkorderPhoto extends Model
{

  protected $fillable = [
     'workorder_id',
     'file_path',
     'name'
  ];
  public function workorder()
  {
    return $this->belongsTo('App\Workorder');
  }
}
