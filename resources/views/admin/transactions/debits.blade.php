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
                <h2 class="m-0 text-dark">Debit Transactions ({{ $typeField }})</h2>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Transactions</li>
                  <li class="breadcrumb-item active">{{ $typeField }}</li>
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
                              Add {{ $typeField }}
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
                                    {{-- <th>Account</th> --}}
                                    <th>Amount</th>
                                    <th>Office</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                  </tr>
                              </thead>
                              
                              <tfoot>
                                <tr>
                                    <th>Transaction ID</th>
                                    {{-- <th>Account</th> --}}
                                    <th>Amount</th>
                                    <th>Office</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                             </tfoot>
                              
                              <tbody>
                                   @foreach ($debits as $debit)
                                        <tr>
                                            <td>
                                              <a href="{{ route('admin.transacts.details',['type'=>'debit', 'id'=>$debit->transaction_id]) }}">
                                                {{ $debit->transaction_id }}
                                              </a>
                                            </td>
                                            {{-- <td>{{ $debit->benefitiary }}</td> --}}
                                            <td>&#8358;{{ number_format($debit->amount, 2) }}</td>
                                            <td>
                                              <a href="{{ route('admin.offices.details', ['id'=>$debit->office_id]) }}" target="_blank">
                                                  {{ $debit->office_name }}
                                              </a>
                                            </td>
                                            <td>{{ $debit->date_created }}</td>
                                            <td>{{ transactStatus($debit->IsActive) }}</td>
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

    <!--============ Add Debit Transaction Modal ============-->
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
                            Add {{ $typeField }} Transaction
                        </h5>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.transacts.save.debit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                              <div class="form-group">
                                <label for="exampleInputPassword1">Transaction Type</label>
                                <select name="type" class="form-control" Required>
                                  <option value="{{ $transType }}">{{ $typeField }}</option>
                               </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Amount</label>
                                <input type="number" name="amount" class="form-control" placeholder="Amount" Required />
                            </div>

                            @if ($typeField == 'POS' || $typeField == 'Bank Transfers')
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Commission</label>
                                    <input type="number" name="commission" class="form-control" placeholder="Commission" Required />
                                </div>
                            @endif
                            
                            @if ($typeField == 'Sales' || $typeField == 'Collected' || $typeField == 'Closing')
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Account Used</label>
                                  @if ($uesrLevel==3)
                                    <input 
                                      type="text" 
                                      name="account" 
                                      value = "{{ $uesrAccount }}"
                                      readonly
                                      class="form-control" 
                                      placeholder="Enter the account to be credited..." 
                                      Required 
                                    />
                                    @else
                                      <select name="account" class="form-control" Required>
                                        @foreach ($uesrAccOptions as $item)
                                           <option value="{{ $item->credit_account }}">{{ $item->credit_account }}</option>
                                        @endforeach
                                        <option value="Manager">Manager</option>
                                      </select>
                                    @endif
                                </div>
                            @endif
                            
                                
                             <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" placeholder="Enter Description..." Required />
                              </div>

                              @if ($typeField == 'POS' || $typeField == 'Winning Paid')
                                  <div class="form-group">
                                      <label for="Evidence">Attach Evidence</label>
                                      <input type="file" name="evimage" id="Evidence" class="form-control" />
                                  </div>
                              @endif

                              <div class="form-group">
                                  <label for="tdate">Date</label>
                                  <input type="date" name="transdate" id="tdate" class="form-control" />
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
    <!--============ Add Debit Transaction Modal ============-->
@endsection