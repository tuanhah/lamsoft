@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Danh sách</h4> 
            </div>                    
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                    @endif
                    <h3 class="page-title">THÔNG SỐ GẦN ĐÂY</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Phòng</th>
                                    <th>Tên cảm biến</th>
                                    <th>Xóa</th>
                                    <th>sửa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sensor as $s)
                                <tr class="odd gradeX">
                                    <td>{{$s->id}}</td>
                                    <td>{{$s->room->room_name}}</td>
                                    <td>{{$s->sensor_name}}</td>
                                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/sensor/delete/{{$s->id}}"> Xóa</a></td>
                                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/sensor/edit/{{$s->id}}">Sửa</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection