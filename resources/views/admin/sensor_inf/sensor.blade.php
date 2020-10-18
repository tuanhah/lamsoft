@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{$sensor->sensor_name}}</h4>
            </div>                    
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <h3 class="page-title">THÔNG SỐ GẦN ĐÂY</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>THỜI GIAN</th>
                                    <th>NHIỆT ĐỘ</th>
                                    <th>ĐỘ ẨM</th>
                                    <th>ĐỘ ỒN</th>
                                    <th>CẢNH BÁO</th>
                                    <th>XỬ LÝ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sensor_inf as $s)
                                <tr class="odd gradeX">
                                    <td>{{$s->id}}</td>
                                    <td>{{$s->created_at}}</td>
                                    <td>{{$s->temp}}°C </td>
                                    <td>{{$s->hum}}%</td>
                                    <td>50DB</td>
                                    <td>@if($s->hum>=65)
                                        <span class="text-warning">Độ ẩm >= 65%</span>
                                        @else
                                        None
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->hum>=65)
                                        <span class="text-success">Bật quạt thông gió</span>
                                        @else
                                        None
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{$sensor_inf->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection