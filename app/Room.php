<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = "room";

    public function sensor(){
    	return $this->hasMany('App\Sensor','room_id','id');
    }

    public function sensor_inf(){
    	return $this->hasManyThrough('App\Sensor_inf','App\Sensor','room_id','sensor_id','id');
    }

    public function getRoomByUserId($uid)
    {
        $room = Room::where('user_id', $uid)->first();
        if ($room && $room->id) {
            return $room->id;
        }
        return env('DEFAULT_ROOM', 1);
    }
}