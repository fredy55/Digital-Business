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
                <h3 class="m-0 text-dark"> {{ $reportOffice }} Cashier Report ({{ $reportDate }})</h3>
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
                                
                                {{-- Loop through cashier reports --}}
                                @foreach ($transToday as $creports) 
                                   <h6 style="color:black;font-weight:600;text-decoration:underline; font-size:17px;">
                                    {{ $creports['fullname'] }} ({{ $creports['role'] }} - <span style="color: navy;">{{ $creports['account'] }}</span>)
                                  </h6>
  
                                  <table class="table" style="margin-bottom: 30px; border-bottom:#aaa solid 3px;">
                                      <tr>
                                        <th>Funding</th>
                                        <td>&#8358;{{ number_format($creports['funding'], 2) }}</td>
                                        <th>Drop Money</th>
                                        <td>&#8358;{{ number_format($creports['drop_money'], 2) }}</td>
                                      </tr>

                                      <tr>
                                        <th>Top Ups</th>
                                        <td>&#8358;{{ number_format($creports['top_ups'], 2) }}</td>
                                        <th>Collected</th>
                                        <td>&#8358;{{ number_format($creports['collected'], 2) }}</td>
                                      </tr>

                                      <tr style="background: #eee;">
                                        <th>Closing</th>
                                        <td>
                                          &#8358;{{ number_format($creports['closing'], 2) }}
                                        </td>
                                        <th>Sales</th>
                                        <td>
                                          &#8358;{{ number_format($creports['sales'], 2) }}
                                        </td>
                                      </tr>
                                      
                                      <tr>
                                        <th colspan="4"></th>
                                      </tr>
                                      
                                        @if ($creports['reportStatus'] == 'Submitted')
                                             <tr style="background: #eee;">
                                                <td colspan="2">
                                                    <p>
                                                      <strong>Status:</strong>&nbsp;
                                                      <i style="color:navy;">{{ $creports['reportStatus'] }}</i>
                                                    </p>
                                                </td>
                                                <td colspan="2">
                                                  <a type="button" href="{{ route('admin.creports.withdraw', ['account'=>$creports['account'], 'date'=>$linkDate ]) }}" class="btn btn-primary">Widthdraw</a>
                                                </td>
                                              </tr>
                                              @elseif($creports['reportStatus'] == 'Approved')
                                                <tr style="background: #eee;">
                                                    <td colspan="2">
                                                      <p>
                                                        <strong>Status:</strong>&nbsp;
                                                        <b style="color:green;">
                                                          <i class="fa fa-check"></i>
                                                          {{ $creports['reportStatus'] }}
                                                        </b>
                                                      </p>
                                                    </td>
                                                  <td colspan="2"></td>
                                                </tr>
                                              @else
                                                <form method="post" action="{{ route('admin.reports.csubmit') }}" enctype="multipart/form-data">
                                                  <tr style="background: #eee;">
                                                      @csrf 
                                                      {{-- Report filed to submit --}}
                                                      <input type="hidden" name="dated" value="{{ $reportDate }}"  required />
                                                      <input type="hidden" name="sales" value="{{ $creports['sales'] }}" required />
                                                      <input type="hidden" name="closing" value="{{ $creports['closing'] }}" required />
                                                      <input type="hidden" name="account" value="{{ $creports['account'] }}" required />
                                                      <td colspan="2">
                                                        <div class="form-group">
                                                          <button type="submit" class="btn btn-primary">Submit Report</button>
                                                        </div>
                                                      </td>
                                                      <td colspan="2"></td>
                                                  </tr>
                                                </form>
                                              @endif
                                        </tr>
                                      
                                  </table>
                                @endforeach
                                
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