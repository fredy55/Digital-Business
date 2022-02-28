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
            <h1 class="m-0 text-dark">Staff Roles Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.roles') }}">Roles</a></li>
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
                                      <th>Role ID</th>
                                      <td>{{ $details->id }}</td>
                                    </tr>
                                    <tr>
                                      <th>Role Name</th>
                                      <td>{{ $details->role_name }}</td>
                                    </tr>
                                    
                                </table>
                            
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <table class="table table-stripped">
                                    <tr>
                                      <th>Description</th>
                                      <td>{{ $details->role_description }}</td>
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
                                        <td><a href="{{ route('admin.roles') }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-primary" data-toggle="modal" data-target="#UpdateRoleModal"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-danger" data-toggle="modal" data-target="#DeleteRoleModal"><i class="fa fa-trash"></i></a>
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

   <!--============ Update User Roles Modal ============-->
   <div class="modal fade" id="UpdateRoleModal" data-backdrop="static">
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
                          Update Role
                      </h5>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form role="form" method="post" action="{{ route('admin.roles.update') }}" enctype="multipart/form-data">
                          @csrf
                          <div class="card-body">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Role Name</label>
                                  <input type="text" name="rname" value="{{ $details->role_name }}" class="form-control" placeholder="Role Name" Required />
                                  <input type="hidden" name="roleId" value="{{ $details->id }}" class="form-control" placeholder="Role Name" Required />
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Role Description</label>
                                  <input type="text" name="rdescribe" value="{{ $details->role_description }}" class="form-control" placeholder="Role Description" Required />
                              </div>
                              
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary">Update</button>
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
  <!--============ Update User Roles Modal ============-->

  <!--============ Delete User Roles Modal ============-->
  <div class="modal fade" id="DeleteRoleModal" data-backdrop="static">
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
                            Delete Role
                        </h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body"> 
                        <h4>Do you really want to delete this record?</h4> <br>

                        <div style="float: right;">
                            <a type="button" href="{{ route('admin.roles.delete', ['id'=>$details->id]) }}" class="btn btn-primary">Yes</a>
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
<!--============ Delete User Roles Modal ============-->
@endsection


