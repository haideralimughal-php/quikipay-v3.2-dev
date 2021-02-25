<style>
    body
    {
        background: rgb(225,104,24);
        background: linear-gradient(180deg, rgba(225,104,24,1) 0%, rgba(220,67,70,1) 53%, rgba(213,32,113,1) 100%);
        background-size:cover;
        height:auto !important;
        background-origin: border-box;
        background-repeat: no-repeat;
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
       text-align:left !important;
       -webkit-box-shadow: 0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        -moz-box-shadow:    0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        box-shadow:         0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        padding: 12px 10px !important;
        border-radius:12px !important;
        font-weight: bold;
        color: #717171 !important;
    }
    .payment_buttons
    {
        padding: 10% 20%;
    }
    .payment_btn:hover
    {
        background-color: #e6e6e6;
    }
    .flex
    {
        display: flex !important;
        justify-content: space-evenly;
        align-items: center;
        font-size:10px ;
    }
    .flex p
    {
        margin:0;
        font-size:10px ;
    }
    .flex .p1
    {
        font-size: 14px !important;
        font-weight: bolder;
    }
    form
    {
            margin-block-end: 0em !important;

    }
    .p2
    {
        font-family: Roboto !important;
    }
    
    
</style>
@extends('layouts.pay')

@section('content')



    <!-- <div class="card card-success animsition" style="width: 18rem;"> -->
    <!--<div class=" mb-2" >-->
    <!--    <h2  class="text-center site-title text-uppercase"><b>Quicki Pay</b></h2>-->
    <!--</div>-->
    <!--<div class="mt-2">-->
    <!--    <h6 class="text-primary">{{ $geolocation->country }}</h6>-->
    <!--</div>-->
    <!-- </div> -->
             
    <div class="container-fluid">
    <div class="pt-2 pb-3">
        <div class="row pt-2 pb-3">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                   </div>
                   <div class="payment_buttons">
                       @if($users[0]->btc == '0' && $users[0]->ltc == '0' && $users[0]->xrp == '0' && $users[0]->eth == '0' && $users[0]->usdt == '0')
                            <h3>{{ __('data.allCryptoDisabled') }}</h3>
                       @else
                        @if($users[0]->btc =='1')
                        <form action="/pay/step2" method="POST">
                            <input type="hidden" name="currency" value="BTC">
                            <input type="hidden" name="amount" value="{{ session('payable_amount') }}">
                            <input type="hidden" name="order_id" value="{{ session('order_id') }}">
                            <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">
                            <input type="hidden" name="rate" value="{{ $converted['BTC']->bid }}">
                            <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">
                            <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">
                            <button type="submit" class="btn payment_btn btn-block btn-lg flex">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-end justify-content-end">
                                        <span> <img src="{{ asset('payImages/l1.png') }}" height="auto" width="35" class="" alt="..."></span>
                                    </div>
                                    <div class="col-9 text-left d-flex align-items-center">
                                        <span><p class="p1">{{__('text.btcPay')}}</p>
                                        <p class="p2">1<b> BTC</b> = <?php echo  number_format($converted['BTC']->bid,3) ?><b> <?php echo $geolocation->currency; ?></b></p></span>
                                    </div>    
                                </div>
                            </button>
                        </form>
                        @endif
                        <br>
                        @if($users[0]->ltc =='1')
                        <form action="/pay/step2" method="POST" >
                            <input type="hidden" name="currency" value="LTC">
                            <input type="hidden" name="amount" value="{{ session('payable_amount') }}">
                            <input type="hidden" name="order_id" value="{{ session('order_id') }}">
                            <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">
                            <input type="hidden" name="rate" value="{{ $converted['LTC']->bid }}">
                            <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">
                            <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">
                            <button type="submit" class="btn payment_btn btn-block btn-lg flex">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-end justify-content-end">
                                        <span> <img src="{{ asset('payImages/l4.png') }}" height="auto" width="35" class="" alt="..."></span>
                                    </div>
                                    <div class="col-9 text-left d-flex align-items-center">
                                        <span><p class="p1">{{__('text.ltcPay')}}</p>
                                        <p class="p2">1<b> LTC</b> = <?php echo  number_format($converted['LTC']->bid,2) ?><b> <?php echo $geolocation->currency; ?></b></p></span>
                                    </div>    
                                </div>
                            </button>
                        </form>
                        @endif
                        <br>
                        @if($users[0]->xrp =='1') 
                        
                            <form action="/pay/step2" method="POST">
                                <input type="hidden" name="currency" value="XRP">
                                <input type="hidden" name="amount" value="{{ session('payable_amount') }}">
                                <input type="hidden" name="order_id" value="{{ session('order_id') }}">
                                <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">
                                <input type="hidden" name="rate" value="{{ $converted['XRP']->bid }}">
                                <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">
                                <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">
                                <button type="submit" class="btn payment_btn btn-block btn-lg flex">
                                    <div class="row">
                                        <div class="col-3 d-flex align-items-end justify-content-end">
                                            <span> <img src="{{ asset('payImages/l2.png') }}" height="auto" width="35" class="" alt="..."></span>
                                        </div>
                                        <div class="col-9 text-left d-flex align-items-center">
                                            <span><p class="p1">{{__('text.xrtPay')}}</p>
                                            <p class="p2">1<b> XRP</b> = <?php echo  number_format($converted['XRP']->bid, 5) ?><b> <?php echo $geolocation->currency; ?></b></p></span>
                                        </div>    
                                    </div>
                                </button>
                            </form>
                            <!--<a href="/pay/step2/XRP/100/{{ $geolocation->currency }}/{{ $converted['XRP']->bid }}/{{$users[0]->user_id}}" >-->
                                
                            <!--</a>-->
                        @endif
                        <br>
                        
                        @if($users[0]->eth =='1')
                        <form action="/pay/step2" method="POST" style="display:none">
                            <input type="hidden" name="currency" value="ETH">
                            <input type="hidden" name="amount" value="{{ session('payable_amount') }}">
                            <input type="hidden" name="order_id" value="{{ session('order_id') }}">
                            <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">
                            <input type="hidden" name="rate" value="{{ $converted['ETH']->bid }}">
                            <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">
                            <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">
                            <button type="submit" class="btn payment_btn btn-block btn-lg flex">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-end justify-content-end">
                                        <span> <img src="{{ asset('payImages/l3.png') }}" height="auto" width="35" class="" alt="..."></span>
                                    </div>
                                    <div class="col-9 text-left d-flex align-items-center">
                                        <span><p class="p1">{{__('text.ethPay')}}</p>
                                        <p class="p2">1<b> ETH</b> = <?php echo  number_format($converted['ETH']->bid,3) ?><b> <?php echo $geolocation->currency; ?></b></p></span>
                                    </div>    
                                </div>
                            </button>
                        </form>
                        @endif
                        <br>
                        
                         @if($users[0]->usdt =='1')
                        <form action="/pay/step2" method="POST">
                            <input type="hidden" name="currency" value="USDT">
                            <input type="hidden" name="amount" value="{{ session('payable_amount') }}">
                            <input type="hidden" name="order_id" value="{{ session('order_id') }}">
                            <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">
                            <input type="hidden" name="rate" value="{{ $converted['USDT']->bid }}">
                            <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">
                            <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">
                            <button type="submit" class="btn payment_btn btn-block btn-lg flex">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-end justify-content-end">
                                        <span> <img src="{{ asset('payImages/Untitled-2-01.png') }}" height="auto" width="35" class="" alt="..."></span>
                                    </div>
                                    <div class="col-9 text-left d-flex align-items-center">
                                        <span><p class="p1">{{__('text.usdtPay')}}</p>
                                        <p class="p2">1<b> USDT</b> = <?php echo  number_format($converted['USDT']->bid,4) ?><b> <?php echo $geolocation->currency; ?></b></p></span>
                                    </div>    
                                </div>
                            </button>
                        </form>
                        @endif
                        <br>
                        @endif
                        
                        
                        
                        
                   </div>
                   
                   <form action="{{ $users[0]->success_url }}" method="post" id="transaction_form" style="display:none;">
                	    @csrf
                	    <input type="hidden" name="deposit_id" value="XXXXXXXXXXXXXXXXXXXXXXXXX0123">
                	    <input type="hidden" name="payment_method" value="crypto">
                	    <input type="hidden" name="order_id" value="{{ session('order_id') }}">
                	    <input type="hidden" name="currency_symbol" value="{{ $geolocation->currency }}">
                	    <input type="hidden" name="quantity" value="{{ session('payable_amount') }}">
                	    <input type="hidden" name="deposit_at" value="{{ date('Y-m-d H:i:s') }}">
                	    <input type="hidden" name="status" value="pending">
                	    <input type="hidden" name="customer_email" value="{{ session('customer_email') }}">
                	    <input type="submit" class="btn btn-success" value="Test Response">
                	</form>
                   
                </div>
            </div>
        </div>    
    </div>
