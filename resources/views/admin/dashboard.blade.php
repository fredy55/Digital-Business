@extends('admin.layouts.layout2')

@section('title', 'Admin Dashboard')

@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Admin Dashboard</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
        
          <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
               <!-- /.col -->
               @if (has_access_to(Auth::user()->role_id,3)==1)
               <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-credit-card"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Transactions</span>
                    <span class="info-box-number" style="font-size:20px;text-align:center;">
                        {{ $transactions }}
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                @endif
              </div>
              <!-- /.col -->
              
              @if (has_access_to( Auth::user()->role_id,4))
              <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-home"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Offices</span>
                      <span class="info-box-number" style="font-size:20px;text-align:center;">
                        {{ $offices }}
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                @endif
             
              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>
              
              @if (has_access_to(Auth::user()->role_id,5)==1)
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Staff Accounts</span>
                    <span class="info-box-number" style="font-size:20px;text-align:center;">
                      {{ $users }}
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              @endif
              <!-- /.col -->
              @if (has_access_to(Auth::user()->role_id,7)==1)
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Reports</span>
                    <span class="info-box-number" style="font-size:20px;text-align:center;">
                      {{ $transactions }}
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              @endif
              <!-- /.col -->
              
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              <div class="col-md-12">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                  <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Transactions</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0">
                        <thead>
                          <tr>
                            <th>Transaction ID</th>
                            <th>Account</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Office</th>
                            <th>Status</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if (count($latestTransact)>0)
                            @foreach ($latestTransact as $transact)
                                <tr>
                                  <td>{{ $transact->transaction_id }}</td>
                                  <td>{{ $transact->benefitiary }}</td>
                                  <td>&#8358;{{ number_format($transact->amount, 2) }}</td>
                                  <td>{{ $transact->description }}</td>
                                  <td>{{ $transact->office_name }}</td>
                                  <td>{{ $transact->date_created }}</td>
                                  <td>{{ transactStatus($transact->IsActive) }}</td>
                                </tr>
                            @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!--/. container-fluid -->
          
          
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
@endsection