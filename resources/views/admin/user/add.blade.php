@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User
                            <small>Thêm</small>
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
                        <form action="admin/user/add" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token() }}">
                            <div class="form-group">
                                <label>Họ Tên</label>
                                <input class="form-control" name="fullname" placeholder="Nhập tên người dùng" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Nhập địa chỉ email" />
                            </div>
                            <div class="form-group">
                                <label>SĐT</label>
                                <input type="tel" class="form-control" name="phone_number" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" />
                            </div>
                            <div class="form-group">
                                <label>Nhập lại Password</label>
                                <input type="password" class="form-control" name="passwordAgain" placeholder="Nhập lại mật khẩu" />
                            </div>
                            <div class="form-group">
                                <label>Avatar</label>
                                <input type="file" class="form-control" name="avatar"/>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <select class="form-control" name="room" >
                                    @foreach($room as $r)
                                    <option value="{{$r->id}}">{{$r->room_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quyền người dùng</label>
                                <label class="radio-inline">
                                    <input name="level" value="1" checked="" type="radio">Manager
                                </label>
                                <label class="radio-inline">
                                    <input name="level" value="0" type="radio">Staff
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
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