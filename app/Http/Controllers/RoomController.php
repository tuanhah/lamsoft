<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Sensor;

class RoomController extends Controller
{
    public function getList(){
    	$room = Room::all();
    	return view('admin.room.list',['room'=>$room]);
    }
    public function getAdd(){
        $room = Room::all();
    	return view('admin.room.add',['room'=>$room]);
    }
    public function postAdd(Request $request){
    	$this->validate($request,
    		[
    			'room_name' => 'required|min:2|max:100'
    		],
    		[
    			'room_name.required'=>'Bạn chưa nhập tên phòng',
    			'room_name.min'=>'Tên phòng phải có độ dài từ 2 đến 100 ký tự',
    			'room_name.max'=> 'Tên phòng phải có độ dài từ 2 đến 100 ký tự',
    		]);
    	$room = new Room;
    	$room->room_name=$request->room_name;
    	$room->save();

    	return redirect('admin/room/add')->with('thongbao','Thêm thành công');
    }
    public function getEdit($id){
    	$room = Room::all();
        $room_id = Room::find($id);
        return view('admin.room.edit',['room'=>$room, 'room_id' => $room_id]);
    }
    public function postEdit(Request $request,$id){
        $room = Room::find($id);
        $this->validate($request,
            [
                'room_name' => 'required|unique:Room,room_name|min:2|max:100',
            ],
            [
                'room_name.required'=>'Bạn chưa nhập tên phòng',
                'room_name.unique'=>'Tên thể loại đã tồn tại',
                'room_name.min'=>'Tên phòng phải có độ dài từ 2 đến 100 ký tự',
                'room_name.min'=> 'Tên phòng phải có độ dài từ 2 đến 100 ký tự',
            ]);
        $room->room_name = $request->room_name;
        $room->sensor_number = $request->sensor_number;
        $room->save();
        return redirect('admin/room/edit/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getDelete($id){
        $room = Room::find($id);
        $room->delete();

        return redirect('admin/room/list')->with('thongbao','Bạn đã xóa thành công');
    }
}
