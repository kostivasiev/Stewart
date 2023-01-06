<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWorkorder extends Model
{
  protected $table = 'user_workorder';
  protected $fillable = [
     'workorder_id',
     'user_id',
     'labor'
  ];
}
