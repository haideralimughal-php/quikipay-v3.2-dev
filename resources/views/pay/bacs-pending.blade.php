<style>
    .upper
    {
        background: rgb(254,99,7);
        background: linear-gradient(90deg, rgba(254,99,7,1) 0%, rgba(246,57,61,1) 50%, rgba(239,19,107,1) 100%);
        border-radius:15px;
    }
    .payment_form
    {
       border-radius:16px;
       color:#797979; 
    }
    .box
    {
        -webkit-box-shadow: 0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        -moz-box-shadow:    0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        box-shadow:         0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        border-radius: 14px;
    }
    .payment_buttons
    {
        padding: 0% 5%;
    }
    .text-s
    {
        color:#797979;
        font-size 13px;
        font-weight:bolder;
    }
    .payment_form .box .payment_buttons .text-f
    {
        color:#797979 !important;
        font-size: 14px !important;
          
    }
    .payment_form .btn_color
    {
        background-color:#44ce6f !important;
        color: white !important;
        font-weight: bolder;
        
    }
</style>
@extends('layouts.pay')

@section('content')
<div class="container-fluid">
    <div class="pt-2 pb-4">
        <div class="row pt-2 pb-4">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                
               <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                   </div>
                    <img src="{{ asset('payImages/Capa 3.png') }}" height="auto" width="70"  class="pt-2 pb-2 img-fluid mt-2 mb-2">
                   <h4 class="text-center text-s"> {{__('text.pending')}}</h4>
                   <div class="mx-5 my-5  box">
                        <div class="payment_buttons">
                            <p class="text-center btn payment_btn btn-block btn-lg text-f">{{__('text.orderRecieved')}}</p> 
                        </div>
                    </div>
                    @if(session()->has('site_url'))
                   <!-- <form action="{{ session('site_url') }}/checkout/order-received/{{ session('transaction.order_id') }}" method="post" id="transaction_form">--> 
                    <form action="{{ session('redirect') }}" method="post" id="transaction_form">
                    	    @csrf
                    	    <input type="hidden" name="tx_id" value="{{ $bacs_transaction->tx_id }}">
                    	    <input type="hidden" name="payment_method" value="fiat">
                    	    <input type="hidden" name="order_id" value="{{ session('transaction.order_id') }}">
                    	    <input type="hidden" name="currency_symbol" value="{{ $bacs_transaction->currency_symbol }}">
                    	    <input type="hidden" name="quantity" value="{{ $bacs_transaction->quantity }}">
                    	    <input type="hidden" name="deposit_at" value="{{ $bacs_transaction->created_at }}">
                    	    <input type="hidden" name="status" value="{{ $bacs_transaction->status }}">
                    	    <input type="hidden" name="customer_email" value="{{ $bacs_transaction->customer_email }}">
                    	    <input type="submit" class="btn btn_color mb-3" value="{{__('text.backBtnText')}}">
                    	</form>
                   @elseif($bacs_transaction)
                    	<form action="{{ $bacs_transaction->user->coinSettings->success_url_fiat }}" method="post" id="transaction_form">
                    	    @csrf
                    	    <input type="hidden" name="tx_id" value="{{ $bacs_transaction->tx_id }}">
                    	    <input type="hidden" name="payment_method" value="fiat">
                    	    <input type="hidden" name="order_id" value="{{ session('transaction.order_id') }}">
                    	    <input type="hidden" name="currency_symbol" value="{{ $bacs_transaction->currency_symbol }}">
                    	    <input type="hidden" name="quantity" value="{{ $bacs_transaction->quantity }}">
                    	    <input type="hidden" name="deposit_at" value="{{ $bacs_transaction->created_at }}">
                    	    <input type="hidden" name="status" value="{{ $bacs_transaction->status }}">
                    	    <input type="hidden" name="customer_email" value="{{ $bacs_transaction->customer_email }}">
                    	    <input type="submit" class="btn btn_color mb-3" value="{{__('text.backBtnText')}}">
                    	</form>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
    <!--<div class="card QRCodeAnimationClass mt-5 d-block   pt-2  box-shadow QR-card"  >-->
    <!--	<div class=" mt-1">-->
    <!--		<img src="{{ asset('payImages/largeLogo.png') }}" height="auto" width="70" class="m-auto d-block"  >-->
    <!--		<hr>-->
    <!--	</div>-->
    
    <!--	<div class="card-body" style="padding: 1.25rem;padding-top:0; ">-->
    <!--		<h5 class="card-title float-none text-center text-success "> <i class="fa fa-check-circle fa-2x"></i></h5>-->
    	
    <!--		<h4 class="card-title float-none text-center text-success "> {{__('text.success')}}</h4>-->
    		
    <!--		<h6 class="text-center mt-3 mb-3 text-success"><b>{{__('text.orderRecieved')}}</b></h6>-->
    	
    <!--		<hr>-->
    <!--		<div class="card-text d-none">-->
    <!--			<div class="row">-->
    <!--				<div class="col"><p class="float-left text-primary">Exchange rate</p></div>-->
    <!--				<div class="col"><p class="float-right text-primary   ">7136733 </p></div>-->
    <!--			</div>-->
    <!--			<hr>-->
    <!--			<div class="row">-->
    <!--				<div class="col"><p class="float-left text-primary">Total</p></div>-->
    <!--				<div class="col"><p class="float-right text-primary   ">7136733 </p></div>-->
    <!--			</div>-->
    <!--			<hr>-->
    <!--			<div class="row">-->
    <!--				<div class="col"><p class="float-left text-primary">Amount Paid</p></div>-->
    <!--				<div class="col"><p class="float-right text-primary   ">7136733 </p></div>-->
    <!--			</div>-->
    <!--		</div>-->
    <!--	</div>-->
    <!--</div>-->
    <!--<div class="QR-card mt-5"> -->
    <!--    <p>{{__('text.timerText')}}</p>-->
    	<!--<a href="/pay" class="btn btn-primary btn-lg btn-block "><i class="fa fa-arrow-left"></i> Go Back</a>-->
    <!--</div>-->
    <!--@if($bacs_transaction)-->
    <!--	<form action="{{ $bacs_transaction->user->coinSettings->success_url_fiat }}" method="post" id="transaction_form">-->
    <!--	    @csrf-->
    <!--	    <input type="hidden" name="tx_id" value="{{ $bacs_transaction->tx_id }}">-->
    <!--	    <input type="hidden" name="payment_method" value="fiat">-->
    <!--	    <input type="hidden" name="order_id" value="{{ session('transaction.order_id') }}">-->
    <!--	    <input type="hidden" name="currency_symbol" value="{{ $bacs_transaction->currency_symbol }}">-->
    <!--	    <input type="hidden" name="quantity" value="{{ $bacs_transaction->quantity }}">-->
    <!--	    <input type="hidden" name="deposit_at" value="{{ $bacs_transaction->created_at }}">-->
    <!--	    <input type="hidden" name="status" value="{{ $bacs_transaction->status }}">-->
    <!--	    <input type="hidden" name="customer_email" value="{{ $bacs_transaction->customer_email }}">-->
    <!--	    <input type="submit" class="btn btn-success" value="{{__('text.backBtnText')}}">-->
    <!--	</form>-->
    <!--@endif-->
@endsection

@section('js')

    <script>
        $(".lang").hide();
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