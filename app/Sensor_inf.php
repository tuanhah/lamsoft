<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor_inf extends Model
{
    protected $table = "sensor_inf";

    public function sensor(){
    	return $this->belongsTo('App\Sensor','sensor_id','id');
    }
}
