@extends('admin.layouts.layout2')

@section('title', 'Admin Messages Page')

@section('contents')
    <div class="container-fluid">
        
        <!--==== Submitted Articles Details ====-->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <i class="fas fa-angle-right"></i>
                        <strong style="font-size:20px;">Messages</strong>
                        
                        <!-- Breadcrumbs-->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Messages List</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        {{-- <a href="{{ route('admin.messages.add') }}" type="button" class="btn btn-primary btn-medium">Add Messages</a> --}}
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    @include('inc.flashmsg')

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        
                        <thead>
                            <tr>
                                {{-- <th>S/N</th> --}}
                                <th>Ticket N<u>o</u></th>
                                <th>Sender</th>
                                <th>Subject</th>
                                <th>Email</th>
                                <th>Phone N<u>o</u></th>
                                <th>Date</th>
                                <th>Status</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                {{-- <th>S/N</th> --}}
                                <th>Ticket N<u>o</u></th>
                                <th>Sender</th>
                                <th>Subject</th>
                                <th>Email</th>
                                <th>Phone N<u>o</u></th>
                                <th>Date</th>
                                <th>Status</th>
                                {{-- <th></th> --}}
                            </tr>
                        </tfoot>
                        
                        <tbody>
                            @php
                                $count = 0;
                            @endphp
                                @foreach ($messages as $item)
                                    <tr>
                                        {{-- <td>{{ ++$count }}</td> --}}
                                        <td>{{ $item->msg_ticket  }}</td>
                                        <td>{{ $item->mgname  }}</td>
                                        <td>
                                            <a href="{{ route('admin.messages.details', ['id'=>$item->id]) }}">
                                                {{ $item->mgsubject }}
                                            </a>
                                        </td>
                                        <td>{{ $item->mgemail }}</td>
                                        <td>{{ $item->mgphone }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $item->IsActive==0?'Pending':'Replied' }}</td>
                                        {{-- <td>
                                            <a href="{{ route('admin.messages.details', ['id'=>$item->id]) }}">Details</a>
                                        </td> --}}
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