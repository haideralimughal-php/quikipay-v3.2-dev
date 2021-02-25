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
                      
                      @if($limit_min_order_status=='1') 
                      @if($users[0]->crypto=='1')
                        <?php $currencyflag='1'; ?>
                       <form method="post" action="https://dev.quikipay.com/pay/step1" class="form_padding">
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/Asset 3.png') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWC')}}</p></span> 
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWC')}}">-->
                    </form>
                      @endif
                    @if($geolocation->country!='Chile' and $users[0]->blockfort=='1')
                     <?php $currencyflag='1'; ?>
                    <form method="post" action="https://dev.quikipay.com/pay/blockfort" class="form_padding" >
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/Asset 6.png') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWCD')}}</p></span> 
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWC')}}">-->
                    </form>
                    @endif
                    
                    
                    @if(($geolocation->country=='Pakistan' or $geolocation->country=='Peru' or $geolocation->country=='Argentina'))
                    <form method="post" action="https://dev.quikipay.com/pay/two_checkout" class="form_padding" style="display:none;">
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/Asset 6.png') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWCD')}}</p></span> 
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWC')}}">-->
                    </form>
                    @endif
                    
                    
                    @if(($geolocation->country=='Chile' or $geolocation->country=='Argentina' or  $geolocation->country=='Pakistan'or $geolocation->country=='Peru' or $geolocation->country=='Panama') and ($users[0]->bacs=='1'))
                     <?php $currencyflag='1'; ?>
                    <form method="post" action="https://dev.quikipay.com/pay/bacs" class="form_padding">
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/Asset 4.png') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWB')}}</p></span> 
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWB')}}">-->
                    </form>
                    @endif
                    
                    @if($geolocation->country=='Chile'   and $users[0]->khypo=='1')
                         <?php $currencyflag='1'; ?>
                        <form method="post" action="https://dev.quikipay.com/pay/khipu" class="form_padding">
                        	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                        	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                        	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                        	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                        	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                        	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                        	<button type="submit" class="btn payment_btn btn-block btn-lg">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center justify-content-end">
                                        <span> <img src="{{ asset('payImages/Asset 5.png') }}" height="auto" width="40" class="" alt="..."></span>
                                    </div>
                                    <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                        <span><p class="p1">{{__('text.PWK')}}</p></span> 
                                    </div>    
                                </div>
                            </button>
                        	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWK')}}">-->
                        </form>
                        @if($users[0]->khypo_credit=='1')
                        <?php $currencyflag='1'; ?>
                        <form method="post" action="https://dev.quikipay.com/pay/khipu-card" class="form_padding">
                        	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                        	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                        	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                        	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                        	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                        	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                        	<button type="submit" class="btn payment_btn btn-block btn-lg">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center justify-content-end">
                                        <span> <img src="{{ asset('payImages/Asset 6.png') }}" height="auto" width="40" class="" alt="..."></span>
                                    </div>
                                    <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                        <span><p class="p1">{{__('text.PWCC')}}</p></span> 
                                    </div>    
                                </div>
                            </button>
                        	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWCC')}}">-->
                        </form>
                        @endif
                    @endif
                        
                    @if($users[0]->hites=='1' and $geolocation->country=='Pakistan')
                     <?php $currencyflag='1'; ?>
                    <form method="post" action="https://dev.quikipay.com/pay/hites" class="form_padding">
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/hites.svg') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWH')}}</p> </span>
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWK')}}">-->
                    </form>
                    @endif
                    
                    @if($users[0]->pago=='1' and $geolocation->country=='Pakistan')
                     <?php $currencyflag='1'; ?>
                    <form method="post" action="https://dev.quikipay.com/pay/pago46" class="form_padding">
                    	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
                    	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
                    	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
                    	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
                    	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
                    	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                    	<button type="submit" class="btn payment_btn btn-block btn-lg">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span> <img src="{{ asset('payImages/Asset 5.png') }}" height="auto" width="40" class="" alt="..."></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1">{{__('text.PWP')}}</p></span> 
                                </div>    
                            </div>
                        </button>
                    	<!--<input type="submit" class="btn payment_btn btn-block btn-lg" value="{{__('text.PWK')}}">-->
                    </form>
                    @endif
                    
                    <!--<form method="post" action="https://dev.quikipay.com/pay/hites" class="form_padding d-none">-->
                        <button type="button"  class="btn payment_btn btn-block btn-lg d-none">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center justify-content-end">
                                    <span style="background-color:gray;"> <img src="{{ asset('payImages/logox.png') }}" height="40px" width="40" class="" alt="..." style="object-fit:contain;"></span>
                                </div>
                                <div class="col-9 text-left d-flex align-items-center font-weight-bold">
                                    <span><p class="p1" data-toggle="modal" data-target="#exampleModal">{{__('text.PWQ')}}</p> </span>
                                </div>    
                            </div>
                        </button>
                    
                    @if($currencyflag=='0')
                        <h3>{{ __('text.allCryptoDisabled') }}</h3>
                    @endif
                    
                    @else
                     <h3>{{ __('text.lowlimit',[
                                    'limit' => $limit_min_order,
                                    ]
                            ) }}</h3>
                    @endif
               </div>
                
                 
                 
                </div>
            </div>
        </div>    
    </div>
</div>


<!--</form>-->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
            <div class="">
                <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  >
                    <!--<h6 class="text-white">{{ $geolocation->country }} </h6>-->
                    <!--<h6 class="text-white">{{ $geolocation->currency }} </h6>-->
            </div>
            
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div> <h5 class="modal-title text-center text-danger" id="exampleModalLabel">Login</h5></div>
        <form method="post" action="https://dev.quikipay.com/pay/quikipay" class="form_padding">
        	<input type="hidden" name="amount" value="{{ $pay['amount'] }}">
        	<input type="hidden" name="order_id" value="{{ $pay['order_id'] }}">
        	<input type="hidden" name="currency" value="{{ $pay['currency'] }}">
        	<input type="hidden" name="customer_email" value="{{ $pay['customer_email'] }}">
        	<input type="hidden" name="merchant" value="{{ $pay['merchant'] }}">
        	<input type="hidden" name="products_data" value="{{ $pay['products_data'] }}">
                      
            <div class="form-group">
                <label class="float-left" for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
              
            <div class="form-group">
                <label class="float-left" for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
   
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')

   
@endsection