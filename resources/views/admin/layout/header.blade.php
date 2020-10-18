<nav class="navbar navbar-default navbar-static-top m-b-0">
	<div class="navbar-header">
		<div class="top-left-part">
			<a class="logo">
				<b><img src="admin_asset/plugins/images/admin-logo-dark.png" alt="home" class="light-logo" /></b>
				<span class="hidden-xs"><h4 alt="home" class="light-logo">LAM SOFT</h4></span> 
			</a>
		</div>
		<ul class="nav navbar-top-links navbar-right pull-right">
			<li>
				<form role="search" class="app-search hidden-sm hidden-xs m-r-10">
					<input type="text" placeholder="Search..." class="form-control"> 
					<a href="">
						<i class="fa fa-search"></i>
					</a> 
				</form>
			</li>
			@auth
			<li>
				<a class="profile-pic"> <img src="upload/avatar/{{Auth::User()->avatar}}" alt="user-img" width="36" height="36" class="img-circle"><b class="hidden-xs">{{Auth::User()->fullname}}</b></a>
			</li>
			@endauth
		</ul>
	</div>
</nav>