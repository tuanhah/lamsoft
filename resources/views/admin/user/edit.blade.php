@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User
                            <small>{{$user->fullname}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        @if(count($errors)>0)
                            <div class="alert aert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}
                                @endforeach
                            </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        <form action="admin/user/edit/{{$user->id}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token() }}">
                            <div class="form-group">
                                <label>Họ Tên</label>
                                <input class="form-control" name="fullname" placeholder="Nhập tên người dùng" value="{{$user->fullname}}" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Nhập địa chỉ email" value="{{$user->email}}" readonly="" />
                            </div>
                            <div class="form-group">
                                <label>SĐT</label>
                                <input type="tel" class="form-control" name="phone_number" placeholder="Nhập số điện thoại" value="{{$user->phone_number}}">
                            </div>
                            <div class="form-group">
                            	<input type="checkbox" id="changePassword" name="changePassword">
                                <label>Đổi mật khẩu</label>
                                <input type="password" class="form-control password" name="password" placeholder="Nhập mật khẩu" disabled="" />
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" class="form-control password" name="passwordAgain" placeholder="Nhập lại mật khẩu" disabled="" />
                            </div>
                            <div class="form-group">
                                <label>Avatar</label>
                                <input type="file" class="form-control" name="avatar"/>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <select class="form-control" name="room">
                                    @foreach($room as $r)
                                    <option 
                                    @if($user->room_id == $r->id)
                                    {{"selected"}}
                                    @endif
                                    value="{{$r->id}}">{{$r->room_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quyền người dùng</label>
                                <label class="radio-inline">
                                    <input name="level" value="1" 
                                    @if($user->level==1) 
                                    	{{"checked"}} 
                                    @endif
                                    type="radio">Manager
                                </label>
                                <label class="radio-inline">
                                    <input name="level" value="0"
                                    @if($user->level==0) 
                                    	{{"checked"}} 
                                    @endif
                                    type="radio">Staff
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->
@endsection

@section('script')
	<script>
		$("#changePassword").change(function(){
			if($(this).is(":checked")){
				$(".password").removeAttr('disabled');
			}
			else{
				$(".password").attr('disabled','');
			}
		})
	</script>
@endsection

