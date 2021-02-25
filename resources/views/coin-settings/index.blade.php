{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.bootstrapSwitch', true)

@section('content_header')
	<h1>{{__('data.payment_gateways')}} {{$geolocation->country}} </h1>
@stop

@section('content')
@include('errors')


<form action="/coin-settings" method="post" >
	@csrf
	@method('PATCH')
	<table class="table table-bordered">
		<thead>                  
			<tr>
				<!--<th style="width: 10px">{{__('data.sr')}}</th>-->
				<th>{{__('data.payment_gateways')}}</th>
				<th>{{__('data.status')}}</th>
				<th>{{__('data.descriptions')}}</th>
				<!--<th>{{__('data.wallet')}}</th>-->
			</tr>
		</thead>
		<tbody>
		    
		
		     <tr>
		        <td>Bank Transfer</td>
		        <td>
					<input type="checkbox" name="bacs" {{ $coin_settings->bacs ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_bacs')}}
				</td>
		    </tr>
		   
		     
		    <tr>
		        <td>Khypo</td>
		        <td>
					<input type="checkbox" name="khypo" {{ $coin_settings->khypo ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_khypo')}}
				</td>
		    </tr>
		     <tr>
		        
		        <td>khypo Credit/Debit</td>
		        <td>
					<input type="checkbox" name="khypo_credit" {{ $coin_settings->khypo_credit ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_khypo')}}
				</td>
		    </tr>
		      
		       
		     <tr>
		        <td>Blockfort</td>
		        <td>
					<input type="checkbox" name="blockfort" {{ $coin_settings->blockfort ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				<p>{{__('data.longtime')}}</p>
				</td>
				<td>
				    {{__('data.des_blockfort')}}
				</td>
		    </tr>
		    <tr>
		        <td>Hites</td>
		        <td>
					<input type="checkbox" name="hites" {{ $coin_settings->hites ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				
				</td>
				<td>
				   
				</td>
		    </tr>
		     <tr>
		        <td>Pago46</td>
		        <td>
					<input type="checkbox" name="pago" {{ $coin_settings->pago ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
			
				</td>
				<td>
				   
				</td>
		    </tr>
		    <tr>
		       
		        <td>Cryptocurrency</td>
		        <td>
					<input type="checkbox" id="crypto" onchange="valueChanged()" name="crypto" {{ $coin_settings->crypto ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
					<td>
				    {{__('data.des_crypto')}}
				</td>
		    </tr>
			<tr class="cryptos">
				
				<td>Bitcoin (BTC)</td>
				<td>
					<input type="checkbox" name="btc" {{ $coin_settings->btc ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_crypto')}}
				</td>
				<!--<td><input type="text" readonly name="btc_wallet" class="form-control" placeholder="Wallet Address" value="{{ $coin_settings->btc_wallet ?  : '' }}"></td>-->
			</tr>
			<tr class="cryptos">
			
				<td>Ethereum (ETH)</td>
				<td>
					<input type="checkbox" name="eth" {{ $coin_settings->eth ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_crypto')}}
				</td>
				<!--<td><input type="text" readonly name="eth_wallet" class="form-control" placeholder="Wallet Address" value="{{ $coin_settings->eth_wallet ?  : '' }}"></td>-->
			</tr>
			<tr class="cryptos">
				
				<td>Litecoin (LTC)</td>
				<td>
					<input type="checkbox" name="ltc" {{ $coin_settings->ltc ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_crypto')}}
				</td>
				<!--<td><input type="text" readonly name="ltc_wallet" class="form-control" placeholder="Wallet Address" value="{{ $coin_settings->ltc_wallet ?  : '' }}"></td>-->
			</tr>
			<tr class="cryptos">
			
				<td>Ripple (XRP)</td>
				<td>
					<input type="checkbox" name="xrp" {{ $coin_settings->xrp ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_crypto')}}
				</td>
				<!--<td><input type="text" readonly name="xrp_wallet" class="form-control" placeholder="Wallet Address" value="{{ $coin_settings->xrp_wallet ?  : '' }}"></td>-->
			</tr>
			<tr class="cryptos">
			
				<td>Tether (USDT)</td>
				<td>
					<input type="checkbox" name="usdt" {{ $coin_settings->usdt ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
				</td>
				<td>
				    {{__('data.des_crypto')}}
				</td>
				<!--<td><input type="text" readonly name="usdt_wallet" class="form-control" placeholder="Wallet Address" value="{{ $coin_settings->usdt_wallet ?  : '' }}"></td>-->
			</tr>
			
		</tbody>
		
	</table>
	
	
	<div class="form-group " style="display:none">
        <label for="successUrl">Success URL</label>
        <input type="url" class="form-control" id="successUrl" placeholder="http://www.example.com/example" name="success_url" value="{{ $coin_settings->success_url ?  : '' }}">
    </div>
    <div class="form-group " style="display:none">
        <label for="successUrlFiat">Success URL for BACS</label>
        <input type="url" class="form-control" id="successUrlFiat" placeholder="http://www.example.com/example" name="success_url_fiat" value="{{ $coin_settings->success_url_fiat ?  : '' }}">
    </div>
	<div class="form-group row">
		<div class="col-sm-10">
			<button type="submit" class="btn btn-success">{{__('data.submit')}}</button>
		</div>
	</div>
</form>
@stop

@section('js')
<script> 
        function valueChanged(){
                  $(".cryptos").delay(300).fadeToggle();
        }
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