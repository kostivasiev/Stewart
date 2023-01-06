<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'cell_number', 'cell_provider',
        'PIN', 'login_account_id', 'fuel_group_id', 'company_id', 'send_text_at_fueling',
        'send_email_at_fueling'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fuel_group()
    {
    	return $this->belongsTo('App\FuelGroup');
    }
    public function login_account()
    {
    	return $this->belongsTo('App\LoginAccount');
    }

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function roles()
    {
      return $this->belongsToMany('App\Role');
    }

    public function hasAnyRole($roles)
    {
      if (is_array($roles)){
        foreach ($roles as $role){
          if($this->hasRole($role)){
            return true;
          }
        }
      }else{
        if($this->hasRole($roles)){
          return true;
        }
      }
    return false;
    }

    public function hasRole($role)
    {
      if ($this->roles()->where('name', $role)->first()){
        return true;
      }
      return false;
    }
}
