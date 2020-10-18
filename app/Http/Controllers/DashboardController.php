<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sensor_inf;
use App\Room;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    public function getInfLevel1(Request $request){
        $userId = Auth::id();
       
        $dataRoom = Room:: where('user_id',$userId)->get();
        dd($dataRoom);
        
    	$room = Room::all();
    	$sensor_show = Sensor_inf::where('sensor_id',1)->latest()->first();
        // dd($sensor_show);
    	// echo "<pre>";
    	// print_r($request->room);
    	// echo "</pre>";
    	// exit;
    	$sensor_inf = Sensor_inf::where('sensor_id',1)->paginate(10);
        // $sensor_inf = Sensor_inf::where('created_at', '>=', Carbon::now()->subDay())->get()->groupBy(function($date) {
        //     return Carbon::parse($date->created_at)->format('h');
        // });
    	return view('admin.dashboard.inf_level1',['sensor_inf'=>$sensor_inf,'sensor_show' => $sensor_show,'room'=>$room]);
    }

    public function getInfLevel0(Request $request){
        $userId = Auth::id();
       
        $dataRoom = Room:: where('user_id',$userId)->get();
        dd($dataRoom);

        $room = Room::all();
        $sensor_show = Sensor_inf::where('sensor_id',1)->latest()->first();
        // dd($sensor_show);
        // echo "<pre>";
        // print_r($request->room);
        // echo "</pre>";
        // exit;
        $sensor_inf = Sensor_inf::where('sensor_id',1)->paginate(10);
        // $sensor_inf = Sensor_inf::where('created_at', '>=', Carbon::now()->subDay())->get()->groupBy(function($date) {
        //     return Carbon::parse($date->created_at)->format('h');
        // });
        return view('admin.dashboard.inf_level0',['sensor_inf'=>$sensor_inf,'sensor_show' => $sensor_show,'room'=>$room]);
    }
}