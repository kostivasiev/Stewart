<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use Billable;

  protected $fillable = [
		'name', 'email', 'address', 'phone', 'address', 'trial_ends_at'
	];
  protected $dates = [
        'created_at',
        'updated_at',
        'trial_ends_at'
    ];

  public function users()
  {
      return $this->hasMany('App\User');
  }
  public function equipment()
  {
      return $this->hasMany('App\Equipment');
  }
  public function assigned_equipment()
  {
      return $this->hasMany('App\Equipment')->join('equipment_user', 'equipment_user.equipment_id', '=', 'equipment.id')->select("equipment.*")->groupBy('equipment.id');
  }
  public function assigned_equipment_users()
  {
      return $this->hasMany('App\Equipment')
      ->join('equipment_user', 'equipment_user.equipment_id', '=', 'equipment.id')
      ->join('users', 'equipment_user.user_id', '=', 'users.id')
      ->select("users.*")->groupBy('users.id');
  }
  public function intervals()
  {
      return $this->hasMany('App\Interval');
  }
  public function calculated_intervals()
  {
    $okay     = 0;
    $upcoming = 0;
    $current  = 0;
    $overdue  = 0;
    foreach($this->equipment()->get() as $equipment){
      $equipment->get_and_caluculate_intervals();
      $okay     += $equipment->okay;
      $upcoming += $equipment->upcoming;
      $current  += $equipment->current;
      $overdue  += $equipment->overdue;
    }
    return ['okay'=>$okay, 'upcoming'=>$upcoming, 'current'=>$current, 'overdue'=>$overdue];
  }
  public function tags()
  {
      return $this->hasMany('App\Tag');
  }
  public function variables()
  {
      return $this->hasMany('App\Variable');
  }
  public function parts()
  {
      return $this->hasMany('App\Part');
  }

  public function stations()
  {
      return $this->hasMany('App\FuelStation');
  }

  public function equipment_types()
  {
      return $this->hasMany('App\EquipmentType', 'company_id', 'id');
  }

  public function fuel_groups()
  {
      return $this->hasMany('App\FuelGroup');
  }

  public function workorders()
  {
      return $this->hasMany('App\Workorder');
  }
  public function rights()
  {
    return $this->belongsToMany('App\Right');
  }

  public function mechanics()
  {
    return $this->users()->whereHas(
      'roles', function($q){
                $q->where('name', 'Mechanic');
            }
        );
  }

  public function hasAnyRight($roles)
  {
    if (is_array($roles)){
      foreach ($roles as $role){
        if($this->hasRight($role)){
          return true;
        }
      }
    }else{
      if($this->hasRight($roles)){
        return true;
      }
    }
  return false;
  }

  public function hasRight($role)
  {
    if ($this->rights()->where('name', $role)->first()){
      return true;
    }
    return false;
  }
}
