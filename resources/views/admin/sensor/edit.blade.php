@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"> Cảm biến
					<small>{{$sensor->sensor_name}}</small>
				</h1>
			</div>
			<!-- /.col-lg-12 -->
			<div class="col-lg-7" style="padding-bottom:120px">
				@if(count($errors) > 0)
					<div class="alert alert-danger">
						@foreach($errors->all() as $err)
							{{$err}}<br>
						@endforeach
					</div>
				@endif

				@if(session('thongbao'))
					<div class="alert alert-success">
						{{session('thongbao')}}
					</div>
				@endif
				<form action="admin/sensor/edit/{{$sensor->id}}" method="POST">
					<input type="hidden" name="_token" value="{{csrf_token() }}">
					<div class="form-group">
						<label>Room</label>
						<select class="form-control" name="room">
							@foreach($room as $r)
							<option 
							@if($sensor->room_id == $r->id)
								{{"selected"}}
							@endif
							value="{{$r->id}}">{{$r->room_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Tên cảm biến</label>
						<input class="form-control" name="sensor_name" placeholder="Nhập tên cảm biến" />
					</div>
					<button type="submit" class="btn btn-default" value="{{$sensor->sensor_name}}">Sửa</button>
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