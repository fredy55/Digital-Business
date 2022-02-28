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
                <h2 class="m-0 text-dark">Credit Transactions</h2>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Transactions</li>
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
                              Add Transactions
                            </button>
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        @include('inc.flashmsg')
                        
                        <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                    <th>Transaction ID</th>
                                    <th>From</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Office</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                  </tr>
                              </thead>
                              
                              <tfoot>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>From</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Office</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                             </tfoot>
                              
                              <tbody>
                                   @foreach ($credits as $credit)
                                        <tr>
                                            <td>
                                              <a href="{{ route('admin.transacts.details',['type'=>'credit', 'id'=>$credit->transaction_id]) }}">
                                                {{ $credit->transaction_id }}
                                              </a>
                                            </td>
                                            <td>{{ $credit->benefitiary }}</td>
                                            <td>&#8358;{{ number_format($credit->amount, 2) }}</td>
                                            <td>{{ $credit->type }}</td>
                                            <td>
                                              <a href="{{ route('admin.offices.details', ['id'=>$credit->office_id]) }}" target="_blank">
                                                  {{ $credit->office_name }}
                                              </a>
                                            </td>
                                            <td>{{ dateFormat($credit->created_at, 'M d, Y') }}</td>
                                            <td>{{ transactStatus($credit->IsActive) }}</td>
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

    <!--============ Add Credit Transaction Modal ============-->
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
                            Add Credit Transaction
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.transacts.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">From</label>
                                    <input type="text" name="from" class="form-control" placeholder="Sender" Required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Amount</label>
                                    <input type="number" name="amount" class="form-control" placeholder="Credit Amount" Required />
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Trnsaction Type</label>
                                    <select name="type" class="form-control" Required>
                                      <option value="">-- Select Trnsaction Type ---</option>
                                      <option value="drop_money">Drop Money</option>
                                      <option value="top_ups">Top ups</option>
                                      <option value="funded">Funded</option>
                                   </select>
                                </div>
                                
                                <!-- textarea -->
                                <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="1" placeholder="Enter Description..." Required ></textarea>
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
    <!--============ Add Credit Transaction Modal ============-->
@endsection