{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.bsCustomFileInput', true)

@section('css')
	<style>
		pre {
			background-color: white;
			border: 1px gray solid;
		}
	</style>
@stop

@section('content_header')
	<h1>{{__('data.paymentButton')}}</h1>
@stop

@section('content')
	
<pre>
&lt;form method="post" action="{{ url('/') }}/pay"&gt;
	&lt;input type="hidden" name="amount" value="100"&gt;
	&lt;input type="hidden" name="currency" value="CLP"&gt;
	&lt;input type="hidden" name="customer_email" value="customer@example.com"&gt;
	&lt;input type="hidden" name="order_id" value="xx"&gt;
	&lt;input type="hidden" name="merchant" value="{{ $merchant_id }}"&gt;
	&lt;input type="submit" class="btn btn-info btn-lg" value="Pay with Crypto"&gt;
&lt;/form&gt;
</pre>

<form method="post" action="{{ url('/') }}/pay">
	<input type="hidden" name="amount" value="1000">
	<input type="hidden" name="currency" value="CLP">
	<input type="hidden" name="customer_email" value="hanan03328367366@gmail.com">
	<input type="hidden" name="order_id" value="<?php echo rand(); ?>">
	<input type="hidden" name="merchant" value="{{ $merchant_id }}">
	<input type="submit" class="btn btn-info btn-lg" value="{{__('data.PWQ')}}">
</form>

@stop

@section('css')
	<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
	<script> 
		console.log('Hi!'); 
		$(document).ready(function () {
			bsCustomFileInput.init()
		});
	</script>
@stop