<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;
use Auth;
use Hash;
use App\Sensor;
use App\Sensor_inf;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserController extends Controller
{
    public function getList(){

        $room = Room::all();
    	$user = User::all();
    	return view('admin.user.list',['user'=>$user,'room'=>$room]);
    }
    public function getAdd(){
        $room = Room::all();
        $user = User::all();
    	return view('admin.user.add',['room'=>$room]);
    }
    public function postAdd(Request $request){
    	$this->validate($request,[
    		'fullname'=>'required|min:3',
    		'email'=>'required|email|unique:users,email',
            'phone_number'=>'required|numeric',
    		'password'=>'required|min:3|max:32',
    		'passwordAgain'=>'required|same:password'
    	],
    	[
    		'fullname.required'=>'Bạn chưa nhập tên người dùng',
    		'fullname.min'=>'Tên người dùng phải có ít nhất 3 ký tự',
    		'email.required'=>'Bạn chưa nhập tên người dùng',
    		'email.unique'=>'Email đã tồn tại',
            'phone_number.required'=>'Bạn chưa nhập số điện thoại',
            'phone_number.unique'=>'Sdt đã tồn tại',
    		'password.required'=>'Bạn chưa nhập maatk khẩu',
    		'password.min'=>'Mật khẩu phải có ít nhất 3 ký tự',
    		'password.max'=>'Mật khẩu chỉ được tối đa 32 ký tự',
    		'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
    		'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp'
    	]
    );
    	$user = new User;
    	$user->fullname=$request->fullname;
    	$user->email=$request->email;
        $user->phone_number=$request->phone_number;
    	// $user->pass=bcrypt($request->pass);
        $user->password=Hash::make($request->password);
        if($request->hasFile('avatar')){
            $fileName = $request->avatar->getClientOriginalName();
            $folderPath = "upload/avatar"; 
            
            $request->avatar->move($folderPath, $fileName);
            $user->avatar = $fileName;
        }
        $user->room_id=$request->room;
    	$user->level=$request->level;
    	$user->save();

    	return redirect('admin/user/add')->with('thongbao','Thêm thành công');
    }
    public function getEdit($id){
        $room = Room::all();
    	$user = User::find($id);
        return view('admin.user.edit',['user'=>$user,'room'=>$room]);
    }
    public function postEdit(Request $request,$id){
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
        $user->level=$request->level;

        if ($request->changePassword == "on") {
            $this->validate($request,[
            'password'=>'required|min:3|max:32',
            'passwordAgain'=>'required|same:password'
        ],
        [
            'password.required'=>'Bạn chưa nhập maatk khẩu',
            'password.min'=>'Mật khẩu phải có ít nhất 3 ký tự',
            'password.max'=>'Mật khẩu chỉ được tối đa 32 ký tự',
            'passwordAgain.required'=>'Bạn chưa nhập lại mật khẩu',
            'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp'
        ]
        );
            $user->password = bcrypt($request->password);
        }
        if($request->hasFile('avatar')){
            $fileName = $request->avatar->getClientOriginalName();
            $folderPath = "upload/avatar"; 
            
            $request->avatar->move($folderPath, $fileName);
            $user->avatar = $fileName;
        }
        $user->room_id=$request->room;

        $user->save();

        return redirect('admin/user/edit/'.$id)->with('thongbao','Sửa thành công');
    }
    public function getDelete($id){
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user/list')->with('thongbao','Xóa người dùng thành công');
    }

    public function getLoginAdmin(){
        return view('admin.login');
    }
    public function postLoginAdmin(Request $request){
        $email = $request->email;
        $password = $request->password;
        $data['room']= Room::all(); //query room_id
        $data['sensor_show']= Sensor_inf::where('sensor_id',1)->latest()->first();
        $data['sensor_inf']= Sensor_inf::where('sensor_id',1)->paginate(10);
        if(Auth::attempt(['email'=>$email, 'password' => $password])){
            // return view("admin.dashboard.inf_level1",$data);
            $page = @Auth::user()->level ?? 1;
            return redirect("/admin/dashboard/inf_level{$page}");

        }else{
            return redirect()->back()->with('thongbao','Email hoặc mật khẩu không đúng');
        }   
    }
    public function getDangxuatAdmin()
     {
        Auth::logout();
        return redirect('admin/login');
     }
}
