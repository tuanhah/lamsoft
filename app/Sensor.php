<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = "sensor";

    public function room(){
    	return $this->belongsTo('App\Room','room_id','id');
    }

    public function sensor_inf(){
    	return $this->hasMany('App\Sensor_inf','sendor_id','id');
    }
}
