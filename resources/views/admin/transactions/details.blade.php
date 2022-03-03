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
            <h1 class="m-0 text-dark">Transactions Details</h1>
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
                                      <th>Transaction ID</th>
                                      <td>{{ $details->transaction_id }}</td>
                                    </tr>
                                    <tr>
                                      <th>Account</th>
                                      <td>{{ $details->benefitiary }}</td>
                                    </tr>
                                    <tr>
                                      <th>Amount</th>
                                      <td>&#8358;{{ number_format($details->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                      <th>Type</th>
                                      <td>{{ $details->type }}</td>
                                    </tr>
                                    <tr>
                                      <th>Description</th>
                                      <td>{{ $details->description }}</td>
                                    </tr>
                                </table>
                            
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <table class="table table-stripped">
                                    <tr>
                                      <th>Staff</th>
                                      <td>
                                        <a href="{{ route('admin.users.details', ['id'=>$details->user_id]) }}" target="_blank">
                                            {{ $details->ftname }} {{ $details->ltname }}
                                        </a>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>Position</th>
                                      <td>
                                        <a href="{{ route('admin.roles.details', ['id'=>$details->roleId]) }}" target="_blank">
                                            {{ $details->role_name }}
                                        </a>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>Office</th>
                                      <td>
                                        <a href="{{ route('admin.offices.details', ['id'=>$details->office_id]) }}" target="_blank">
                                            {{ $details->office_name }}
                                        </a>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>Status</th>
                                      <td>{{ transactStatus($details->IsActive) }}</td>
                                    </tr>
                                    <tr>
                                      <th>Date Created</th>
                                      <td>{{ Carbon\Carbon::parse($details->created_at)->format('M d, Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-4"></div>
                        
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <table class="table table-stripped">
                                    <tr>
                                        @if ($type=='credit')
                                            <td><a href="{{ route('admin.transacts.credits') }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                        @else
                                            <td><a href="{{ route('admin.transacts.debits') }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                        @endif

                                        <td>&nbsp;</td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-primary" data-toggle="modal" data-target="#UpdateTransactionModal"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a type="button" href="#" class="btn btn-danger" data-toggle="modal" data-target="#DeleteTransactionModal"><i class="fa fa-trash"></i></a>
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

   <!--============ Update Transaction Modal ============-->
   <div class="modal fade" id="UpdateTransactionModal" data-backdrop="static">
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
                          Update Transaction
                      </h5>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form role="form" method="post" action="{{ route('admin.transacts.update') }}" enctype="multipart/form-data">
                          @csrf
                          <div class="card-body">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Account</label>
                                  <input type="text" name="from" value="{{ $details->benefitiary }}" class="form-control" readonly Required />
                                  <input type="hidden" name="transactId" value="{{ $details->transaction_id }}" Required />
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Amount</label>
                                  <input type="number" name="amount" value="{{ $details->amount }}"  class="form-control" placeholder="Credit Amount" Required />
                              </div>
                              
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Transaction Type</label>
                                  <select name="type" class="form-control" readonly Required>
                                    <option value="{{ $details->type }}" >{{ $details->type }}</option>
                                    {{-- <option value="drop_money">Drop Money</option>
                                    <option value="top_ups">Top ups</option>
                                    <option value="funded">Funded</option> --}}
                                </select>
                              </div>
                              
                              <!-- textarea -->
                              <div class="form-group">
                              <label>Description</label>
                              <textarea name="description" class="form-control" rows="1" placeholder="Enter Description..." Required >{{ $details->description }}</textarea>
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
  <!--============ Update Transaction Modal ============-->

    <!--============ Delete Transaction Modal ============-->
    <div class="modal fade" id="DeleteTransactionModal" data-backdrop="static">
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
                                <a type="button" href="{{ route('admin.transacts.delete', ['type'=>$type, 'id'=>$details->transaction_id]) }}" class="btn btn-primary">Yes</a>
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
    <!--============ Delete Transaction Modal ============-->
@endsection


