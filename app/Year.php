<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
  protected $fillable = ['year', 'emodel_id'];

  public function parts()
  {
      return $this->belongsToMany(Part::class);
  }
  public function default_parts()
  {
      return $this->belongsToMany(DefaultPart::class);
  }
  public function emodel()
  {
      return $this->hasMany(Emodel::class);
  }
}
