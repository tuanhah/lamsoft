<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sensor_inf;
use App\Sensor;
use App\Room;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    public function getInfLevel1(Request $request){
        $user = Auth::user();
        if ((int)($user->level) === 0) {
            dd("Level cua ban khong dung");
        }
        $currentRoom = env('DEFAULT_ROOM', 1);
        if ((int)($user->level) === 0) {
            $roomModel = new Room();
            $currentRoom =  $roomModel->getRoomByUserId($user->id);
        }
        
        // $dataRoom = Room:: where('user_id',$userId)->get();
        // dd($dataRoom);
        
        $room = Room::all();
        $listSensorInCurrentRoom = Sensor::where('room_id', $currentRoom)->get();
        $listSensorId = [];
        $sensor_shows = [];
        $total_temp = 0;
        $total_hum = 0;
        foreach($listSensorInCurrentRoom as $item) {
            $tmp = Sensor_inf::where('sensor_id', $item->id)->latest()->first();
            if (empty($tmp)) continue;
            $sensor = Sensor::where('id', $tmp['sensor_id'])->first();
            $tmp['sensor_name'] = $sensor['sensor_name'];
            $sensor_shows[] = $tmp;
            $total_hum += @$tmp['hum'] ?? 0;
            $total_temp += @$tmp['temp'] ?? 0;

        }
        // dd($sensor_shows);
        // $sensor_show = Sensor_inf::whereIn('sensor_id',$listSensorId)->get();
        $count = count($sensor_shows);
        if ($count === 0) {
            $total = [
                "temp" => 0,
                "hum" => 0,
            ];
        } else {
            $total = [
                "temp" => number_format((float)$total_temp/$count, 2, '.', ''),
                "hum" => number_format((float)$total_hum/$count, 2, '.', ''),
            ];
        }
        // dd($sensor_show);
    	// echo "<pre>";
    	// print_r($request->room);
    	// echo "</pre>";
        // exit;
    	$sensor_inf = Sensor_inf::where('sensor_id',1)->paginate(10);
        // $sensor_inf = Sensor_inf::where('created_at', '>=', Carbon::now()->subDay())->get()->groupBy(function($date) {
        //     return Carbon::parse($date->created_at)->format('h');
        // });
    	return view('admin.dashboard.inf_level1',['sensor_inf'=>$sensor_inf,'sensor_show' => $total,'room'=>$room, 'sensor_shows' => $sensor_shows]);
    }

    public function getInfLevel0(Request $request){
        $user = Auth::user();
        if ((int)($user->level) === 1) {
            dd("Level cua ban khong dung");
        }
        $currentRoom = env('DEFAULT_ROOM', 1);
        if ((int)($user->level) === 0) {
            $roomModel = new Room();
            $currentRoom =  $roomModel->getRoomByUserId($user->id);
        }
        
        // $dataRoom = Room:: where('user_id',$userId)->get();
        // dd($dataRoom);
        
        $room = Room::all();
        $listSensorInCurrentRoom = Sensor::where('room_id', $currentRoom)->get();
        $listSensorId = [];
        $sensor_shows = [];
        $total_temp = 0;
        $total_hum = 0;
        foreach($listSensorInCurrentRoom as $item) {
            $tmp = Sensor_inf::where('sensor_id', $item->id)->latest()->first();
            if (empty($tmp)) continue;
            $sensor = Sensor::where('id', $tmp['sensor_id'])->first();
            $tmp['sensor_name'] = @$sensor['sensor_name'] ?? "";
            $sensor_shows[] = $tmp;
            $total_hum += @$tmp['hum'] ?? 0;
            $total_temp += @$tmp['temp'] ?? 0;

        }
        // dd($sensor_shows);
        // $sensor_show = Sensor_inf::whereIn('sensor_id',$listSensorId)->get();
        $count = count($sensor_shows);
        if ($count === 0) {
            $total = [
                "temp" => 0,
                "hum" => 0,
            ];
        } else {
            $total = [
                "temp" => number_format((float)$total_temp/$count, 2, '.', ''),
                "hum" => number_format((float)$total_hum/$count, 2, '.', ''),
            ];
        }
        $sensor_inf = Sensor_inf::where('sensor_id',1)->paginate(10);
        return view('admin.dashboard.inf_level0',['sensor_inf'=>$sensor_inf,'sensor_show' => $total,'room'=>$room, 'sensor_shows' => $sensor_shows]);
    }
}