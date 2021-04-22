<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    protected $guarded = [];

    public function reception()
    {
    	return $this->belongsTo('App\Models\Reception');
    }

    public function services()
    {
    	return $this->belongsToMany('App\Models\Service');
    }

    public function invoice()
    {
    	return $this->hasOne('App\Models\Invoice');
    }
}
