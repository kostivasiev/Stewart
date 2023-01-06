<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
  public function values()
  {
      return $this->hasMany('App\VariableValue');
  }
}
