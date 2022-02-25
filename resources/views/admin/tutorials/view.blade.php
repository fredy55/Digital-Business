@extends('admin.layouts.layout2')

@section('title', 'Admin Dashboard')

@section('contents')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.tutorials') }}">Tutorials List</a>
            </li>
            <li class="breadcrumb-item active">Details</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('inc.flashmsg')
                            <table class="table table-stripped" width="100%" cellspacing="0">
                                <tr>
                                    <th>Title:</th>
                                    <td>{{ $details->artic_title }}</td>
                                    <td rowspan="2"></td>
                                    <th>Status:</th>
                                    <td>{{ $details->IsActive?'Active':'Inactive' }}</td>
                                    
                                </tr>
                                
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $details->tutcategory[0]['category'] }}</td>
                                    <th>Created At:</th>
                                    <td>{{ $details->created_at }}</td>
                                </tr>

                                <tr>
                                    <th>Message:</th>
                                    <td colspan="4">
                                        {!! $details->description !!}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <a href="{{ route('admin.tutorials') }}"><i class="fa fa-arrow-left"></i> Back to List</a>
                                    </td>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('admin.tutorials.edit', ['id'=>$details->id]) }}"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tutorials.delete', ['id'=>$details->id]) }}"><i class="fa fa-trash" onclick="alert('Do you really want to delete this record?')"></i></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    
    </div>
    <!-- /.container-fluid -->
@endsection