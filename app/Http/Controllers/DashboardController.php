<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sensor_inf;
use App\Sensor;
use App\Room;
use App\RoomUser;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Arr;
use Auth;

class DashboardController extends Controller
{
    public function getInfLevel1(Request $request){
        $user = Auth::user();
        if (empty($user)) {
            dd("Ban chua dang nhap");
        }
        if ((int)($user->level) === 0) {
            dd("Level cua ban khong dung");
        }
        $currentRoom = env('DEFAULT_ROOM', 1);
        if ((int)($user->level) === 0) {
            $roomUserModel = new RoomUser();
            $currentRoom =  $roomUserModel->getRoomByUserId($user->id);
        }
        
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
        $sensor_inf = $this->getDataInfo($listSensorInCurrentRoom);
        $dataChart = $this->getDataChart($listSensorInCurrentRoom);
        // $sensor_inf = Sensor_inf::where('created_at', '>=', Carbon::now()->subDay())->get()->groupBy(function($date) {
        //     return Carbon::parse($date->created_at)->format('h');
        // });
        return view('admin.dashboard.inf_level1',['sensor_inf'=>$sensor_inf,
        'sensor_show' => $total,'room'=>$room, 'sensor_shows' => $sensor_shows, 'data_chart'=> $dataChart]);
    }

    public function getInfLevel0(Request $request){
        $user = Auth::user();
        if (empty($user)) {
            dd("Ban chua dang nhap");
        }
        if ((int)($user->level) === 1) {
            dd("Level cua ban khong dung");
        }
        $currentRoom = env('DEFAULT_ROOM', 1);
        if ((int)($user->level) === 0) {
            $roomUserModel = new RoomUser();
            $currentRoom =  $roomUserModel->getRoomByUserId($user->id);
        }
        
        // $dataRoom = Room:: where('user_id',$userId)->get();
        
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
        $sensor_inf = $this->getDataInfo($listSensorInCurrentRoom);
        $dataChart = $this->getDataChart($listSensorInCurrentRoom);
        return view('admin.dashboard.inf_level0',['sensor_inf'=>$sensor_inf,'sensor_show' => $total,'room'=>$room, 'sensor_shows' => $sensor_shows, 'data_chart' => $dataChart]);
    }

    public function getDataInfo($sensorIds)
    {
        $sensorIds = Arr::pluck($sensorIds, 'id');
        return Sensor_inf::whereIn('sensor_id',$sensorIds)
                           ->orderByDesc('created_at')
                           ->limit(10)
                           ->get();
    }

    public function getDataChart($sensorIds)
    {
        $node = env('DEFAULT_NODE', 10);
        $distance = env('DEFAULT_DISTANCE', 1);
        $sensorIds = Arr::pluck($sensorIds, 'id');
        // $sensorIds = [1,2,3,4,5];    
        $data = \DB::table('sensor_inf')
                    ->select(DB::raw('created_at, sum(sensor_inf.temp) as sum_temp, sum(sensor_inf.hum) as sum_hum, count(sensor_inf.id) as number_sensor'))
                    ->whereIn('sensor_id', $sensorIds)
                    ->groupBy('sensor_inf.created_at')
                    ->limit($node * $distance)
                    ->orderByDesc('created_at')
                    ->get();

        $rs = [];
        foreach($data as $key=> &$item) {
            if ($key % $distance === 0) {
                if ((int)($item->number_sensor) === 0) {
                    $item->temp = 0;
                    $item->hum = 0;
                } else {
                    $item->temp = number_format((float)($item->sum_temp/$item->number_sensor), 2, '.', '');
                    $item->hum = number_format((float)($item->sum_hum/$item->number_sensor), 2, '.', '');
                }
                $rs[] = $item;
            }
        }
        if (count($rs) < 2) {
            array_unshift($rs, [
                'created_at' => "2020-01-01 00:00:00",
                'temp' => 0,
                'hum' => 0
            ]);
        }
        return array_reverse($rs);
        
    }
}