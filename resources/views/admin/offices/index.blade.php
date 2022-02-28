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
                <h2 class="m-0 text-dark">Offices</h2>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Offices</li>
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
                           <button type="button" class="btn btn-info" data-toggle="modal" data-target="#AddOfficeModal">
                              Add Offices
                            </button>
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        @include('inc.flashmsg')
                        
                        <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                    <th>S/N</th>
                                    <th>Offices</th>
                                    <th>Phone N<u>o</u></th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                  </tr>
                              </thead>
                              
                              <tfoot>
                                <tr>
                                  <th>S/N</th>
                                  <th>Offices</th>
                                  <th>Phone N<u>o</u></th>
                                  <th>Address</th>
                                  <th>Status</th>
                                  <th>Creation Date</th>
                                </tr>
                             </tfoot>
                              
                              <tbody>
                                  @php
                                      $count = 0;
                                  @endphp
                                  
                                   @foreach ($offices as $office)
                                        @php
                                            ++$count;
                                        @endphp

                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                                <a href="{{ route('admin.offices.details', ['id'=>$office->office_id]) }}">
                                                    {{ $office->office_name  }}
                                                </a>
                                            </td>
                                            <td>{{ $office->phone_no }}</td>
                                            <td>{{ $office->address }}</td>
                                            <td>{{ getStatus($office->IsActive) }}</td>
                                            <td>{{ $office->created_at }}</td>
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

    <!--============ Add OFFICE Modal ============-->
    <div class="modal fade" id="AddOfficeModal" data-backdrop="static">
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
                            Add Office
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.offices.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Office Name</label>
                                    <input type="text" name="ofname" class="form-control" placeholder="Office Name" Required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone Number</label>
                                    <input type="number" name="ofphone" class="form-control" placeholder="Phone Number" Required />
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email Address</label>
                                    <input type="email" name="ofemail" class="form-control" placeholder="Email Address" />
                                </div>
                                
                                <!-- textarea -->
                                <div class="form-group">
                                <label>Location</label>
                                <textarea name="ofaddress" class="form-control" rows="2" placeholder="Enter Description..." Required ></textarea>
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
    <!--============ Add Office Modal ============-->
@endsection