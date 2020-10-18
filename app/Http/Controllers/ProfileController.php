<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;

class ProfileController extends Controller
{
    public function getInf($id)
    {
    	$user = User::find($id);
    	$room = Room::all();
    	// $profile = User::find($id);
    	return view('admin.profile.inf',['user'=>$user,'room'=>$room]);
    }

    public function postInf(Request $request,$id){
        $this->validate($request,[
            'fullname'=>'required|min:3',
            'phone_number'=>'required|numeric',
        ],
        [
            'fullname.required'=>'Bạn chưa nhập tên người dùng',
            'fullname.min'=>'Tên người dùng phải có ít nhất 3 ký tự',
            'phone_number.required'=>'Bạn chưa nhập số điện thoại',
            'phone_number.unique'=>'Sdt đã tồn tại',
        ]
    );
        $user = User::find($id);
        $user->fullname=$request->fullname;
        $user->phone_number=$request->phone_number;
        if($request->hasFile('avatar')){
            $fileName = $request->avatar->getClientOriginalName();
            $folderPath = "upload/avatar"; 
            
            $request->avatar->move($folderPath, $fileName);
            $user->avatar = $fileName;
        }
    	$user->save();
    	return redirect('admin/profile/inf/'.$id)->with('thongbao','Sửa thành công');
    }

}