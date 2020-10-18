<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="100">
    <link rel="icon" type="image/png" sizes="16x16" href="admin_asset/plugins/images/admin-logo-dark.png">
    <title>LAM SOFT</title>
    <base href="{{asset('')}}">
    <!-- Bootstrap Core CSS -->
    <link href="admin_asset/html/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Menu CSS -->
    <link href="admin_asset/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="admin_asset/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="admin_asset/plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="admin_asset/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="admin_asset/html/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="admin_asset/html/css/colors/default.css" id="theme" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
</head>

<body class="fix-header">   
    <div id="wrapper">
        @include('admin.layout.header')

        @include('admin.layout.menu')

        @yield('content')
    </div>

    <script src="admin_asset/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="admin_asset/html/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="admin_asset/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="admin_asset/html/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="admin_asset/html/js/waves.js"></script>
    <!--Counter js -->
    <script src="admin_asset/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="admin_asset/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!-- chartist chart -->
    <script src="admin_asset/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="admin_asset/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="admin_asset/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="admin_asset/html/js/custom.min.js"></script>
<!--     <script src="admin_asset/html/js/dashboard1.js"></script>
 --> 

    <script src="admin_asset/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    @yield('script')
</body>

</html>
