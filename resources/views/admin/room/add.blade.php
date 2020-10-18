@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Phòng
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
                        <form action="admin/room/add" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token() }}">
                            <div class="form-group">
                                <label>Tên phòng</label>
                                <input class="form-control" name="room_name" placeholder="Nhập tên phòng" />
                            </div>
                            <input type="hidden" name="user_id" value="{{Auth::User()->id}}">
                            <div class="form-group">
                                <label>So cam bien</label>
                                <input class="form-control" name="sensor_number" placeholder="Nhập số cảm biến" />
                            </div>
                            
                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection