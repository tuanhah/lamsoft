<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model
{
    protected $table = "room_user";

    public function getRoomByUserId($uid)
    {
        $room = RoomUser::where('user_id', $uid)->first();
        if ($room && $room->room_id) {
            return $room->room_id;
        }
        return env('DEFAULT_ROOM', 1);
    }
}