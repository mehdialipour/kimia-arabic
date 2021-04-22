<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileReception extends Model
{
    protected $guarded = [];

    public function reception()
    {
    	return $this->belongsTo('App\Models\Reception');
    }
}
