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
        $params = $request->all();
        $user = Auth::user();
        if (empty($user)) {
            dd("Bạn chưa đăng nhập");
        }
        if ((int)($user->level) === 0) {
            dd("Bạn không có quyền xem trang này");
        }
        $date = @$params['date'] ?? Carbon::today()->toDateString();
        $room = Room::all();
        $data = [];
        foreach($room as $item)
        {
            $dataByRoom = $this->getDataByRoomByDate($item->id, $date);
            if ($dataByRoom['count'] != 0) {
                $dataByRoom['roomName'] = $item->room_name; 
                $dataByRoom['idChart'] = 'ct-visits-' . $item->id;
                $dataByRoom['idTemp'] = 'temp-' . $item->id;
                $dataByRoom['idHum'] = 'hum-' . $item->id; 
                $data[] = $dataByRoom;
            }
        }
        // return response()->json($data);
        return view('admin.dashboard.inf_level1',['data' => $data, 'room' => $room,
                    'url' => 'admin/dashboard/inf_level1', 'time' => $date]);
    }

    public function getInfLevel0(Request $request){
        $params = $request->all();
        $user = Auth::user();
        if (empty($user)) {
            dd("Bạn chưa đăng nhập");
        }
        if ((int)($user->level) === 1) {
            dd("Bạn không có quyền xem trang này");
        }

        $date = @$params['date'] ?? Carbon::today()->toDateString();

        if ((int)($user->level) === 0) {
            $roomUserModel = new RoomUser();
            $currentRoom =  $roomUserModel->getRoomByUserId($user->id);
        }
        // $dataRoom = Room:: where('user_id',$userId)->get();
        
        $room = Room::all();
        $data = [];

        $dataByRoom = $this->getDataByRoomByDate($currentRoom, $date);
        if ($dataByRoom['count'] != 0) {
            $myRoom = Room::where('id', $currentRoom)->first(); 
            $dataByRoom['roomName'] = $myRoom->room_name; 
            $dataByRoom['idChart'] = 'ct-visits-' . $currentRoom;
            $dataByRoom['idTemp'] = 'temp-' . $currentRoom;
            $dataByRoom['idHum'] = 'hum-' . $currentRoom; 
            $data[] = $dataByRoom;
        }

        return view('admin.dashboard.inf_level0',['data' => $data, 'room' => $room,
                    'url' => 'admin/dashboard/inf_level0', 'time' => $date]);
        // $listSensorInCurrentRoom = Sensor::where('room_id', $currentRoom)->get();
        // $listSensorId = [];
        // $sensor_shows = [];
        // $total_temp = 0;
        // $total_hum = 0;
        // foreach($listSensorInCurrentRoom as $item) {
        //     $tmp = Sensor_inf::where('sensor_id', $item->id)->latest()->first();
        //     if (empty($tmp)) continue;
        //     $sensor = Sensor::where('id', $tmp['sensor_id'])->first();
        //     $tmp['sensor_name'] = @$sensor['sensor_name'] ?? "";
        //     $sensor_shows[] = $tmp;
        //     $total_hum += @$tmp['hum'] ?? 0;
        //     $total_temp += @$tmp['temp'] ?? 0;

        // }
        // // dd($sensor_shows);
        // // $sensor_show = Sensor_inf::whereIn('sensor_id',$listSensorId)->get();
        // $count = count($sensor_shows);
        // if ($count === 0) {
        //     $total = [
        //         "temp" => 0,
        //         "hum" => 0,
        //     ];
        // } else {
        //     $total = [
        //         "temp" => number_format((float)$total_temp/$count, 2, '.', ''),
        //         "hum" => number_format((float)$total_hum/$count, 2, '.', ''),
        //     ];
        // }
        // $sensor_inf = $this->getDataInfo($listSensorInCurrentRoom);
        // $dataChart = $this->getDataChart($listSensorInCurrentRoom);
        // return view('admin.dashboard.inf_level0',['sensor_inf'=>$sensor_inf,'sensor_show' => $total,'room'=>$room, 'sensor_shows' => $sensor_shows, 'data_chart' => $dataChart]);
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

    public function getDataByRoom($currentRoom)
    {
        $listSensorInCurrentRoom = Sensor::where('room_id', $currentRoom)->get();
        $sensorPopupDetail = [];
        $total_temp = 0;
        $total_hum = 0;
        foreach($listSensorInCurrentRoom as $item) {
            $tmp = Sensor_inf::where('sensor_id', $item->id)->latest()->first();
            if (empty($tmp)) continue;
            $sensor = Sensor::where('id', $tmp['sensor_id'])->first();
            $tmp['sensor_name'] = $sensor['sensor_name'];
            $sensorPopupDetail[] = $tmp;
            $total_hum += @$tmp['hum'] ?? 0;
            $total_temp += @$tmp['temp'] ?? 0;

        }

        $count = count($sensorPopupDetail);
        if ($count === 0) {
            $sensorPopup = [
                "temp" => 0,
                "hum" => 0,
            ];
        } else {
            $sensorPopup = [
                "temp" => number_format((float)$total_temp/$count, 2, '.', ''),
                "hum" => number_format((float)$total_hum/$count, 2, '.', ''),
            ];
        }

        $dataChart = $this->getDataChart($listSensorInCurrentRoom);

        $result = [
            'sensorPopup' => $sensorPopup, 
            'sensorPopupDetail' => $sensorPopupDetail, 
            'data_chart'=> $dataChart,
            'count' => $count
        ];
        return $result;
    }

    public function makeLimitTime($date)
    {
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';
        return [$start, $end];
    }

    public function getDataByRoomByDate($currentRoom, $date)
    {
        $listSensorInCurrentRoom = Sensor::where('room_id', $currentRoom)->get();
        $sensorPopupDetail = [];
        $total_temp = 0;
        $total_hum = 0;
        [$start, $end] = $this->makeLimitTime($date);
        foreach($listSensorInCurrentRoom as $item) {
            $tmp = Sensor_inf::where('sensor_id', $item->id)
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->first();
            if (empty($tmp)) continue;
            $sensor = Sensor::where('id', $tmp['sensor_id'])->first();
            $tmp['sensor_name'] = $sensor['sensor_name'];
            $sensorPopupDetail[] = $tmp;
            $total_hum += @$tmp['hum'] ?? 0;
            $total_temp += @$tmp['temp'] ?? 0;

        }

        $count = count($sensorPopupDetail);
        if ($count === 0) {
            $sensorPopup = [
                "temp" => 0,
                "hum" => 0,
            ];
        } else {
            $sensorPopup = [
                "temp" => number_format((float)$total_temp/$count, 2, '.', ''),
                "hum" => number_format((float)$total_hum/$count, 2, '.', ''),
            ];
        }

        $dataChart = $this->getDataChartByDate($listSensorInCurrentRoom, $date);

        $result = [
            'sensorPopup' => $sensorPopup, 
            'sensorPopupDetail' => $sensorPopupDetail, 
            'data_chart'=> $dataChart,
            'count' => $count
        ];
        return $result;
    }

    public function getDataChartByDate($sensorIds, $date)
    {
        $node = env('DEFAULT_NODE', 10);
        $distance = env('DEFAULT_DISTANCE', 1);
        $sensorIds = Arr::pluck($sensorIds, 'id');
        [$start, $end] = $this->makeLimitTime($date);
        $data = \DB::table('sensor_inf')
                    ->select(DB::raw('created_at, sum(sensor_inf.temp) as sum_temp, sum(sensor_inf.hum) as sum_hum, count(sensor_inf.id) as number_sensor'))
                    ->whereIn('sensor_id', $sensorIds)
                    ->where('created_at', '>=', $start)
                    ->where('created_at', '<=', $end)
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