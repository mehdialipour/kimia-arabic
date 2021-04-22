<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $guarded = [];

    public function services()
    {
    	return $this->belongsToMany('App\Models\Service');
    }
}
