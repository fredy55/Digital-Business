<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">
	  <meta name="csrf-token" content="{{ csrf_token() }}">

	  <!-- Website Title -->
		<title>{{ env('APP_NAME') }} | @yield('title') </title>
			
	  <!-- Favicon -->
	  <link rel="shortcut icon" href="{{ asset('myadmin/admin_img/favicon.png') }}" />

	  <!-- Custom fonts for this template-->
	  <link href="{{ asset('myadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

	  <!-- Page level plugin CSS-->
	  <link href="{{ asset('myadmin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
	 
	  <!-- Custom styles for this template-->
	  <link href="{{ asset('myadmin/css/sb-admin.css') }}" rel="stylesheet">
	  
	</head>

	<body id="page-top">
      
	<!--======== Header Start =========-->
	  @include('admin.partials.header')
    <!--======== Header End ===========-->
	  
	<div id="wrapper">
      
		<!--======== Sidebar Start =========-->
		@include('admin.partials.sidebar')
		<!--======== Sidebar End ===========-->
		
		  
		<div id="content-wrapper">
			@yield('contents')
	
			<!--========Footer Start =========-->
			@include('admin.partials.footer')
			<!--========Footer End ===========-->
		</div>
		<!-- /.content-wrapper -->
	</div>
	<!-- /#wrapper -->
  
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
	</a>

	 <!-- Bootstrap core JavaScript-->
	  <script src="{{ asset('myadmin/vendor/jquery/jquery.min.js') }}"></script>
	  <script src="{{ asset('myadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

	  <!-- Core plugin JavaScript-->
	  <script src="{{ asset('myadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

	  <!-- Page level plugin JavaScript-->
	  <script src="{{ asset('myadmin/vendor/datatables/jquery.dataTables.js') }}"></script>
	  {{-- <script src="{{ asset('myadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script> --}}
	  <script src="{{ asset('myadmin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
	  <script src="{{ asset('myadmin/vendor/datatables/datatables-demo.js') }}"></script>
	  
	  <!-- Custom scripts for all pages-->
	  <script src="{{ asset('myadmin/js/sb-admin.min.js') }}"></script>

	  <!-- Demo scripts for this page-->
	  <script src="{{ asset('myadmin/js/demo/datatables-demo.js') }}"></script>

	    <!-- Demo scripts for this page-->
	    <script src="{{ asset('myadmin/ckeditor/ckeditor.js') }}"></script>
		
		<script type="text/javascript">
			$(document).ready(function () {
				$('.ckeditor').ckeditor();
			});
		</script>

		@yield('scripts')
	  
	</body>
</html>
