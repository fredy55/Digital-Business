@extends('admin.layouts.layout2')

@section('title', 'Transaction Daily Reports')

@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-8">
                <h3 class="m-0 text-dark">{{ $details->office_name }} Report Details ({{ $details->date_created }})</h3>
              </div><!-- /.col -->
              <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.reports') }}">Reports</a></li>
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
                      <div class="card-header"></div>
                      <!-- /.card-header -->
                      <div class="card-body">
                          @include('inc.flashmsg')
                          <form role="form" method="post" action="{{ route('admin.transacts.save.credit') }}" enctype="multipart/form-data">
                              @csrf
                          <div class="row">
                            
                              <div class="col-xs-12 col-sm-12 col-md-3">
                                  <table class="table table-stripped">
                                      <tr>
                                        <th>Transaction ID</th>
                                        <td>{{ $details->transaction_id }}</td>
                                      </tr>
                                      <tr>
                                        <th>Funded</th>
                                        <td>&#8358;{{ number_format($details->funded, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Drop Money</th>
                                          <td>&#8358;{{ number_format($details->drop_money, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Top Ups</th>
                                          <td>&#8358;{{ number_format($details->top_ups, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>POS</th>
                                          <td>&#8358;{{ number_format($details->pos, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>POS Commision</th>
                                          <td>&#8358;{{ number_format($details->pos_commission, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Deposits</th>
                                          <td>&#8358;{{ number_format($details->deposit, 2) }}</td>
                                      </tr>
                                  </table><hr />

                                  <table class="table table-stripped">
                                    <tr>
                                       <td>
                                          <strong>Old Sales</strong><br />
                                          &#8358;{{ number_format($oldSales->cash_at_hand, 2) }}
                                          {{-- <input type="number" name="salestot" class="form-control" value="0.00" Required /> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          <strong>Cash at Hand</strong> <br /> 
                                          
                                          &#8358;{{ number_format($cashAtHand, 2) }}
                                          <input type="text" name="hand-cash" class="form-control" value="{{ number_format($cashAtHand, 2) }}" Required />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          @if (false)
                                              <p>
                                                <strong>Status:</strong>&nbsp;
                                                <i style="color:navy;">Submitted</i>
                                              </p>
                                          @else
                                            <div class="form-group">
                                              <button type="submit" class="btn btn-primary">Submit Report</button>
                                            </div>
                                          @endif
                                        </td>
                                    </tr>
                                    
                                </table>
                              </div>
                              
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <table class="table table-stripped">
                                      <tr>
                                        <th>Date Created</th>
                                        <td>{{ $details->date_created }}</td>
                                      </tr>
                                      
                                      <tr>
                                          <th>Collected</th>
                                          <td>&#8358;{{ number_format($details->collected, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Expenses</th>
                                          <td>&#8358;{{ number_format($details->expenses, 2) }}</td>
                                      </tr>
                                      <tr>
                                        <th>Winnings Paid</th>
                                        <td>&#8358;{{ number_format($details->winnings_paid, 2) }}</td>
                                      </tr>
                                      <tr>
                                        <th>Transfers to Bank</th>
                                        <td>&#8358;{{ number_format($details->bank_transfers, 2) }}</td>
                                      </tr>
                                      <tr>
                                        <th>Transfers to Bank (Com.)</th>
                                        <td>&#8358;{{ number_format($details->btransfer_commission, 2) }}</td>
                                    </tr>
                                    <tr>
                                      <th>Deposit Commission</th>
                                      <td>&#8358;{{ number_format($details->deposit_commission, 2) }}</td>
                                  </tr>
                                  </table> <hr />

                                  <table class="table table-stripped">
                                    <tr>
                                        <td>
                                          <strong>Total Sales</strong><br />
                                          &#8358;{{ number_format($totSales, 2) }}
                                          <input type="text" name="salestot" class="form-control" value="{{ number_format($totSales, 2) }}" Required />
                                        </td>
                                    </tr>
                                    
                                </table>
                              </div>
                              
                              <div class="col-xs-12 col-sm-12 col-md-5">
                                {{-- @php
                                    $totsales = 0;
                                @endphp --}}
                                @foreach ($transToday as $cahier)
                                    {{-- @php
                                        $totsales = $totsales+$cahier['sales'];
                                    @endphp --}}
                                    <h6 style="color:black;font-weight:600;text-decoration:underline; font-size:17px;">
                                      {{ $cahier['fullname'] }} ({{ $cahier['role'] }} - {{ $cahier['account'] }})
                                    </h6>

                                    <table class="table">
                                      <tr>
                                        <th>Funding</th>
                                        <td>&#8358;{{ number_format($cahier['funding'], 2) }}</td>
                                        <th>Top Ups</th>
                                        <td>&#8358;{{ number_format($cahier['top_ups'], 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Drop Money</th>
                                          <td>&#8358;{{ number_format($cahier['drop_money'], 2) }}</td>
                                          <th>Closing</th>
                                          <td>&#8358;{{ number_format($cahier['closing'], 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Collected</th>
                                          <td>&#8358;{{ number_format($cahier['collected'], 2) }}</td>
                                          <th>Sales</th>
                                          <td>&#8358;{{ number_format($cahier['sales'], 2) }}</td>
                                      </tr>
                                      <tr>
                                        <th>Sales Status</th>
                                        <td>
                                          @if ($cahier['hasSalesSubmit'])
                                              <i style="color: navy;">Submitted</i>
                                          @else
                                              <span style="color: red;">Pending</span>
                                          @endif
                                        </td>
                                    </tr>
                                    </table>
                                @endforeach
                                    <p> <strong>Cashier(s) Total Sales</strong> = &#8358;{{ number_format( $salesTot, 2) }}</p>
                                    <input type="number" name="salestot" class="form-control" value="{{ $salesTot }}" Required />
                              </div>
                            </form>
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
@endsection