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
            <h1 class="m-0 text-dark">Role Permission ({{ $UserRole }})</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.roles') }}">Roles</a></li>
              <li class="breadcrumb-item active">Permission</li>
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
                @include('inc.flashmsg')
                  <form action="{{ route('admin.restrict.save') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">
                              <button type="submit" class="btn btn-primary">Save Permission</button>
                              <input type="hidden" name="roleId" value="{{ $roleId }}" />
                          </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                         
                          <div id="accordion">
                            @for($i=0; $i<count($modules); ++$i)
                              <div class="card card-default">
                                <div class="card-header">
                                  <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapse{{ $i }}">
                                      {{ $modules[$i]['modulegroup'] }}
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse{{ $i }}" class="collapse" data-parent="#accordion">
                                  {{-- <div id="collapse{{ $i }}" class="collapse {{ $i==0?'show':'' }}" data-parent="#accordion"> --}}
                                  <div class="card-body">
                                    @foreach ($modules[$i]['modulname'] as $item)
                                       <input type="checkbox" name="moduleId[]" value="{{  $item->id }}" {{ has_access_to($roleId, $item->id)==1?'checked':'' }} />
                                       {{  $item->module_name }} <br />
                                    @endforeach
                                  </div>
                                </div>
                              </div>
                            @endfor
                            
                          </div>
                          
                        </div>
                        <!-- /.card-body -->
                      </div>
                  </form>
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
   {{-- <div class="modal fade" id="UpdateRoleModal" data-backdrop="static">
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
  </div> --}}
  <!--============ Update User Roles Modal ============-->

  <!--============ Delete User Roles Modal ============-->
  {{-- <div class="modal fade" id="DeleteRoleModal" data-backdrop="static">
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
</div> --}}
<!--============ Delete User Roles Modal ============-->
@endsection


