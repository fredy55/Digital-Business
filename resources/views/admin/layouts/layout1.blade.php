<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8') }}" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge') }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no') }}" />
		<meta name="description" content="') }}" />
		<meta name="author" content="') }}" />
		
		<!-- Website Title -->
		<title>{{ env('APP_NAME') }} | @yield('title') </title>
			
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/dist/img/favicon.png') }}" type="image/x-icon" />

		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- icheck bootstrap -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

		<!-- Custom style -->
		<link rel="stylesheet" href="{{ asset('assets/dist/css/style.css') }}">

		<!-- Google Font: Source Sans Pro -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		
		<!-- Google Font: Source Sans Pro -->
		<link href="{{ asset('assets/dist/css/style.css') }}" rel="stylesheet" />
	</head>

	<body class="hold-transition login-page" style="background-color:#202325;">
		
		@yield('contents')
		<!-- /.login-box -->

		<!-- jQuery -->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
	</body>
</html>
