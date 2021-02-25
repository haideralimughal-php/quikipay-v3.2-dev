{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.bootstrapSwitch', true)
@section('css')
@stop


@section('content_header')
    <h1>Email Settings</h1>
@stop

@section('content')

<div class="card p-3">
    <form action="/mail-setting-update" method="post" >
        <!--<div class="d-flex justify-content-between">-->
            <h5 class="text-dark pb-2">{{__('data.receiveEmails')}}</h5>
            <div class="bootstrap-switch-container" style="width: 129px; margin-left: 0px;">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
            	<input type="checkbox" name="email_flag" {{ $mail_settings->email_flag ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>
        <!--</div>-->
        <button type="submit" class="btn btn-success float-right ">{{__('data.submit')}}</button>
    </form>
</div>

<!--<div class="custom-control custom-switch">-->
<!--  <input type="checkbox" class="custom-control-input" id="customSwitch1">-->
<!--  <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>-->
<!--</div>-->
<!--<div class="custom-control custom-switch">-->
<!--  <input type="checkbox" class="custom-control-input" disabled id="customSwitch2">-->
<!--  <label class="custom-control-label" for="customSwitch2">Disabled switch element</label>-->
<!--</div>-->

@stop


@section('js')

<script src="http://dev.quikipay.com/vendor/bootstrap-switch/js/bootstrap-switch.min.js"></script>

        <script> 
      
		$(document).ready(function () {
           

		   if ($("#crypto").attr('checked')){
		    $(".cryptos").show();
		   }else{
		    
		    $(".cryptos").hide();
		   }
		    
		    
			$("input[data-bootstrap-switch]").each(function(){
			  	$(this).bootstrapSwitch();
			});
		});
	</script>
@stop