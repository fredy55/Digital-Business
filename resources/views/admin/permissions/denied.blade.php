@extends('admin.layouts.layout2')

@section('title', 'Admin Access Denied')

@section('contents')
   <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Access Denied</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                  <!-- Main content -->
                  <section class="content">
                    <div class="error-page">
                      <h2 class="headline text-danger">500</h2>

                      <div class="error-content">
                        <h1><i class="fas fa-exclamation-triangle text-danger"></i> Access Denied.</h1>

                        <p style="text-align:left;">
                          You are not allowed to access this page.<br />
                          Please, contact the admin for details. <br /><br />
                          <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-primary">
                            Return to Dashboard
                          </a>
                        </p>

                      </div>
                    </div>
                    <!-- /.error-page -->

                  </section>
                  <!-- /.content -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
                
  </div>
  <!-- /.content-wrapper -->

@endsection