</div>     
      
    <!--@if($users[0]->btc =='1')-->
    <!--<form action="/pay/step2" method="POST">-->
    <!--    <input type="hidden" name="currency" value="BTC">-->
    <!--    <input type="hidden" name="amount" value="{{ session('payable_amount') }}">-->
    <!--    <input type="hidden" name="order_id" value="{{ session('order_id') }}">-->
    <!--    <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">-->
    <!--    <input type="hidden" name="rate" value="{{ $converted['BTC']->bid }}">-->
    <!--    <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">-->
    <!--    <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">-->
    <!--    <button type="submit" class="btn">-->
    <!--        <div class="card card-success  animationClass" style="width: 18rem;">-->
    <!--            <div class="card-body">-->
    <!--                <div class="media position-relative">-->
    <!--                    <img src="{{ asset('payImages/bitcoin1.png') }}" height="auto" width="70" class="mr-3" alt="...">-->
    <!--                    <div class="media-body">-->
    <!--                        <h5 class="mt-1 text-warning">BTC Pay</h5>-->
    <!--                        <p class="mt-1 text-secondary">1<b> BTC</b> = <?php echo  number_format($converted['BTC']->bid,3) ?><b> <?php echo $geolocation->currency; ?></b></p>-->
                        
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </button>-->
    <!--</form>-->
    <!--@endif-->
    <!--<br>-->
    <!--@if($users[0]->ltc =='1')-->
    <!--<form action="/pay/step2" method="POST">-->
    <!--    <input type="hidden" name="currency" value="LTC">-->
    <!--    <input type="hidden" name="amount" value="{{ session('payable_amount') }}">-->
    <!--    <input type="hidden" name="order_id" value="{{ session('order_id') }}">-->
    <!--    <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">-->
    <!--    <input type="hidden" name="rate" value="{{ $converted['LTC']->bid }}">-->
    <!--    <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">-->
    <!--    <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">-->
    <!--    <button type="submit" class="btn">-->
    <!--        <div class="card card-success animationClass" style="width: 18rem;">-->
    <!--            <div class="card-body">-->
    <!--                <div class="media position-relative">-->
    <!--                    <img src="{{ asset('payImages/index.png') }}" height="auto" width="70" class="mr-3" alt="...">-->
    <!--                    <div class="media-body">-->
    <!--                        <h5 class="mt-1 text-primary">LTC Pay</h5>-->
    <!--                        <p class="mt-1 text-secondary">1<b> LTC</b> = <?php echo  number_format($converted['LTC']->bid,2) ?><b> <?php echo $geolocation->currency; ?></b></p>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </button>-->
    <!--</form>-->
    <!--@endif-->
    <!--<br>-->
    <!--@if($users[0]->xrp =='1') -->
    
    <!--    <form action="/pay/step2" method="POST">-->
    <!--        <input type="hidden" name="currency" value="XRP">-->
    <!--        <input type="hidden" name="amount" value="{{ session('payable_amount') }}">-->
    <!--        <input type="hidden" name="order_id" value="{{ session('order_id') }}">-->
    <!--        <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">-->
    <!--        <input type="hidden" name="rate" value="{{ $converted['XRP']->bid }}">-->
    <!--        <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">-->
    <!--        <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">-->
    <!--        <button type="submit" class="btn">-->
    <!--            <div class="card card-success animationClass" style="width: 18rem;">-->
    <!--                <div class="card-body">-->
    <!--                    <div class="media position-relative">-->
    <!--                        <img src="{{ asset('payImages/xrp.png') }}" height="auto" width="70" class="mr-3" alt="...">-->
    <!--                        <div class="media-body">-->
    <!--                            <h5 class="mt-1 text-info">XRP Pay</h5>-->
    <!--                            <p class="mt-1 text-secondary">1<b> XRP</b> = <?php echo  number_format($converted['XRP']->bid, 5) ?><b> <?php echo $geolocation->currency; ?></b></p>-->
                            
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </button>-->
    <!--    </form>-->
        <!--<a href="/pay/step2/XRP/100/{{ $geolocation->currency }}/{{ $converted['XRP']->bid }}/{{$users[0]->user_id}}" >-->
            
        <!--</a>-->
    <!--@endif-->
    <!--<br>-->
    
    <!--@if($users[0]->eth =='1')-->
    <!--<form action="/pay/step2" method="POST">-->
    <!--    <input type="hidden" name="currency" value="ETH">-->
    <!--    <input type="hidden" name="amount" value="{{ session('payable_amount') }}">-->
    <!--    <input type="hidden" name="order_id" value="{{ session('order_id') }}">-->
    <!--    <input type="hidden" name="cur_currency" value="{{ $geolocation->currency }}">-->
    <!--    <input type="hidden" name="rate" value="{{ $converted['ETH']->bid }}">-->
    <!--    <input type="hidden" name="merchant_id" value="{{$users[0]->user_id}}">-->
    <!--    <input type="hidden" name="success_url" value="{{ $users[0]->success_url }}">-->
    <!--    <button type="submit" class="btn"> -->
    <!--        <div class="card card-success   animationClass" style="width: 18rem;" >-->
    <!--            <div class="card-body">-->
    <!--                <div class="media position-relative">-->
    <!--                    <img src="{{ asset('payImages/eth.png') }}" height="auto" width="70" class="mr-3" alt="...">-->
    <!--                    <div class="media-body">-->
    <!--                        <h5 class="mt-1 text-primary">ETH pay</h5>-->
    <!--                        <p class="mt-1 text-secondary">1<b> ETH</b> = <?php echo  number_format($converted['ETH']->bid,3) ?><b> <?php echo $geolocation->currency; ?></b></p>-->
                            
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </button>-->
    <!--</form>-->
    <!--@endif-->
    <!--<br>-->

    <!--<div class="mb-3 mt-1">-->
    <!--    <img src="{{ asset('payImages/largeLogo.png') }}" height="auto" width="70" class="m-auto d-block"  >-->
    <!--</div>-->
@endsection