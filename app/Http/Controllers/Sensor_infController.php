<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Sensor;
use App\Sensor_inf;
use Carbon\Carbon;

class Sensor_infController extends Controller
{
    public function sensor_page(){
    	$room = Room::all();
    	return view('admin.layout.index',['room'=>$room]);
    }
    public function sensor($id, Request $request){

        $params =  $request->all();
        $limit = @$params['limit'] ?? 10;
        $page = @$params['page'] ?? 1;
    	$room = Room::all();
        $sensor = Sensor::find($id);
        $date = @$params['date'] ?? Carbon::today()->toDateString();
        [$start, $end] = $this->makeLimitTime($date);
        $sensor_inf = Sensor_inf::where('sensor_id',$id)
        ->where('created_at', '>=', $start)
        ->where('created_at', '<=', $end)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $sensor_inf_count = Sensor_inf::where('sensor_id',$id)
        ->where('created_at', '>=', $start)
        ->where('created_at', '<=', $end)
        ->where('hum', '>=', 65)
        ->count();
        
        return view('admin.sensor_inf.sensor',
        ['sensor'=>$sensor,'sensor_inf'=>$sensor_inf,'room'=>$room, 
        'url' => "sensor/{$id}", 'time' => $date, 'alert'=> $sensor_inf_count]);
    }
    public function getStaff()
    {
        $sensor = Sensor::all();

        return view('admin.dashboard.inf',['sensor' => $sensor ]);
    }

    public function makeLimitTime($date)
    {
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';
        return [$start, $end];
    }
}
