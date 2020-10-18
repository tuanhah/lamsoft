<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Sensor;
use App\Sensor_inf;

class Sensor_infController extends Controller
{
    public function sensor_page(){
    	$room = Room::all();
    	return view('admin.layout.index',['room'=>$room]);
    }
    public function sensor($id){
    	$room = Room::all();
    	$sensor = Sensor::find($id);
    	$sensor_inf = Sensor_inf::where('sensor_id',$id)->paginate(2);
    	return view('admin.sensor_inf.sensor',['sensor'=>$sensor,'sensor_inf'=>$sensor_inf,'room'=>$room]);
    }
    public function getStaff()
    {
        $sensor = Sensor::all();

        return view('admin.dashboard.inf',['sensor' => $sensor ]);
    }
}
