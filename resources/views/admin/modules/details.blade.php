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
            <h1 class="m-0 text-dark">Access Modules Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.modules') }}">Access Modules</a></li>
              <li class="breadcrumb-item active">Details</li>
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
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <table class="table table-stripped">
                                    <tr>
                                      <th>Module ID</th>
                                      <td>{{ $details->module_group }}</td>
                                    </tr>
                                    <tr>
                                      <th>Module Name</th>
                                      <td>{{ $details->module_name }}</td>
                                    </tr>
                                    
                                </table>
                            
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <table class="table table-stripped">
                                    <tr>
                                      <th>Description</th>
                                      <td>{{ $details->module_description }}</td>
                                    </tr>
                                    
                                    <tr>
                                      <th>Date Created</th>
                                      <td>{{ $details->created_at }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-4"></div>
                        
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <table class="table table-stripped">
                                    <tr>
                                        <td><a href="{{ route('admin.modules') }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-primary" data-toggle="modal" data-target="#UpdateModuleModal"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-danger" data-toggle="modal" data-target="#DeleteModuleModal"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                </table>
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

   <!--============ Update User Modules Modal ============-->
   <div class="modal fade" id="UpdateModuleModal" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <img src="{{ asset('assets/images/logo_dark.png') }}" alt="Admin Logo" style="width: 150px;"/>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                        <h5 style="text-align:center;padding:0px auto;height:20px;">
                           Update Module
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form module="form" method="post" action="{{ route('admin.modules.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Module Group</label>
                                    <input type="text" name="mgroup" value="{{ $details->module_group }}" class="form-control" placeholder="Module Group" Required />
                                    <input type="hidden" name="moduleId" value="{{ $details->id }}" Required />
                                </div>
                                <div class="form-group">
                                <label for="exampleInputEmail1">Module Name</label>
                                <input type="text" name="mname" value="{{ $details->module_name }}" class="form-control" placeholder="Module Name" Required />
                            </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Module Description</label>
                                    <input type="text" name="mdescribe" value="{{ $details->module_description }}" class="form-control" placeholder="Module Description" Required />
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
  <!--============ Update User Modules Modal ============-->

  <!--============ Delete User Modules Modal ============-->
  <div class="modal fade" id="DeleteModuleModal" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <img src="{{ asset('assets/images/logo_dark.png') }}" alt="Admin Logo" style="width: 150px;"/>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h5 style="text-align:center;padding:0px auto;height:20px;">
                            Delete Module
                        </h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body"> 
                        <h4>Do you really want to delete this record?</h4> <br>

                        <div style="float: right;">
                            <a type="button" href="{{ route('admin.modules.delete', ['id'=>$details->id]) }}" class="btn btn-primary">Yes</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--============ Delete User Modules Modal ============-->
@endsection


