<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultInterval extends Model
{
  public function parts()
  {
      return $this->belongsToMany(Part::class);
  }
}
