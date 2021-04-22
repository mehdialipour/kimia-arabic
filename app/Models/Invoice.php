<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function turn()
    {
    	return $this->belongsTo('App\Models\Turn');
    }
}
