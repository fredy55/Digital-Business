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
                <a href="{{ route('admin.agents') }}">Agent List</a>
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
                                    <th>Name:</th>
                                    <td>{{ $details->fname }} {{ $details->lname }}</td>
                                    <td rowspan="5"></td>
                                    
                                    <th>L.G.A.:</th>
                                    <td>{{ $details->lga }}</td>
                                </tr>
                                
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $details->email }}</td>
                                    
                                    <th>State:</th>
                                    <td>{{ $details->state }}</td>
                                </tr>

                                <tr>
                                    <th>Mobile:</th>
                                    <td>{{ $details->phone }}</td>
                                   
                                    <th>Status:</th>
                                    <td>{{ $details->status }}</td>
                                </tr>

                                <tr>
                                    <th>Date of Birth:</th>
                                    <td>{{ $details->dob }}</td>
                                    <th>Date Created:</th>
                                    <td>{{ $details->reg_date }}</td>
                                </tr>

                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ $details->gender }}</td>
                                    <th>Ref Channel</th>
                                    <td>{{ $details->ref_chan }}</td>
                                </tr>
                                <tr>
                                    <th>Shop Address:</th>
                                    <td colspan="4">{{ $details->shop_address }}</td>
                                </tr>
                                <tr>
                                    <th>Landmark:</th>
                                    <td colspan="4">{{ $details->landmark }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <h6>Indoor Image</h6>
                                        
                                        <a href="{{ asset('storage/'.$details->indoor_img_location) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$details->indoor_img_location) }}" class="img-responsive" width="150" height="150" alt="No Indoor Shop Image Found!">
                                        </a>
                                    </td>
                                    <td></td>
                                    <td colspan="2">
                                        <h6>Outdoor Image</h6>
                                        <a href="{{ asset('storage/'.$details->outdoor_img_location) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$details->outdoor_img_location) }}" class="img-responsive" width="150" height="150" alt="No Indoor Shop Image Found!">
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="{{ route('admin.agents') }}"><i class="fa fa-arrow-left"></i> Back to List</a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        {{-- <a href=""><i class="fa fa-edit"></i></a> --}}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.agents.delete', ['id'=>$details->id]) }}"><i class="fa fa-trash" onclick="alert('Do you really want to delete this record?')"></i></a>
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