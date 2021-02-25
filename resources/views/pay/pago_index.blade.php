<style>
    body
    {
        background: rgb(225,104,24);
        background: linear-gradient(180deg, rgba(225,104,24,1) 0%, rgba(220,67,70,1) 53%, rgba(213,32,113,1) 100%);
        background-size:cover;
        background-origin: border-box;
        font-family: raleway !important;
    
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
    }
    .payment_btn
    {
        text-align:center;
        padding: 12px 10px !important;
        font-size: 17px !important;
        font-weight: bold;
        border-radius:0px !important;
        color: #717171 !important;
        background-color: #f1f1f1 !important;
    }
    .payment_buttons
    {
        padding: 10% 1%;
    }
    .payment_btn:hover
    {
        color: white !important;
        background: rgb(119,184,150) ;
        background: linear-gradient(90deg, rgba(119,184,150,1) 0%, rgba(95,195,133,1) 50%, rgba(70,205,111,1) 100%);
    }
    .p1
    {
        margin-bottom: 0 !important;
    }
    
</style>
@extends('layouts.pay')

@section('content') 
<?php
$currencyflag=0;
?>
<div class="container-fluid">
    <div class="pt-4 pb-5">
        <div class="row pt-4 pb-5">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                
               <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                        
                                <!--<h6 class="text-white">{{ $geolocation->country }} </h6>-->
                                <!--<h6 class="text-white">{{ $geolocation->currency }} </h6>-->
                            
                   </div>
                   
               
                   <div class="payment_buttons">

                    @if( $geolocation->country=='Pakistan')
                     <?php $currencyflag='1'; ?>
                    <form method="post" action="https://dev.quikipay.com/pay/pago46_wordpress" class="form_padding">
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="payment_id" value="{{ $pay['payment_id'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/Asset 5.png') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWP')}}</p> 
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWK')}}">-->
                    </form>
                
                
                    @endif
                   
               </div>
             
                 
                </div>
            </div>
        </div>    
    </div>
</div>


<!--</form>-->

@endsection

@section('js')

   
@endsection