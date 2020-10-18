@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
	<div class="container-fluid">
		<form action="admin/profile/inf/{{Auth::User()->id}}" method="POST" enctype="multipart/form-data">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title">Profile</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-xs-12">
				<div class="white-box">
					<div class="user-bg">
						<div class="overlay-box">
							<div class="user-content">
									<input type="hidden" name="_token" value="{{csrf_token() }}">
									<a href="javascript:void(0)">
										<img src="upload/avatar/{{Auth::User()->avatar}}" class="thumb-lg img-circle" alt="img"/>

										<h4 class="text-white">{{Auth::User()->fullname}}</h4>
										<h5 class="text-white">{{Auth::User()->email}}</h5>
								</div>
							</div>
						</div>
						<div class="user-btm-box">
							<input type="file" name="avatar" class="form-control" value="{{Auth::User()->avatar}}"/>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-xs-12">
					<div class="white-box">
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
							<input type="hidden" name="_token" value="{{csrf_token() }}">
							<div class="form-group">
								<label>Full Name</label>
								<input class="form-control" name="fullname" placeholder="Nhập tên người dùng" value="{{$user->fullname}}" />
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="email" placeholder="Nhập địa chỉ email" value="{{$user->email}}" readonly="" />
							</div>
							<div class="form-group">
								<label>Phone Number</label>
								<input type="tel" class="form-control" name="phone_number" placeholder="Nhập số điện thoại" value="{{$user->phone_number}}"  />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<button class="btn btn-success">Update Profile</button>
							</div>
						</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	<footer class="footer text-center"> Design by Bao Tran </footer>
</div>
@endsection