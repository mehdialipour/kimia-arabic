<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    protected $fillable = ['patient_id','cause'];

    public function patients()
    {
    	return $this->belongsToMany('App\Models\Patient');
    }

    public function turns()
    {
    	return $this->hasMany('App\Models\Turn');
    }

    public function file_receptions()
    {
    	return $this->hasMany('App\Models\FileReception');
    }
}
