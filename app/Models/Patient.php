<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = [];

    public function receptions()
    {
    	return $this->belongsToMany('App\Models\Reception');
    }
}
