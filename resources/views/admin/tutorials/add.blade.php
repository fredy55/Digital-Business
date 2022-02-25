@extends('admin.layouts.layout2')

@section('title', 'Admin Tutorials Page')

@section('contents')
    <div class="container-fluid">
        
        <!--==== Submitted Articles Details ====-->
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-7">
                        <i class="fas fa-angle-right"></i>
                        <strong style="font-size:20px;">Add Tutorials</strong>
                    </div>
                    <div class="col-md-5">
                        <!-- Breadcrumbs-->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.tutorials') }}">Tutorials</a>
                            </li>
                            <li class="breadcrumb-item active">Add Tutorials</li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                
				@include('inc.flashmsg')

                <form method="post" action="{{ route('admin.tutorials.save') }}" enctype="multipart/form-data">
					@csrf
					 
					<div class="row">
                        <div class="col-md-8 col-lg-8 col-xs-12 ">
                            <div class="form-group">
                                <label for="colFormLabel"><strong>Title</strong></label>
                                <input type="text" name="title" class="form-control" maxlength="120" placeholder="e.g. New betting style in town" autofocus required />
                            </div>
                             
                            <div class="form-group">
                                <label for="colFormLabel"><strong>Category:</strong></label>
                                <select name="category" class="form-control" id="colFormLabel" aria-readonly="true" required>
                                    <option value="">--- Select Category ---</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->category_id }}">{{ $cat->category }}</option>
                                    @endforeach
                                    
                                 </select>
                            </div>
        
                            <div class="form-group">
                                <label for="colFormLabel"><strong>Description</strong></label>
                                <textarea name="description" rows="3" cols="" class="form-control ckeditor" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div> 
                        </div>
                    </div>
				</form>
            </div>
            
            <div class="card-footer small text-muted"></div>
            </div>
        </div>
    </div>
@endsection