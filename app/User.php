<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Mail;

class User extends Authenticatable
{
  use Billable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'cell_number', 'cell_provider',
        'PIN', 'login_account_id', 'fuel_group_id', 'company_id', 'send_text_at_fueling',
        'send_email_at_fueling', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
 * Send the password reset notification.
 *
 * @param  string  $token
 * @return void
 */
public function sendPasswordResetNotification($token)
{
  // $email = "gregstewart90@gmail.com"; //"7065701630@vtext.com"
  $email = $this->cell_number . "@vtext.com"; //"7065701630@vtext.com"
  Mail::send(['text' => 'emails.reset'], ['user' => $this, 'token' => $token], function($message) use ($email){
    $message->to($email, $this->first_name);
    $message->from("stewarttec@gmail.com", 'Stewart Tech');
  });
}

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

    public function workorders()
    {
    	return $this->hasMany('App\Workorder');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class)->withPivot('daily', 'weekly');
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
