<style>
    body
    {
        font-family: roboto !important;
    }
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
        color:#797979 !important;
    }
    .text-s
    {
        color:#797979;
        font-size 13px;
        font-weight:bolder;
    }
    .text-f
    {
        font-size:13px;
        font-weight: bolder;
    }
    .payment_buttons
    {
        padding: 0% 10% 10%;
    }
    .payment_form .btn_color
    {
        background-color:#44ce6f !important;
        color: white !important;
        font-weight: bolder;
        
    }
    .font
    {
        font-family: raleway !important;
    }
</style>
@extends('layouts.pay')

@section('content')
<div class="container-fluid">
    <div class="pt-3 pb-4">
        <div class="row pt-3 pb-4">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                
               <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                   </div>
                        <img src="{{ asset('payImages/Group59.png') }}" height="auto" width="70"  class="pt-2 pb-2 img-fluid mt-2 mb-2">
                       <h4 class="text-center text-s font">{{__('text.success')}}</h4>
                   <div class="mx-3 my-4 py-3 box">
                       <h3 class="text-center mt-3 mb-3"><b>{{ number_format($orderDetail['amount']) }} {{ $orderDetail['cur_currency'] }}</b></h3>
                       <div class="row text-f">
                           <div class="col-lg-5 col-12 text-center">
                                <p class="">{{__('text.exchangeRate')}}</p> 
                           </div>
                           <div class="col-lg-6 offset-lg-1 col-12 text-center">
                               <p class="pr-2">{{ $orderDetail['rate'] }} {{ $orderDetail['cur_currency'] }} </p>
                           </div>
                       </div>
                       <div class="row text-f">
                           <div class="col-lg-5 col-12 text-center">
                                <p class="">{{__('text.total')}}</p> 
                           </div>
                           <div class="col-lg-6 offset-lg-1 col-12 text-center">
                               <p class="pr-2">{{ $orderDetail['multiplied'] }} {{ $orderDetail['currency'] }}  </p>
                           </div>
                       </div>
                       <div class="row text-f">
                           <div class="col-lg-5 col-12 text-center">
                                <p class="">{{__('text.amountPaid')}}</p> 
                           </div>
                           <div class="col-lg-6 offset-lg-1 col-12 text-center">
                               <p class="pr-2">{{ $orderDetail['multiplied'] }} {{ $orderDetail['currency'] }}  </p>
                           </div>
                       </div>
                   </div>
                       <div class="mt-2 pb-3">  
        
    	
                    	<p class="">{{__('text.timerText')}}!</p>
                    	@if(session()->has('site_url'))
                    	    <form action="{{ session('redirect') }}" method="post" id="transaction_form">
                        	    @csrf
                        	    <input type="hidden" name="deposit_id" value="{{ $transaction ?? ''->deposit_id }}">
                        	    <input type="hidden" name="payment_method" value="crypto">
                        	    <input type="hidden" name="order_id" value="{{ $orderDetail['order_id'] }}">
                        	    <input type="hidden" name="currency_symbol" value="{{ $transaction ?? ''->currency_symbol }}">
                        	    <input type="hidden" name="quantity" value="{{ $transaction ?? ''->quantity }}">
                        	    <input type="hidden" name="deposit_at" value="{{ $transaction ?? ''->deposit_at }}">
                        	    <input type="hidden" name="status" value="{{ $transaction ?? ''->status }}">
                        	    <input type="hidden" name="customer_email" value="{{ $transaction ?? ''->customer_email }}">
                        	    <input type="submit" class="btn btn_color mb-3" value="{{__('text.backBtnText')}}">
                        	</form>
                    	@elseif($transaction ?? '')
                        	<form action="{{ $orderDetail['success_url'] }}" method="post" id="transaction_form">
                        	    @csrf
                        	    <input type="hidden" name="deposit_id" value="{{ $transaction ?? ''->deposit_id }}">
                        	    <input type="hidden" name="payment_method" value="crypto">
                        	    <input type="hidden" name="order_id" value="{{ $orderDetail['order_id'] }}">
                        	    <input type="hidden" name="currency_symbol" value="{{ $transaction ?? ''->currency_symbol }}">
                        	    <input type="hidden" name="quantity" value="{{ $transaction ?? ''->quantity }}">
                        	    <input type="hidden" name="deposit_at" value="{{ $transaction ?? ''->deposit_at }}">
                        	    <input type="hidden" name="status" value="{{ $transaction ?? ''->status }}">
                        	    <input type="hidden" name="customer_email" value="{{ $transaction ?? ''->customer_email }}">
                        	    <input type="submit" class="btn btn_color mb-3" value="{{__('text.backBtnText')}}">
                        	</form>
                        @endif
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<!--<div class="card QRCodeAnimationClass m-auto d-block pb-2 pt-2  box-shadow QR-card"  >-->
<!--	<div class=" mt-1">-->
<!--		<img src="{{ asset('payImages/largeLogo.png') }}" height="auto" width="70" class="m-auto d-block"  >-->
<!--		<hr>-->
<!--	</div>-->

