@extends('admin.layouts.layout2')

@section('title', 'Admin Tutorials Page')

@section('contents')
    <div class="container-fluid">
        
        <!--==== Submitted Articles Details ====-->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <i class="fas fa-angle-right"></i>
                        <strong style="font-size:20px;">FAQ</strong>
                        
                        <!-- Breadcrumbs-->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">FAQ List</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin.tutorials.add') }}" type="button" class="btn btn-primary btn-medium">Add FAQ</a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    @include('inc.flashmsg')

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ttile</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Ttile</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        
                        <tbody>
                            @php
                                $count = 0;
                            @endphp
                                @foreach ($tutorials as $item)
                                    <tr>
                                        <td>{{ ++$count }}</td>
                                        <td>
                                            <a href="{{ route('admin.tutorials.details', ['id'=>$item->id]) }}">{{ $item->artic_title }}</a>
                                        </td>
                                        <td>{{ $item->tutcategory[0]['category'] }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $item->IsActive==1?'Active':'Inactve' }}</td>
                                     </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer small text-muted"></div>
            </div>
        </div>
    </div>
@endsection