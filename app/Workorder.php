<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
  protected $fillable = [
     'equipment_id', 'status', 'company_id', 'user_id', 'due_date'
  ];
  public function equipment()
  {
    return $this->belongsTo('App\Equipment');
  }
  public function user()
  {
    return $this->belongsTo('App\User');
  }
  public function wologs()
  {
      return $this->hasMany(WorkorderLog::class);
  }
  public function intervallogs()
  {
      return $this->hasMany(IntervalLog::class);
  }
  public function labor()
  {
      return $this->belongsToMany(User::class)->withPivot('labor');;
  }
  public function tags()
  {
      return $this->belongsToMany(Tag::class);
  }
  public function photos()
  {
      return $this->hasMany(WorkorderPhoto::class);
  }
}