<!--	<div class="card-body" style="padding: 1.25rem;padding-top:0; ">-->
<!--		<h5 class="card-title text-center text-success "> <i class="fa fa-check-circle fa-2x"></i></h5>-->
<!--		<h4 class="card-title text-center text-success ">{{__('text.success')}}</h4>-->
<!--		<h3 class="text-center mt-3 mb-3"><b>{{ number_format($orderDetail['amount']) }} {{ $orderDetail['cur_currency'] }}</b></h3>-->
	
<!--		<hr>-->
<!--		<div class="card-text">-->
<!--			<div class="row">-->
<!--				<div class="col"><p class="float-left text-primary">{{__('text.exchangeRate')}}</p></div>-->
<!--				<div class="col"><p class="float-right text-primary   ">{{ $orderDetail['rate'] }} {{ $orderDetail['cur_currency'] }} </p></div>-->
<!--			</div>-->
<!--			<hr>-->
<!--			<div class="row">-->
<!--				<div class="col"><p class="float-left text-primary">{{__('text.total')}}</p></div>-->
<!--				<div class="col"><p class="float-right text-primary   ">{{ $orderDetail['multiplied'] }} {{ $orderDetail['currency'] }}  </p></div>-->
<!--			</div>-->
<!--			<hr>-->
<!--			<div class="row">-->
<!--				<div class="col"><p class="float-left text-primary">{{__('text.amountPaid')}}</p></div>-->
<!--				<div class="col"><p class="float-right text-primary   ">{{ $orderDetail['multiplied'] }} {{ $orderDetail['currency'] }}  </p></div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--    <div class="mt-2 mb-5">  -->
        
    	<!--<a href="QRcode.html" class="btn btn-primary" id="go_back"><i class="fa fa-arrow-left"></i> Go Back</a>-->
<!--    	<p>{{__('text.timerText')}}!</p>-->
<!--    	@if($transaction ?? '')-->
<!--        	<form action="{{ $orderDetail['success_url'] }}" method="post" id="transaction_form">-->
<!--        	    @csrf-->
<!--        	    <input type="hidden" name="deposit_id" value="{{ $transaction ?? ''->deposit_id }}">-->
<!--        	    <input type="hidden" name="payment_method" value="crypto">-->
<!--        	    <input type="hidden" name="order_id" value="{{ $orderDetail['order_id'] }}">-->
<!--        	    <input type="hidden" name="currency_symbol" value="{{ $transaction ?? ''->currency_symbol }}">-->
<!--        	    <input type="hidden" name="quantity" value="{{ $transaction ?? ''->quantity }}">-->
<!--        	    <input type="hidden" name="deposit_at" value="{{ $transaction ?? ''->deposit_at }}">-->
<!--        	    <input type="hidden" name="status" value="{{ $transaction ?? ''->status }}">-->
<!--        	    <input type="hidden" name="customer_email" value="{{ $transaction ?? ''->customer_email }}">-->
<!--        	    <input type="submit" class="btn btn-success" value="{{__('backBtnText')}}">-->
<!--        	</form>-->
<!--        @endif-->
<!--    </div>-->
<!--</div>-->
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