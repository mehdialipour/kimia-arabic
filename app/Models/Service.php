<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    public function insurances()
    {
    	return $this->belongsToMany('App\Models\Insurance');
    }

    public function turns()
    {
    	return $this->belongsToMany('App\Models\Turn');
    }
}
