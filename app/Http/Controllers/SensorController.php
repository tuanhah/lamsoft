<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Sensor;
use App\Sensor_inf;

class SensorController extends Controller
{
    public function getList(){
        $room = Room::all();
        $sensor = Sensor::all();
        return view('admin.sensor.list',['room'=>$room, 'sensor'=>$sensor]);
    }
    public function getAdd(){
        $room = Room::all();
        $sensor = Sensor::all();
        return view('admin.sensor.add',['room'=>$room, 'sensor'=>$sensor]);
    }
    public function postAdd(Request $request){
        $this->validate($request,
            [
                'sensor_name' => 'required|unique:Sensor,sensor_name|min:2|max:100',
                'room'=> 'required'
            ],
            [
                'sensor_name.required'=>'Bạn chưa nhập tên Sensor',
                'sensor_name.unique'=>'Tên Sensor đã tồn tại',
                'sensor_name.min'=>'Tên Sensor phải có độ dài từ 2 đến 100 ký tự',
                'sensor_name.max'=> 'Tên Sensor phải có độ dài từ 2 đến 100 ký tự',
                'sensor.required'=>'Bạn chưa chọn Room'
            ]);
        $sensor = new Sensor;
        $sensor->sensor_name = $request->sensor_name;
        $sensor->room_id = $request->room;
        $sensor->save();
        return redirect('admin/sensor/add')->with('thongbao','Thêm thành công');
    }
    public function getEdit($id){
        $room = Room::all();
        $sensor = Sensor::find($id);
        return view('admin.sensor.edit',['room'=>$room, 'sensor' => $sensor]);
    }
    public function postEdit(Request $request,$id){
        $this->validate($request,
            [
                'sensor_name' => 'required|unique:Sensor,sensor_name|min:2|max:100',
                'room'=> 'required'
            ],
            [
                'sensor_name.required'=>'Bạn chưa nhập tên Sensor',
                'sensor_name.unique'=>'Tên Sensor đã tồn tại',
                'sensor_name.min'=>'Tên Sensor phải có độ dài từ 2 đến 100 ký tự',
                'sensor_name.max'=> 'Tên Sensor phải có độ dài từ 2 đến 100 ký tự',
                'sensor.required'=>'Bạn chưa chọn Room'
            ]);
        $sensor = Sensor::find($id);
        $sensor->sensor_name = $request->sensor_name;
        $sensor->room_id = $request->room;
        $sensor->save();
        return redirect('admin/sensor/edit/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getDelete($id){
        $sensor = Sensor::find($id);
        $sensor->delete();

        return redirect('admin/sensor/list')->with('thongbao','Bạn đã xóa thành công');
    }
}
