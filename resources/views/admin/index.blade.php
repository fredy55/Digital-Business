@extends('admin.layouts.layout1')

@section('title', 'Admin login')

@section('contents')
	<div class="container">
		<div class="card card-login mx-auto mt-5">
			<div class="card-header">
				<div class="row" style="margin:0px auto;text-align:center;">
					<div class="col-xs-12 col-md-12">
						<div>
							<img src="{{ asset('assets/images/logo_dark.png') }}" title="Company Logo" alt="Company Logo" />
						</div>
					</div>
				</div>
				<div class="row  mt-4" style="margin:0px auto;text-align:center;">
					<div class="col-xs-12 col-md-12">
						<h4 class="login-title">Admin Login</h4>
					</div>
				</div>
			</div>
			
			<div class="card-body">
				@include('inc.flashmsg')
				<form method="post" action="{{ route('login') }}">
					@csrf

					<div class="form-group">
						<div class="form-label-group">
						<input type="email" name="mail_admin" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
						<label for="inputEmail">Email address</label>
						</div>
					</div>
					<div class="form-group">
						<div class="form-label-group">
						<input type="password" name="pass_admin" id="inputPassword" class="form-control" placeholder="Password" required="required">
						<label for="inputPassword">Password</label>
						</div>
					</div>
					
					<div class="form-group">
						<div class="text-l">
						<a class="d-block small" href="">Forgot Password?</a>
						</div>
					</div>
					
					<div class="form-group">
						<div class="checkbox">
						<label>
							<input type="checkbox" value="remember-me">
							Keep me signed-in
						</label>
						</div>
					</div>
					
					<div class="form-group login-btn">
						<input type="submit" value="Login" class="btn btn-primary btn-block" />
					</div>
				</form>
				
				<!-- Footer -->
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
						<a class="d-block small mt-3">
							&copy; Copyright 
							@php
								echo date('Y',time());
							@endphp 
							Betking Agent Registration | All Rights Reserved.
						</a>
						</div>
					</div>
				</div>
				<!-- Footer -->
				
			</div>
		</div>
	</div>
@endsection