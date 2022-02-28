<!DOCTYPE html>
<html lang="en') }}" />
	<head>
		<meta charset="utf-8') }}" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge') }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no') }}" />
		<meta name="description" content="') }}" />
		<meta name="author" content="') }}" />
		
		<!-- Website Title -->
		<title>{{ env('APP_NAME') }} | @yield('title') </title>
			
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

		 <!-- Font Awesome Icons -->
		 <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
		 <!-- IonIcons -->
		 <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		 <!-- Theme style -->
		 <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
		 <!-- Google Font: Source Sans Pro -->
		 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	
		 <!-- DataTables -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	</head>

	<body>
		<div class="wrapper">
			@include('admin.partials.header')

			@include('admin.partials.sidebar')

			@yield('contents')
			
			@include('admin.partials.footer')
		</div>
		

		<!-- jQuery -->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap -->
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE -->
		<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

		<!-- OPTIONAL SCRIPTS -->
		<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
		<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
		<script src="{{ asset('assets/dist/js/pages/dashboard3.js') }}"></script>

		<!-- DataTables -->
		<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
		<!-- page script -->
		<script>
		  $(function () {
			$("#example1").DataTable({
			  "responsive": true,
			  "autoWidth": false,
			});
			$('#example2').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": false,
			  "ordering": true,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
		  });
		</script>

		@yield('script')
	</body>
</html>
