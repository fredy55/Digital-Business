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
                <h2 class="m-0 text-dark">Staff List</h2>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Staff</li>
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
                      <div class="card-header">
                        <h3 class="card-title">
                           <button type="button" class="btn btn-info" data-toggle="modal" data-target="#AddUserModal">
                              Add Staff Account
                            </button>
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        @include('inc.flashmsg')
                        
                        <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email Address</th>
                                    <th>Phone N<u>o</u></th>
                                    <th>Role</th>
                                    <th>Office</th>
                                    <th>Status</th>
                                    <th>Date Joined</th>
                                  </tr>
                              </thead>
                              
                              <tfoot>
                                <tr>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email Address</th>
                                    <th>Phone N<u>o</u></th>
                                    <th>Role</th>
                                    <th>Office</th>
                                    <th>Status</th>
                                    <th>Date Joined</th>
                                </tr>
                             </tfoot>
                              
                              <tbody>
                                   @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->user_id }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.details', ['id'=>$admin->user_id]) }}">
                                                    {{ $admin->ftname  }} {{ $admin->ltname  }}
                                                </a>
                                            </td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->phone_no }}</td>
                                            <td>
                                              <a href="{{ route('admin.offices.details', ['id'=>$admin->office_id]) }}" target="_blank">
                                                {{ $admin->role_name }}
                                              </a>
                                            </td>
                                            <td>
                                              <a href="{{ route('admin.roles.details', ['id'=>$admin->role_id]) }}" target="_blank">
                                                {{ $admin->office_name }}
                                              </a>
                                            </td>
                                            <td>{{ getStatus($admin->IsActive) }}</td>
                                            <td>{{ $admin->created_at }}</td>
                                         </tr>
                                   @endforeach
                              </tbody>
                             
                        </table>
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

    <!--============ Add Staff Account Modal ============-->
    <div class="modal fade" id="AddUserModal" data-backdrop="static">
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
                            Add Staff Account
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.users.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <label for="exampleInputEmail1">First Name</label>
                                      <input type="text" name="fname" class="form-control" placeholder="First Name" Required />
                                  </div>
                                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <label for="exampleInputEmail1">Last Name</label>
                                      <input type="text" name="lname" class="form-control" placeholder="Last Name" Required />
                                  </div>
                                </div>
                                
                                <div class="row">
                                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <label for="exampleInputPassword1">Email Address</label>
                                      <input type="email" name="email" class="form-control" placeholder="Email Address" />
                                  </div>
                                  <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputPassword1">Phone Number</label>
                                    <input type="number" name="phone" class="form-control" placeholder="Phone Number" Required />
                                 </div>
                                </div>

                              <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1">Gender</label>
                                    <select name="gender" class="form-control" Required>
                                      <option value="">-- Select Gender ---</option>
                                      <option value="Male">Male</option>
                                      <option value="Female">Female</option>
                                  </select>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputPassword1">Staff Role</label>
                                    <select name="role" class="form-control" Required>
                                      <option value="">-- Select Staff Role ---</option>
                                      @if (count($roles)>0)
                                          @foreach ($roles as $role)
                                              <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                          @endforeach
                                      @endif
                                    </select>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                  <label for="exampleInputEmail1">Office</label>
                                  <select name="office" class="form-control" Required>
                                      <option value="">-- Select Office ---</option>
                                      @if (count($offices)>0)
                                          @foreach ($offices as $office)
                                              <option value="{{ $office->office_id }}">{{ $office->office_name }}</option>
                                          @endforeach
                                      @endif
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="exampleInputEmail1">Grade Level</label>
                                    <select name="lgrade" class="form-control" Required>
                                      <option value="">-- Select Grade Level ---</option>
                                      <option value="1">1 (Super Admin)</option>
                                      <option value="2">2 (Manager)</option>
                                      <option value="3">3 (Cashier)</option>
                                      <option value="4">4 (IT Support)</option>
                                  </select>
                                </div>
                              </div>
                            
                              <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                  <label for="exampleInputEmail1">Credit Account</label>
                                  <input type="text" name="caccount" class="form-control" placeholder="Enter transaction account..." Required />
                                  {{-- <select name="caccount" class="form-control" Required>
                                      <option  value="">--- Select Account ---</option>
                                      <option value="2162">2162</option>
                                      <option value="21862">21862</option>
                                      <option value="Drop Money">Drop Money</option>
                                      <option value="Central">Central</option>
                                  </select> --}}
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                  <label for="exampleInputPassword1">Home Address</label>
                                  <input type="text" name="address" class="form-control" placeholder="Home Address" Required />
                                </div>
                              </div>

                              
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary">Save</button>
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
    <!--============ Add Staff Account Modal ============-->
@endsection