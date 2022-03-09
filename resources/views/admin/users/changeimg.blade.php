@extends('admin.layouts.layout2')

@section('title', 'Admin Offices Page')

@section('contents')
   <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Staff Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.users.profile') }}">Staff Profile</a></li>
              <li class="breadcrumb-item active">Picture</li>
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
            
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                    @include('inc.flashmsg')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7">
                          <form role="form" method="post" action="{{ route('admin.users.imgsave') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <div class="image">
                                        <img 
                                           @if (Auth::user()->image_url != null)
                                               src="{{ asset(Auth::user()->image_url) }}"
                                           @else
                                               src="{{ asset('assets/dist/img/img-profile.png') }}"
                                           @endif
                                           
                                           style="width:100px;" class="img-circle elevation-2"
                                           alt="User Image"
                                        />
                                      </div>
                                    </div>
                                  </div>
                                 
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <label for="exampleInputEmail1">Choose Picture</label>
                                      <input type="file" name="image" class="form-control" Required />
                                      <span style="color: red;">Max. file size is 2MB.</span>
                                  </div>
                                </div>
  
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary">Update</button>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                          </div>
                        </form>
                        </div>
                    </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          
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


