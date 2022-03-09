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
              <li class="breadcrumb-item active">Profile</li>
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
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <table class="table table-stripped">
                                <tr>
                                  <th>Staff ID</th>
                                  <td>{{ $details->user_id }}</td>
                                </tr>
                                <tr>
                                  <th>Full Name</th>
                                  <td>{{ $details->ftname  }} {{ $details->ltname  }}</td>
                                </tr>
                                <tr>
                                  <th>Phone Number</th>
                                  <td>{{ $details->phone_no }}</td>
                                </tr>
                                <tr>
                                  <th>Email Address</th>
                                  <td>{{ $details->email }}</td>
                                </tr>
                                <tr>
                                  <th>Gender</th>
                                  <td>{{ $details->gender }}</td>
                                </tr>
                                <tr>
                                  <th>Credit Account</th>
                                  <td>{{ $details->credit_account }}</td>
                                </tr>
                            </table>
                        
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <table class="table table-stripped">
                                <tr>
                                  <th>Office</th>
                                  <td>{{ $details->office_name }}</td>
                                </tr>
                                <tr>
                                  <th>Role</th>
                                  <td>{{ $details->role_name }}</td>
                                </tr>
                                <tr>
                                  <th>Address</th>
                                  <td>{{ $details->address }}</td>
                                </tr>
                                <tr>
                                  <th>Status</th>
                                  <td>{{ getStatus($details->IsActive) }}</td>
                                </tr>
                                <tr>
                                  <th>Last Login</th>
                                  <td>{{ $details->last_login }}</td>
                                </tr>
                                <tr>
                                  <th>Date Created</th>
                                  <td>{{ $details->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <div class="image">
                            <img 
                                @if ($details->image_url != null)
                                    src="{{ asset($details->image_url)}}"
                                @else
                                    src="{{ asset('assets/dist/img/img-profile.png') }}"
                                @endif
                                
                                style="width:100px;" 
                                class="img-circle elevation-2"
                                alt="{{ $details->image_url }}"
                            />
                          </div>
                          <p style="margin-top: 20px; font-size:15px;">
                            <a type="button" href="{{ route('admin.users.imgsave') }}" class="btn btn-primary">Change Image</a>
                          </p>
                        </div>
                    
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <table class="table table-stripped">
                                <tr>
                                    <td><a href="{{ route('admin.users') }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                    <td>
                                      <a type="button" href="{{ route('admin.users.changepass', ['id'=>$details->user_id]) }}" class="btn btn-primary">
                                        <i class="fa fa-lock"></i>&nbsp;
                                        Change Password
                                      </a>
                                   </td>
                                    <td>
                                        <a type="button" href="#" class="btn btn-primary" data-toggle="modal" data-target="#UpdateUserModal">
                                          <i class="fa fa-edit"></i>&nbsp;
                                          Update
                                        </a>
                                    </td>
                                    <td>
                                        {{-- <a type="button" href="#" class="btn btn-danger" data-toggle="modal" data-target="#DeleteUserModal"><i class="fa fa-trash"></i></a> --}}
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

   <!--============ Update Staff Account Modal ============-->
   <div class="modal fade" id="UpdateUserModal" data-backdrop="static">
      <div class="modal-dialog modal-lg">
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
                          Update Staff Profile
                      </h5>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form role="form" method="post" action="{{ route('admin.users.profile.update') }}" enctype="multipart/form-data">
                          @csrf
                          <div class="card-body">
                              <div class="row">
                                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" name="fname" value="{{ $details->ftname }}" class="form-control" placeholder="First Name" Required />
                                    <input type="hidden" name="userId" value="{{ $details->user_id }}" Required />
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" name="lname" value="{{ $details->ltname }}" class="form-control" placeholder="Last Name" Required />
                                </div>
                              </div>
                              
                              <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputPassword1">Email Address</label>
                                    <input type="email" name="email" value="{{ $details->email }}" class="form-control" placeholder="Email Address" />
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                  <label for="exampleInputPassword1">Phone Number</label>
                                  <input type="number" name="phone" value="{{ $details->phone_no }}" class="form-control" placeholder="Phone Number" Required />
                              </div>
                              </div>

                            <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="exampleInputEmail1">Gender</label>
                                <select name="gender" class="form-control" Required>
                                    <option  value="{{ $details->gender }}">{{ $details->gender }}</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="exampleInputPassword1">Staff Role</label>
                                <select name="role" class="form-control" Required>
                                  <option  value="{{ $details->roleId }}">{{ $details->role_name }}</option>
                                  {{-- @if (count($roles)>0)
                                      @foreach ($roles as $role)
                                          <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                      @endforeach
                                  @endif --}}
                                </select>
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="exampleInputEmail1">Office</label>
                                <select name="office" class="form-control" Required>
                                    <option  value="{{ $details->office_id }}">{{ $details->office_name }}</option>
                                    {{-- @if (count($offices)>0)
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->office_id }}">{{ $office->office_name }}</option>
                                        @endforeach
                                    @endif --}}
                                  </select>
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                  <label for="exampleInputEmail1">Credit Account</label>
                                  <input type="text" name="caccount" value="{{ $details->credit_account }}" class="form-control" placeholder="Enter transaction account..." Required />
                              </div>
                            </div>
                            
                            <div class="row">
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <label for="exampleInputPassword1">Home Address</label>
                                  <input type="text" name="address" value="{{ $details->address }}" class="form-control" placeholder="Home Address" Required />
                              </div>
                              {{-- <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12"></div> --}}
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
   <!--============ Update Staff Account Modal ============-->

    <!--============ Delete Staff Account Modal ============-->
    <div class="modal fade" id="DeleteUserModal" data-backdrop="static">
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
                                <a type="button" href="{{ route('admin.users.delete', ['id'=>$details->user_id]) }}" class="btn btn-primary">Yes</a>
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
    <!--============ Delete Staff Account Modal ============-->
@endsection


