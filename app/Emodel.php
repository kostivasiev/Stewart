<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emodel extends Model
{
    protected $fillable = ['name', 'make_id', 'year'];

    public function make()
    {
    	return $this->belongsTo(Make::class);
    }
    
    public function years()
    {
        return $this->hasMany('App\Year','emodel_id','id');
    }
}
