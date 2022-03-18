@extends('admin.layouts.layout2')

@section('title', 'Transaction Daily Reports')

@section('contents')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h2 class="m-0 text-dark">Daily Transactions Reports</h2>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Transactions Reports</li>
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
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Transaction ID</th>
                                  <th>Office</th>
                                  <th>Sales</th>
                                  <th>Funded</th>
                                  <th>Drop Money</th>
                                  <th>Status</th>
                                  <th>Date</th>
                                </tr>
                            </thead>
                            
                            <tfoot>
                              <tr>
                                <th>Transaction ID</th>
                                <th>Office</th>
                                <th>Sales</th>
                                <th>Funded</th>
                                <th>Drop Money</th>
                                <th>Status</th>
                                <th>Date</th>
                              </tr>
                           </tfoot>
                            
                            <tbody>
                                 @foreach ($transacts as $transact)
                                      <tr>
                                          <td>
                                            <a href="{{ route('admin.creports.details2', ['officeid'=>$transact->office_id, 'date'=>str_replace('/', '-', $transact->date_created)]) }}">
                                              {{ $transact->transaction_id }}
                                            </a>
                                          </td>
                                          <td>{{ $transact->office_name }}</td>
                                          <td>&#8358;{{ number_format($transact->sales, 2) }}</td>
                                          <td>&#8358;{{ number_format($transact->funded, 2) }}</td>
                                          <td>&#8358;{{ number_format($transact->drop_money, 2) }}</td>
                                          <td>{{ $transact->date_created }}</td>
                                          <td>{{ transactStatus($transact->IsActive) }}</td>
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
@endsection