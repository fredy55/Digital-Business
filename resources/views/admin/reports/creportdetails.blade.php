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
                <h2 class="m-0 text-dark">Cashier Report Details ({{ $details->office_name }})</h2>
              </div><!-- /.col -->
              <div class="col-sm-5">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Report Details</li>
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
                          
                          <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                             
                                  <h6 style="color:black;font-weight:600;text-decoration:underline; font-size:17px;">
                                    {{ $transToday['fullname'] }} ({{ $transToday['role'] }} - {{ $transToday['account'] }})
                                  </h6>

                                  <table class="table">
                                    <tr>
                                      <th>Funding</th>
                                      <td>&#8358;{{ number_format($transToday['funding'], 2) }}</td>
                                      <th>Top Ups</th>
                                      <td>&#8358;{{ number_format($transToday['top_ups'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Drop Money</th>
                                        <td>&#8358;{{ number_format($transToday['drop_money'], 2) }}</td>
                                        <th>Collected</th>
                                        <td>&#8358;{{ number_format($transToday['collected'], 2) }}</td>
                                     </tr>
                                    <tr>
                                      <th colspan="4"></th>
                                  </tr>
                                    <tr style="background: #eee;">
                                        <th>Closing</th>
                                        <td>&#8358;{{ number_format($transToday['closing'], 2) }}</td>
                                        <th>Sales</th>
                                        <td>&#8358;{{ number_format($transToday['sales'], 2) }}</td>
                                    </tr>
                                  </table>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6"></div>
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