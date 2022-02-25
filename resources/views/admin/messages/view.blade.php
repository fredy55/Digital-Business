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
                <a href="{{ route('admin.messages') }}">Messages List</a>
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
                                    <th>Ticket N<u>o</u>:</th>
                                    <td>{{ $details->msg_ticket }}</td>
                                    <td rowspan="4"></td>
                                    <th>Phone N<u>o</u>:</th>
                                    <td>{{ $details->mgphone }}</td>
                                </tr>
                                <tr>
                                    <th>Sender:</th>
                                    <td>{{ $details->mgname }}</td>
                                    <th>Status:</th>
                                    <td>{{ $details->IsActive==0?'Pending':'Read' }}</td>
                                </tr>
                                <tr>
                                    <th>Subject:</th>
                                    <td>{{ $details->mgsubject }}</td>
                                    <th>Created At:</th>
                                    <td>{{ $details->created_at }}</td>
                                </tr>

                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $details->mgemail }}</td>
                                    <th></th>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <th>Messages:</th>
                                    <td colspan="4">
                                        {{ $details->mgbody }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Reply:</th>
                                    <td colspan="4">
                                        {{ $details->repbody }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <a href="{{ route('admin.messages') }}"><i class="fa fa-arrow-left"></i> Back to List</a>
                                    </td>
                                    <td></td>
                                    @if ($details->status != "Replied")
                                        <td>
                                            <a href="#ReplyMsgModal" class="dropdown-item" data-toggle="modal" data-target="" data-id="{{ $details->id }}"><i class="fas fa-reply"></i></a>
                                        </td>
                                    @endif
                                    
                                    <td>
                                        <a href="#DelMessage" class="dropdown-item" data-toggle="modal" data-target="" data-id="{{ $details->id }}"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <input type="hidden" value="{{ route('admin.messages.confirm') }}" id="message_url">
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    <!-- /.container-fluid -->

    <!-- Reply Message Modal-->
	<div class="modal fade" id="ReplyMsgModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		  <div class="modal-content">
			
			<div class="modal-header">
			   <div class="row">
				   <div class="col-md-3">
					  <a class="navbar-brand mr-1" href="admin_dashboard">
						<img src="{{ asset('myadmin/admin_img/logo_dark.png') }}" title="Company Logo" alt="Company Logo" class="img-responsive"/>
					  </a>
				   </div>
				   <div class="col-md-8"></div>
				   <div class="col-md-1"></div>
				</div>
			  <h5 class="modal-title" id="exampleModalLongTitle">Reply Contact Message</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			
			<div class="modal-body">
				<form action="{{ route('admin.messages.update') }}" method="POST">
					@csrf

					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-2 col-form-label"><strong>To:</strong><span class="reqme">*</span></label>
						<div class="col-sm-10">
						  <input type="text" name="sendto" class="form-control" id="colFormEmail" required />
						  <input type="hidden" name="id" id="colFormId" value="" required />
						  <input type="hidden" name="sender" id="colFormSender" value="" required />
						  
						</div>
					 </div>
					
					  <div class="form-group row">
						<label for="colFormLabel" class="col-sm-2 col-form-label"><strong>Subject:</strong><span class="reqme">*</span></label>
						<div class="col-sm-10">
						  <input type="text" name="subject" class="form-control" id="colFormSubject" required />
						</div>
					 </div>
					
					<div class="form-group">
						<label for="inputAbstract"><strong>Message:</strong><span class="reqme">*</span></label>
						<textarea name="msg" class="form-control" id="textarea2" rows="3" required="" maxlength="1200"></textarea>
					</div>
						  
					<div class="form-group">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" name="reply_msg" class="btn btn-primary">Send</button>
					</div>
				</form>
			  
			</div>
			
		  </div>
		</div>
	  </div>
    <!-- Reply Message Modal-->

	<!-- Delete Message Modal-->
	<div class="modal fade" id="DelMessage" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		  <div class="modal-content">
			
			<div class="modal-header">
			   <div class="row" style="width:100%">
				   <div class="col-md-4">
					  <a class="navbar-brand mr-1" href="admin_dashboard">
						<img src="{{ asset('myadmin/admin_img/logo_dark.png') }}" title="Company Logo" alt="Company Logo" class="img-responsive"/>
					  </a>
				   </div>
				   <div class="col-md-7" style="text-align:center;font-weight:550;">
					  <h5 class="modal-title" id="exampleModalLongTitle">Delete Messages</h5>
				   </div>
				   <div class="col-md-1">
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
				   </div>
				</div>
			</div>
			
			<div class="modal-body">
			  <h5>Do you really want to delete this message record?</h5>
			</div>
			 <div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
				<a class="btn btn-primary" id="confirm" href="">Yes</a>
			 </div>
		  </div>
		</div>
	  </div>
	<!-- /Delete Shipment Modals -->
	
@endsection

@section('scripts')
	<script>
        //Update record
		$(document).ready(function(){
			$('#ReplyMsgModal').on('show.bs.modal', function (e) {
				let msgid = $(e.relatedTarget).data('id');
				//alert(ticketno);
				
				$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
				
				$.ajax({
					type : 'post',
					url : $('#message_url').val(), //Here you will fetch records 
					data :  'msgid='+msgid, //Pass $id
					success : function(data){
						//alert(data);
						if(data.status=="success"){
							$('#colFormEmail').val(data.formval.email);
							$('#colFormId').val(data.formval.id);
							$('#colFormSubject').val(data.formval.subject);
							$('#colFormSender').val(data.formval.name);

						}else if(data.status=="failed"){
							setTimeout(function () {
								$("#ReplyMsgModal").modal('hide');;
							}, 2000);
						}
					}
				});
			});
		});

		//Delete record
		$(document).ready(function(){
			$('#DelMessage').on('show.bs.modal', function (e) {
				let msgdel = $(e.relatedTarget).data('id');
				//alert(msgdel);
				$("#confirm").attr("href", "/jregadmin-tebplog/messages/delete/"+msgdel);
			});
		});
		
		
	</script>
@endsection