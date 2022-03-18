@extends('admin.layouts.layout2')

@section('title', 'Transaction Daily Reports')

@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-7">
                {{-- <h2 class="m-0 text-dark">Report Details for {{ $office->office_name }}</h2> --}}
                <h2 class="m-0 text-dark">Report History ({{ $reptoffice }})</h2>
              </div><!-- /.col -->
              <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Reports</a></li>
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
                          
                          @for ($i = 0; $i < count($details); ++$i)
                            @if ($details[$i]->IsActive==1)
                                <h4>{{ $details[$i]->date_created }}</h4>
                                <div class="row" style="margin: 20px 0px; border-bottom:2px solid #cdcdcd;">
                              <div class="col-xs-12 col-sm-12 col-md-3">
                                  <table class="table table-stripped">
                                      <tr>
                                        <th>Transaction ID</th>
                                        <td>{{ $details[$i]->transaction_id }}</td>
                                      </tr>
                                      <tr>
                                          <th>Drop Money</th>
                                          <td>&#8358;{{ number_format($details[$i]->drop_money, 2) }}</td>
                                      </tr>
                                      <tr>
                                          <th>Deposits</th>
                                          <td>&#8358;{{ number_format($details[$i]->deposit, 2) }}</td>
                                      </tr>
                                      <tr>
                                        <th>Deposit Com.</th>
                                        <td>&#8358;{{ number_format($details[$i]->deposit, 2) }}</td>
                                     </tr>
                                     <tr>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                    <tr style="background-color: silver;">
                                      <th>Total Sales</th>
                                      <td>&#8358;{{ number_format($details[$i]->sales, 2) }}</td>
                                  </tr>
                                      
                                  </table>
                              </div>
                              
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                  <table class="table table-stripped">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <th>POS</th>
                                      <td>&#8358;{{ number_format($details[$i]->pos, 2) }}</td>
                                    </tr>
                                    <tr>
                                      <th>POS Com.</th>
                                      <td>&#8358;{{ number_format($details[$i]->pos_commission, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Transfer to Bank</th>
                                        <td>&#8358;{{ number_format($details[$i]->bank_transfers, 2) }}</td>
                                    </tr>
                                    <tr>
                                      <th></th>
                                      <td></td>
                                   </tr>
                                  <tr style="background-color: silver;">
                                    <th>Old Sales</th>
                                    <td>&#8358;{{ number_format($details[$i]->old_sales, 2) }}</td>
                                </tr>
                                </table>
                              </div>
                              
                              <div class="col-xs-12 col-sm-12 col-md-5">
                                <table class="table table-stripped">
                                  <tr>
                                      <th>&nbsp;</th>
                                      <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                      <th>Winnings Paid</th>
                                      <td>&#8358;{{ number_format($details[$i]->winnings_paid, 2) }}</td>
                                  </tr>
                                  <tr>
                                      <th>Expenses</th>
                                      <td>&#8358;{{ number_format($details[$i]->expenses, 2) }}</td>
                                  </tr>
                                  <tr>
                                      <th>Transfer to Bank Com.</th>
                                      <td>&#8358;{{ number_format($details[$i]->btransfer_commission, 2) }}</td>
                                  </tr>
                                  <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                  <tr style="background-color: silver;">
                                      <th>Cash at Hand</th>
                                      <td>&#8358;{{ number_format($details[$i]->old_sales+$details[$i]->sales, 2) }}</td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            @else
                                <h4>{{ $details[$i]->date_created }}</h4> 
                                <div class="row" style="margin: 20px 0px; border-bottom:2px solid #cdcdcd;">
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                       <h5 style="color: red; text-transform:italics;">
                                        <i class="fa fa-times"></i>
                                        <i> Transaction has Not Been Submitted</i>
                                      </h5><br>
                                  </div>
                                </div>
                            @endif
                          @endfor
                          
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