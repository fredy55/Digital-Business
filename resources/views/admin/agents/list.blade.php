@extends('admin.layouts.layout2')

@section('title', 'Admin Dashboard')

@section('contents')
    <div class="container-fluid">
        
        <!--==== Submitted Articles Details ====-->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <i class="fas fa-angle-right"></i>
                        <strong style="font-size:20px;">Agents</strong>
                    </div>
                    
                    <div class="col-md-4">
                        <!-- Breadcrumbs-->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Agents List</li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    @include('inc.flashmsg')

                    <table class="table table-bordered" id="dataTable-list" width="100%" cellspacing="0">
                        
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone N<u>o</u></th>
                                <th>Reg. Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone N<u>o</u></th>
                                <th>Reg. Date</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        
                        <tbody>
                        @php
                            $count = count($agents);
                        @endphp
                            @for ($i = 0; $i<count($agents); ++$i)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        <a href="{{ route('admin.agents.details', ['id'=>$agents[$i]->id]) }}">
                                            {{ $agents[$i]->fname }} {{ $agents[$i]->lname }}
                                        </a>
                                    </td>
                                    <td>{{ $agents[$i]->email }}</td>
                                    <td>{{ $agents[$i]->phone }}</td>
                                    <td>{{ Carbon\Carbon::parse($agents[$i]->reg_date)->format('d-m-Y') }}</td>
                                    <td>{{ $agents[$i]->status }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer small text-muted"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable-list').DataTable( {
                order: [[ 0, 'desc' ]],
            } );
        } );
    </script>
@endsection