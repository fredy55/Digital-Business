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
            <h1 class="m-0 text-dark">Office Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.offices') }}">Offices</a></li>
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
                                      <th>Office ID</th>
                                      <td>{{ $details->office_id }}</td>
                                    </tr>
                                    <tr>
                                      <th>Office Name</th>
                                      <td>{{ $details->office_name }}</td>
                                    </tr>
                                    <tr>
                                      <th>Phone Number</th>
                                      <td>{{ $details->phone_no }}</td>
                                    </tr>
                                    <tr>
                                      <th>Email Address</th>
                                      <td>{{ $details->email }}</td>
                                    </tr>
                                    
                                </table>
                            
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <table class="table table-stripped">
                                    <tr>
                                      <th>Location</th>
                                      <td>{{ $details->address }}</td>
                                    </tr>
                                    <tr>
                                      <th>Manager</th>
                                      <td>{{ $details->ftname }} {{ $details->ltname }}</td>
                                    </tr>
                                    <tr>
                                      <th>Cashier</th>
                                      <td></td>
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
                                        <td><a href="{{ route('admin.offices') }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-primary" data-toggle="modal" data-target="#UpdateOfficeModal"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-danger" data-toggle="modal" data-target="#DeleteOfficeModal"><i class="fa fa-trash"></i></a>
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

   <!--============ Update Offices Modal ============-->
   <div class="modal fade" id="UpdateOfficeModal" data-backdrop="static">
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
                            Update Office
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.offices.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Office Name</label>
                                    <input type="text" name="ofname" value="{{ $details->office_name }}" class="form-control" placeholder="Office Name" Required />
                                    <input type="hidden" name="officeId" value="{{ $details->office_id }}" class="form-control" Required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone Number</label>
                                    <input type="number" name="ofphone" value="{{ $details->phone_no }}" class="form-control" placeholder="Phone Number" Required />
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email Address</label>
                                    <input type="email" name="ofemail" value="{{ $details->email }}" class="form-control" placeholder="Email Address" />
                                </div>
                                
                                <!-- textarea -->
                                <div class="form-group">
                                <label>Location</label>
                                <textarea name="ofaddress" class="form-control" rows="2" placeholder="Enter Office Address" Required >{{ $details->address }}</textarea>
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
    <!--============ Update Office Modal ============-->

    <!--============ Delete Office Modal ============-->
    <div class="modal fade" id="DeleteOfficeModal" data-backdrop="static">
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
                                Delete Office
                            </h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body"> 
                            <h4>Do you really want to delete this record?</h4> <br>

                            <div style="float: right;">
                                <a type="button" href="{{ route('admin.offices.delete', ['id'=>$details->office_id]) }}" class="btn btn-primary">Yes</a>
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
    <!--============ Delete Office Modal ============-->
@endsection


