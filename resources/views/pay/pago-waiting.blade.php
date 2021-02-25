@extends('layouts.pay')

@section('content')
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
        color: #787b7a;
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
        background-color:#797979 !important;
        color: white !important;
        font-weight: bolder;
        
    }
    .head
    {
        font-family: roboto !important;
    }
    .font
    {
        font-family: raleway;
    }
</style>
<div class="container-fluid">
    <div class="pt-2 pb-4">
        <div class="row pt-2 pb-4">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                
               <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                   </div>
                    <img src="{{ asset('payImages/pending-01.png') }}" height="auto" width="50"  class="pt-2 pb-2 img-fluid mt-2 mb-2">
                    <h4 class="text-center text-s font"> {{__('text.pending')}}!</h4>
                   <div class="mx-5 my-4  box">
                        <div class="payment_buttons font">
                            <p class="text-center btn payment_btn btn-block btn-lg text-f"> {{__('text.pendingStatus')}}</p> 
                        </div>
                    </div>
                   <br>
                </div>
            </div>
        </div>    
    </div>
</div>

@endsection

