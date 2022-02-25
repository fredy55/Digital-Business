<script>
    setTimeout(()=>{
		$("#close").css('display','none');
	},10000);
</script>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block" id="close">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block" id="close">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block" id="close">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block" id="close">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-warning" id="close">
        <button type="button" class="close" data-dismiss="alert">×</button>   
        Invalid form data! Please, try again.
    </div>
@endif
