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
                	<form action="https://new.quickex.cl/order-received/bacs/" method="get" id="transaction_form">
                	    @csrf
                	    <input type="hidden" name="tx_id" value="123123123">
                	    <input type="hidden" name="payment_method" value="fiat">
                	    <input type="hidden" name="order_id" value="358983">
                	    <input type="hidden" name="currency_symbol" value="CLP">
                	    <input type="hidden" name="quantity" value="10000.0">
                	    <input type="hidden" name="deposit_at" value="2020-08-11 00:00:00">
                	    <input type="hidden" name="status" value="completed">
                	    <input type="hidden" name="customer_email" value="ccontrerasl@gmail.com">
                	    <input type="submit" class="btn btn_color mb-3" value="{{__('text.backBtnText')}}">
                	</form>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection

@section('js')

    <script>
        // $(".lang").hide();
        // $(document).ready(function(){   
        //     console.log(@json(session()->all()));
        //     window.setTimeout(function(){
        //         console.log('asdf');
        //         // Move to a new location or you can do something else
        //         // window.location.href = "https://www.google.co.in";
        //         $("#transaction_form").submit();
        
        //     }, 30000);

        // });
    </script>

@endsection