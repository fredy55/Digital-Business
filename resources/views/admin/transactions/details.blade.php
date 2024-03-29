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
                                  @if ($details->type == 'deposit' || $details->type == 'sales' || $details->type == 'collected' || $details->type == 'closing' || $details->type == 'funded' || $details->type == 'top_ups' || $details->type == 'drop_money')
                                    <tr>
                                      <th>Account</th>
                                      <td>{{ $details->benefitiary }}</td>
                                    </tr>  
                                  @endif

                                  <tr>
                                    <th>Amount</th>
                                    <td>&#8358;{{ number_format($details->amount, 2) }}</td>
                                  </tr>
                                  @if ($details->type == 'deposit' || $details->type == 'bank_transfers' || $details->type == 'pos')
                                      <tr>
                                      <th>Commission</th>
                                      <td>&#8358;{{ number_format($details->commission, 2) }}</td>
                                    </tr>  
                                  @endif
                                  
                                  <tr>
                                    <th>Type</th>
                                    <td>{{ reverseFieldTypeFormat($details->type) }}</td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Description</th>
                                    <td>{{ $details->description }}</td>
                                  </tr>

                                  @if ($details->type == 'pos' || $details->type == 'winnings_paid')
                                    <tr>
                                      <th colspan="2">
                                        <span style="font-size: 16px;">
                                          Transaction Evidence
                                        </span><br /> <br />
                                        <img src="{{ asset($details->evidence_url) }}" alt="Transaction Evidence Image" width="180px" height="170px" />
                                      </th>
                                    </tr>  
                                  @endif

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
                                    <td>{{ $details->date_created }}</td>
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
                                          <td><a href="{{ route('admin.transacts.credits', ['type'=>reverseFieldTypeFormat($details->type)]) }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
                                      @else
                                          <td><a href="{{ route('admin.transacts.debits', ['type'=>reverseFieldTypeFormat($details->type)]) }}" style="color:#00f;"><i class="fa fa-angle-double-left"></i>&nbsp;Back to List</a></td>
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
                                  <label for="exampleInputPassword1">Transaction Type</label>
                                  <select name="type" class="form-control" readonly Required>
                                    <option value="{{ $details->type }}" >{{ reverseFieldTypeFormat($details->type) }}</option>
                                  </select>
                                  <input type="text" name="transactId" value="{{ $details->transaction_id }}" Required />
                                  <input type="text" name="transtype" value="{{ $type }}" Required />
                                  
                                  @if (Auth::user()->level == 3 && ($details->type == 'funded' || $details->type == 'drop_money' || $details->type == 'closing' || $details->type == 'top_ups'))
                                    <input type="text" name="account" value="{{ $details->benefitiary }}" Required />
                                  @elseif($details->type == 'collected' && !empty($details->benefitiary))
                                    <input type="text" name="account" value="{{ $details->benefitiary }}" Required />
                                  @else
                                  @endif
                              </div>
                              
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Amount</label>
                                  <input type="number" name="amount" value="{{ $details->amount }}"  class="form-control" placeholder="Credit Amount" Required />
                              </div>
                              
                              @if ($details->type == 'pos' || $details->type == 'bank_transfers' || $details->type == 'deposit')
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Commission</label>
                                    <input type="number" name="commission" value="{{ $details->commission }}" class="form-control" placeholder="Commission" Required />
                                  </div>
                              @endif
                              
                              <!-- textarea -->
                              <div class="form-group">
                              <label>Description</label>
                              <textarea name="description" class="form-control" rows="1" placeholder="Enter Description..." Required >{{ $details->description }}</textarea>
                              </div>

                              @if ($details->type == 'pos' || $details->type == 'winnings_paid')
                                  <div class="form-group">
                                      <label for="Evidence">Attach Evidence</label>
                                      <input type="file" name="evimage" id="Evidence" class="form-control" Required />
                                  </div>
                              @endif
                              
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


