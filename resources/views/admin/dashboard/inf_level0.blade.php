@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Dashboard_name</h4> 
            </div>                    
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="white-box analytics-info">
                    <h3 class="page-title">Nhiệt độ</h3>
                    <ul class="list-inline two-part">
                        <li>
                            <div id="sparklinedash"></div>
                        </li>
                        <li class="text-right" id="temp"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">{{$sensor_show['temp']}}</span><span class="text-success">°C</span></li>
                    </ul>
                </div>
            </div>
            <div id="popup-level-temp">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sensor</th>
                                <th>NHIỆT ĐỘ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sensor_shows as $item)
                            <tr class="odd gradeX">
                                <td>{{$item['sensor_name']}}</td>
                                <td>{{$item['temp']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
             </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="white-box analytics-info">
                    <h3 class="page-title">Độ ẩm</h3>
                    <ul class="list-inline two-part">
                        <li>
                            <div id="sparklinedash2"></div>
                        </li>
                        <li class="text-right" id="hum"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">{{$sensor_show['hum']}}</span><span class="text-purple">%</span></li>
                    </ul>
                </div>
            </div>
            <div id="popup-level-hum">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sensor</th>
                                <th>ĐỘ ẨM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sensor_shows as $item)
                            <tr class="odd gradeX">
                                <td>{{$item['sensor_name']}}</td>
                                <td>{{$item['hum']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
             </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="white-box analytics-info">
                    <h3 class="page-title">Độ ồn</h3>
                    <ul class="list-inline two-part">
                        <li>
                            <div id="sparklinedash3"></div>
                        </li>
                        <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">65</span><span class="text-info">dB</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="page-title">GIÁM SÁT KHÔNG KHÍ THƯ VIỆN THEO THỜI GIAN</h3>
                    <ul class="list-inline text-right">
                        <li>
                            <h5><i class="fa fa-circle m-r-5 text-info"></i>Nhiệt độ</h5> 
                        </li>
                        <li>
                            <h5><i class="fa fa-circle m-r-5 text-inverse"></i>Độ ẩm</h5>
                        </li>
                    </ul>
                    <div id="ct-visits" style="height: 405px;">
                    </div>
                </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer text-center"> Design by Bao Tran </footer>
</div>
<script src="admin_asset/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script>

    let data = <?= json_encode($sensor_inf); ?>;
    console.log(<?= json_encode($sensor_inf); ?>);
    const result = [[], []];
    const labels = [];
    const MAX_CHART_ITEM = 10;
    const chartData = data.data.slice(Math.max(data.data.length - MAX_CHART_ITEM, 0));
    chartData.forEach(item => {
      result[0].push(item.hum)
      result[1].push(item.temp)
      const createAt = new Date(item.created_at)
      // createAt.setHours( createAt.getHours() + 1 );
      labels.push(`${createAt.getHours()}:${createAt.getMinutes()}:${createAt.getSeconds()} ${createAt.getDate()}/${createAt.getMonth()+1}/${createAt.getFullYear()}`)

    })
    $(document).ready(function () {
        "use strict";
        // toat popup js
        $.toast({
            heading: 'Welcome to LAM SOFT',
            text: 'Phần mềm hàng đầu trong việc giám sát không khí trong thư viện',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'warning',
            hideAfter: 3500,
            stack: 6
        })
        //ct-visits
        new Chartist.Line('#ct-visits', {
            labels: labels,
            series: result
            // [
            // [5, 2, 7, 4, 5, 3, 5, 4, 3, 3, 2]
            // , [2, 5, 2, 6, 2, 5, 2, 4, 3, 3, 2]
            // ]
        }, {
            top: 0,
            low: 0,
            showPoint: true,
            fullWidth: true,
            plugins: [
                Chartist.plugins.tooltip()
            ],
            axisY: {
                labelInterpolationFnc: function (value) {
                    return (value / 1);
                }
            },
            showArea: true
        });
        // counter
        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });

        var sparklineLogin = function () {
            $('#sparklinedash').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                type: 'bar',
                height: '30',
                barWidth: '4',
                resize: true,
                barSpacing: '5',
                barColor: '#7ace4c'
            });
            $('#sparklinedash2').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                type: 'bar',
                height: '30',
                barWidth: '4',
                resize: true,
                barSpacing: '5',
                barColor: '#7460ee'
            });
            $('#sparklinedash3').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                type: 'bar',
                height: '30',
                barWidth: '4',
                resize: true,
                barSpacing: '5',
                barColor: '#11a0f8'
            });
            $('#sparklinedash4').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
                type: 'bar',
                height: '30',
                barWidth: '4',
                resize: true,
                barSpacing: '5',
                barColor: '#f33155'
            });
        }
        var sparkResize;
        $(window).on("resize", function (e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 500);
        });
        sparklineLogin();
    });
    $('#temp').hover(function(e) {
        $('#popup-level-temp').show();
    }, function(e) {
        $('#popup-level-temp').hide();
    })
    $('#hum').hover(function(e) {
        $('#popup-level-hum').show();
    }, function(e) {
        $('#popup-level-hum').hide();
    })


</script>
<!-- /#page-wrapper -->
@endsection