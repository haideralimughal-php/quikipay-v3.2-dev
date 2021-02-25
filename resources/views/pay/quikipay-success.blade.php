@extends('layouts.pay')

@section('content')
<div class="card QRCodeAnimationClass m-auto d-block pb-2 pt-2  box-shadow QR-card"  >
	<div class=" mt-1">
		<img src="{{ asset('payImages/largeLogo.png') }}" height="auto" width="70" class="m-auto d-block"  >
		<hr>
	</div>

	<div class="card-body" style="padding: 1.25rem;padding-top:0; ">
		<div class="d-flex align-items-center justify-content-center">
		    <h5 class="card-title text-center text-success "> <i class="fa fa-check-circle fa-2x"></i></h5>
		      <h4 class="card-title text-center text-success "> {{__('text.success')}}</h4>
		</div>
		<h3 class="text-center mt-3 mb-3"><b>{{ number_format(session('transaction.quantity')) }} {{ session('transaction.currency_symbol') }}</b></h3>
	
		<hr>
		<div class="card-text">
			<div class="row">
				<div class="col"><p class="float-left text-primary">{{__('text.amountPaid')}}</p></div>
				<div class="col"><p class="float-right text-primary   ">{{ number_format(session('transaction.quantity')) }} {{ session('transaction.currency_symbol') }}  </p></div>
			</div>
		</div>
	</div>
    <div class="mt-2 mb-5">  
        
    	<!--<a href="QRcode.html" class="btn btn-primary" id="go_back"><i class="fa fa-arrow-left"></i> Go Back</a>-->
    	<p>{{__('text.timerText')}}!</p>
    	@if(session()->has('site_url'))
    	    <form action="{{ session('redirect') }}" method="post" id="transaction_form">
        	    @csrf
        	    <input type="hidden" name="tx_id" value="{{ $transaction->tx_id }}">
        	    <input type="hidden" name="payment_method" value="Pago 46">
        	    <input type="hidden" name="order_id" value="{{ session('transaction.order_id') }}">
        	    <input type="hidden" name="currency_symbol" value="{{ $transaction->currency_symbol }}">
        	    <input type="hidden" name="quantity" value="{{ $transaction->quantity }}">
        	    <input type="hidden" name="deposit_at" value="{{ $transaction->created_at }}">
        	    <input type="hidden" name="status" value="{{ $transaction->status }}">
        	    <input type="hidden" name="customer_email" value="{{ $transaction->customer_email }}">
        	    <input type="submit" class="btn btn-success" value="Go Back">
        	</form>
    	@elseif($transaction ?? '')
        	<form action="{{ session('transaction.success_url') }}" method="post" id="transaction_form">
        	    @csrf
        	    <input type="hidden" name="tx_id" value="{{ $transaction->tx_id }}">
        	    <input type="hidden" name="payment_method" value="Pago46">
        	    <input type="hidden" name="order_id" value="{{ session('transaction.order_id') }}">
        	    <input type="hidden" name="currency_symbol" value="{{ $transaction->currency_symbol }}">
        	    <input type="hidden" name="quantity" value="{{ $transaction->quantity }}">
        	    <input type="hidden" name="deposit_at" value="{{ $transaction->created_at }}">
        	    <input type="hidden" name="status" value="{{ $transaction->status }}">
        	    <input type="hidden" name="customer_email" value="{{ $transaction->customer_email }}">
        	    <input type="submit" class="btn btn-success" value="Go Back">
        	</form>
        @endif
    </div>
</div>
@endsection

@section('js')

    <script>
        $(document).ready(function(){   
            console.log(@json(session()->all()));
            window.setTimeout(function(){
                console.log('asdf');
                // Move to a new location or you can do something else
                // window.location.href = "https://www.google.co.in";
                $("#transaction_form").submit();
        
            }, 3000);

        });
    </script>

@endsection