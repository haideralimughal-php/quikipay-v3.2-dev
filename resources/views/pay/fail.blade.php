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
        color: #ff0101;
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
                    <img src="{{ asset('payImages/Group60.png') }}" height="auto" width="50"  class="pt-2 pb-2 img-fluid mt-2 mb-2">
                   <h4 class="text-center text-s font"> {{__('text.error')}}!</h4>
                   <div class="mx-5 my-4  box">
                        <div class="payment_buttons font">
                            <p class="text-center btn payment_btn btn-block btn-lg text-f"> {{__('text.errorText')}}</p> 
                        </div>
                    </div>
                   <!--<a href="QRcode.html" class="btn btn_color mb-3 font"><i class="fa fa-arrow-left"></i> {{__('text.backBtnText')}}</a>-->
                   <br>
                </div>
            </div>
        </div>    
    </div>
</div>
<!--<div class="card QRCodeAnimationClass m-auto d-block    pt-2  box-shadow QR-card"  >-->
<!--            <div class=" mt-1">-->
<!--              <img src="{{ asset('payImages/largeLogo.png') }}" height="auto" width="70" class="m-auto d-block"  >-->
<!--              <hr>-->
<!--            </div>-->

<!--          <div class="card-body" style="padding: 1.25rem;padding-top:0; ">-->
<!--            <h5 class="card-title text-center text-danger "> <i class="fa fa-close fa-3x"></i></h5>-->
<!--            <h2 class="card-title text-center text-danger "> {{__('text.error')}}!</h2>-->
          
           
             
<!--            <div class="card-text">-->
<!--              <div class="row">-->
<!--                <div class="col"><p class="text-center text-danger"> {{__('text.errorText')}}!</p></div>-->
               
<!--              </div>-->
           
              
              
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--            <div class="QR-card mt-5">  -->
<!--            <a href="QRcode.html" class="btn btn-primary "><i class="fa fa-arrow-left"></i> {{__('text.backBtnText')}}</a>-->
<!--              </div>-->
@endsection
