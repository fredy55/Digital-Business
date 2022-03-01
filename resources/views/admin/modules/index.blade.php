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
                <h2 class="m-0 text-dark">Access Modules</h2>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                  <li class="breadcrumb-item active">Modules</li>
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
                           <button type="button" class="btn btn-info" data-toggle="modal" data-target="#AddModuleModal">
                              Add Module
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
                                    <th>Module Group</th>
                                    <th>Module Name</th>
                                    <th>Description</th>
                                    <th>Date Created</th>
                                  </tr>
                              </thead>
                              
                              <tfoot>
                                <tr>
                                  <th>S/N</th>
                                  <th>Module Group</th>
                                  <th>Module Name</th>
                                  <th>Description</th>
                                  <th>Date Created</th>
                                </tr>
                             </tfoot>
                              
                              <tbody>
                                  @php
                                      $count = 0;
                                  @endphp
                                  
                                   @foreach ($modules as $module)
                                        @php
                                            ++$count;
                                        @endphp

                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $module->module_group }}</td>
                                            <td>
                                                <a href="{{ route('admin.modules.details', ['id'=>$module->id]) }}">
                                                    {{ $module->module_name  }}
                                                </a>
                                            </td>
                                            <td>{{ $module->module_description }}</td>
                                            <td>{{ $module->created_at }}</td>
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

    <!--============ Add User Modules Modal ============-->
    <div class="modal fade" id="AddModuleModal" data-backdrop="static">
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
                            Add Module
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form module="form" method="post" action="{{ route('admin.modules.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Module Group</label>
                                    <input type="text" name="mgroup" class="form-control" placeholder="Module Group" Required />
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Module Name</label>
                                  <input type="text" name="mname" class="form-control" placeholder="Module Name" Required />
                              </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Module Description</label>
                                    <input type="text" name="mdescribe" class="form-control" placeholder="Module Description" Required />
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
    <!--============ Add User Modules Modal ============-->

@endsection
