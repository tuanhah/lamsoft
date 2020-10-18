<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav slimscrollsidebar">
		<div class="sidebar-head">
			<h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">LAM SOFT</span></h3>
		</div>
		<ul class="nav" id="side-menu">
			@if(Auth::user()->level == 1)
			<li style="padding: 70px 0 0;">
				<a href="admin/dashboard/inf_level1" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
			</li>
			@else
			<li style="padding: 70px 0 0;">
				<a href="admin/dashboard/inf_level0" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
			</li>
			@endif
			<li>
				<a href="admin/profile/inf/{{Auth::User()->id}}" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a>
			</li>


			@foreach($room as $r)
				@if(count($r->sensor) > 0)
				<li>
					<a href="m-humidity.html" class="waves-effect"><i class="fa fa-tint fa-fw" aria-hidden="true"></i>{{$r->room_name}}</a>
					<ul class="nav nav-second-level">
						@foreach($r->sensor as $s)
						<li>
							<a href="sensor/{{$s->id}}">{{$s->sensor_name}}</a>
						</li>
						@endforeach
					</ul>
				</li>
				@endif
			@endforeach

			@if(Auth::user()->level == 1)
				<li>
					<a href="#" class="waves-effect"><i class="fa fa-thermometer-empty fa-fw" aria-hidden="true"></i>Rooms manager</a>
					<ul class="nav nav-second-level">
						<li>
							<a href="admin/room/list">Danh sách</a>
						</li>
						<li>
							<a href="admin/room/add">Thêm</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" class="waves-effect"><i class="fa fa-thermometer-empty fa-fw" aria-hidden="true"></i>Sensors manager</a>
					<ul class="nav nav-second-level">
						<li>
							<a href="admin/sensor/list">Danh sách</a>
						</li>
						<li>
							<a href="admin/sensor/add">Thêm</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" class="waves-effect"><i class="fa fa-thermometer-empty fa-fw" aria-hidden="true"></i>Users manager</a>
					<ul class="nav nav-second-level">
						<li>
							<a href="admin/user/list">Danh sách</a>
						</li>
						<li>
							<a href="admin/user/add">Thêm</a>
						</li>
					</ul>
				</li>
			@endif
		</ul>
		<div class="center p-20">
			<a href="admin/logout" target="_blank" class="btn btn-danger btn-block waves-effect waves-light">Tài khoản</a>
		</div>
	</div>
	
</div>