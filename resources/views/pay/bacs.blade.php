<style>
    body
    {
        background: rgb(225,104,24);
        background: linear-gradient(180deg, rgba(225,104,24,1) 0%, rgba(220,67,70,1) 53%, rgba(213,32,113,1) 100%);
        background-size:cover;
        background-origin: border-box;
        
      
    }
    .head
    {
        font-family: roboto !important;
    }
    .font
    {
        font-family:raleway !important;
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
    .text-f
    {
        padding: 7px 0;
    }
    .text-h
    {
        font-weight:600;
        font-size:18px;
    }
    .text-c
    {
        text-align: left;
    }
    .text-footer
    {
        font-size: 14px;
        color: #717171 !important; 
        font-weight: lighter !important;
        font-family: "Helvetica Neue", Helvetica, arial, sans-serif;;
        text-align: center;
    }
    .text-z
    {
        text-align: right;
    }
    .text-h span
    {
        font-weight: lighter !important;
       
    }
    .text-form
    {
       font-size: 14px;
        color: #717171 !important;
    }
    .label-color
    {
        font-size: 14px;
        color: #717171 !important;
        text-align:left;
    }
    .text-form .text-f .text-z
    {
       font-weight: bold; 
    }
    .text-form .text-f .text-c
    {
       font-weight: lighter;
       
    }
    @media only screen and (max-width: 992px) 
    {
        .payment_form .text-form .text-f .text-z
        {
            text-align: center !important;
        }
        .payment_form .text-form .text-f .text-c
        {
            text-align: center !important;
        }
    }
    .mar
    {
        margin-top: 31px;
    }
    .payment_form .btn_color
    {
        background-color:#44ce6f !important;
        color: white !important;
        font-weight: bolder;
        
    }

</style>

<style>
    .loader, .loader2 {
        position:fixed;
        padding:0;
        margin:0;
        
        top:0;
        left:0;
        
        width: 100%;
        height: 100%;
        background:rgba(255,255,255,0.5);
        z-index: 999;
        
        display: flex;
        flex-direction: column;
        align-content: center;
        align-items: center;
        justify-content: center;
    }
</style>
@extends('layouts.bacs-layout')

@section('content')

<div class="loader2" style="display: none">
  <h2>{{__('text.waitWhile')}}</h2>
  <br>
  <img src="{{ asset('payImages/25.gif') }}" alt="">
</div>
    
<div class="container-fluid font">
    <div class="pt-4 pb-5">
        <div class="row pt-4 pb-5">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                
               <div class=" bg-white payment_form font">
                   <div class="upper pt-3 pb-3 text-center">
                       <div class="row">
                            <div class="col-6 text-left pl-5 pt-3">
                               <p class="text-white text-h head text-uppercase">{{__('text.bacsMethod')}} <span>{{ strtoupper($geolocation->country) }}</span></p> 
                            </div> 
                            <div class="col-6 text-right pr-5  d-flex align-items-center justify-content-end">
                               <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2"> 
                            </div> 
                       </div>
                   </div>
                   @if($bank_info)
                   <div class="mt-4 mb-4 text-form">
                       
                        <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">{{__('text.acountName')}}</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->account_name : '' }}</p>
                           </div>
                       </div>
                        <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">{{__('text.accountType')}}</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->account_type : '' }}</p>
                           </div>
                       </div>
                        <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">{{__('text.bankName')}}</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->bank_name : '' }}</p>
                           </div>
                       </div>
                        <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">{{__('text.accountNumber')}}</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->account_number : '' }}</p>
                           </div>
                       </div>
                        <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">{{__('text.emailforbacs')}}</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->email : '' }}</p>
                           </div>
                       </div>
                       
                         <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">{{__('text.amount')}}</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? session('transaction.currency_symbol') .' '.   number_format(session('transaction.quantity')) : ''   }}</p>
                           </div>
                       </div>
                     
                   
                      @if(session('transaction.currency_symbol')=='ARS')
                        <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">DNI:</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->DNI : '' }}</p>
                           </div>
                       </div>
                       <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">CBU/CUV:</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->CBU_CUV : '' }}</p>
                           </div>
                       </div>
                       <div class="row text-f">
                           <div class=" col-lg-6 px-5 col-12 text-z">
                                <p class="">CUIT/CUIL/CDI:</p> 
                           </div>
                           <div class="col-lg-6 px-5 col-12 text-c">
                               <p class="pr-2">{{ isset($bank_info) ? $bank_info->CUIT : '' }}</p>
                           </div>
                       </div>
                      @elseif(session('transaction.currency_symbol')=='CLP')
                            <div class="row text-f">
                               <div class=" col-lg-6 px-5 col-12 text-z">
                                    <p class="">{{__('text.RUT')}}</p> 
                               </div>
                               <div class="col-lg-6 px-5 col-12 text-c">
                                   <p class="pr-2">{{ isset($bank_info) ? $bank_info->rut : '' }}</p>
                               </div>
                           </div>
                      @elseif(session('transaction.currency_symbol')=='SOL' or session('transaction.currency_symbol')=='PEN')   
                           <div class="row text-f">
                               <div class=" col-lg-6 px-5 col-12 text-z">
                                    <p class="">RUC:</p> 
                               </div>
                               <div class="col-lg-6 px-5 col-12 text-c">
                                   <p class="pr-2">{{ isset($bank_info) ? $bank_info->RUC : '' }}</p>
                               </div>
                           </div>
                           <div class="row text-f">
                               <div class=" col-lg-6 px-5 col-12 text-z">
                                    <p class="">CCI:</p> 
                               </div>
                               <div class="col-lg-6 px-5 col-12 text-c">
                                   <p class="pr-2">{{ isset($bank_info) ? $bank_info->CCI : '' }}</p>
                               </div>
                           </div>
                      @endif
                       
                   
                   
                   
                       <!--<div class="row text-f">-->
                       <!--    <div class=" col-lg-6 px-5 col-12 text-z">-->
                       <!--         <p class="">{{__('text.swift')}}</p> -->
                       <!--    </div>-->
                       <!--    <div class="col-lg-6 px-5 col-12 text-c">-->
                       <!--        <p class="pr-2">{{ isset($bank_info) ? $bank_info->rut : '' }}</p>-->
                       <!--    </div>-->
                       <!--</div>-->
                       <!--<div class="row text-f">-->
                       <!--    <div class=" col-lg-6 px-5 col-12 text-z">-->
                       <!--         <p class="">{{__('text.bankAddress')}}</p> -->
                       <!--    </div>-->
                       <!--    <div class="col-lg-6 px-5 col-12 text-c">-->
                       <!--        <p class="pr-2">{{ isset($bank_info) ? $bank_info->bank_name : '' }}</p>-->
                       <!--    </div>-->
                       <!--</div>-->
                       <!--<div class="row text-f">-->
                       <!--    <div class=" col-lg-6 px-5 col-12 text-z">-->
                       <!--         <p class="">{{__('text.minimumPaymentAmount')}}</p> -->
                       <!--    </div>-->
                       <!--    <div class="col-lg-6 px-5 col-12 text-c">-->
                       <!--        <p class="pr-2">{{ isset($bank_info) ? $bank_info->minimum_payment : '' }}</p>-->
                       <!--    </div>-->
                       <!--</div>-->
                       <!--<div class="row text-f">-->
                       <!--    <div class=" col-lg-6 px-5 col-12 text-z">-->
                       <!--         <p class="">{{__('text.bankTransferSlip')}}</p> -->
                       <!--    </div>-->
                       <!--    <div class="col-lg-6 px-5 col-12 text-c">-->
                       <!--        <p class="pr-2">{{ isset($bank_info) ? $bank_info->bank_address : '' }}</p>-->
                       <!--    </div>-->
                       <!--</div>-->
                       
                   </div>
                </div>
                <div class=" bg-white payment_form">
                   <div class="upper pt-2 pb-2 text-center">
                        <span class="text-white head">{{__('text.upload')}}</span>   
                   </div>
                   <div>
                       
                        <form action="/bacs-payment" method="post" enctype="multipart/form-data" id="bacs-form">
                            @csrf
                            <div class="container-fluid">
                                <div class="row mb-3">
                                    <div class="col-12 mb-2 mt-2 px-4 text-footer">{{ __('text.requestText', ['amount' => number_format(session('transaction.quantity')), 'currency' => session('transaction.currency_symbol')]) }} </div>
                                    <div class="offset-lg-1 offset-sm-0 col-sm-5">
                                        <div class="form-group">
                                            <label class="label-color">{{__('text.transactionID')}}</label>
                                            <input type="text" name="transaction_id" class="form-control" placeholder="TX ID" required>
                                        </div>
                                    </div>
                                    <div class=" col-lg-3 col-sm-5">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-4 col-6">
                                                    <label for="exampleInputFile" class="label-color">{{__('text.receipt')}}</label><br> 
                                                    <div class="custom-file d-none">
                                                        <input type="file" name="receipt" class="custom-file-input d-none" id="exampleInputFile" value="{{__('text.chooseFile')}}" >
                                                        <input type="file" name="receipt2" class="custom-file-input d-none" id="exampleInputFile2" value="{{__('text.chooseFile')}}" >
                                                        <label class="custom-file-label" for="exampleInputFile">{{__('text.chooseFile')}}</label>
                                                    </div>
                                                    <img src="{{ asset('payImages/upload.png') }}" title="Upload Receipt" class="img-fluid" style="border-radius:50%" height="45" width="45" id="upload">
                                                </div> 
                                                <div class="col-lg-6 col-md-6 col-sm-8 col-6 d-none">
                                                    <label  class="label-color">{{__('data.customerIdd')}}</label><br>
                                                    <img src="{{ asset('payImages/uploadd.png') }}" title="Upload Customer Id" class="img-fluid" style="border-radius:50%" height="45" width="45" id="upload2">
                                                    <span class="p-2 d-md-none">OR</span>
                                                    <img src="{{ asset('payImages/capture.png') }}" title="Capture" class="img-fluid d-md-none" style="border-radius:50%" height="45" width="45" id="capture">
                                                </div> 
                                            </div>
                                        </div>
                                        <!--<div class="form-group">-->
                                        <!--    <div class=" d-flex justify-content-around">-->
                                        <!--        <label for="exampleInputFile" class="label-color">{{__('text.receipt')}}</label>&nbsp;&nbsp;&nbsp;<label  class="label-color">{{__('data.customerIdd')}}</label>-->
                                        <!--    </div>-->
                                        <!--    <div class="input-group d-flex justify-content-around">-->
                                        <!--        <div class="custom-file d-none">-->
                                        <!--            <input type="file" name="receipt" class="custom-file-input d-none" id="exampleInputFile" value="{{__('text.chooseFile')}}" >-->
                                        <!--            <input type="file" name="receipt2" class="custom-file-input d-none" id="exampleInputFile2" value="{{__('text.chooseFile')}}" >-->
                                        <!--            <label class="custom-file-label" for="exampleInputFile">{{__('text.chooseFile')}}</label>-->
                                        <!--        </div>-->
                                        <!--        <img src="{{ asset('payImages/upload.png') }}" title="Upload Receipt" class="img-fluid" style="border-radius:50%" height="45" width="45" id="upload">-->
                                        <!--       &nbsp;&nbsp;&nbsp;-->
                                        <!--        <img src="{{ asset('payImages/uploadd.png') }}" title="Upload Customer Id" class="img-fluid" style="border-radius:50%" height="45" width="45" id="upload2">-->
                                                
                                        <!--        <span class="p-2 d-md-none">OR</span>-->
                                                
                                        <!--        <img src="{{ asset('payImages/capture.png') }}" title="Capture" class="img-fluid d-md-none" style="border-radius:50%" height="45" width="45" id="capture">-->
                                                
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                    <div class="col-sm-2 mar">
                                        <div class="input-group justify-content-end">
                                            <button type="submit" class="btn btn_color btn-block float-right mb-3" >{{__('text.submit')}}</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 offset-md-3">
                                        <img id="preview" class="img-fluid mb-4" width="300" height="auto">
                                        <img id="preview2" class="img-fluid mb-4" width="300" height="auto">
                                    </div>
                                </div>    
                            </div>
                        </form>
                   </div>
                    @else
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                 <div class="col-12">
                                     <h4 class="text-center">{{__('text.submit')}}</h4>
                                 </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>

@endsection

@section('js')

<script>
    $('#bacs-form').submit(function(){
        $('.loader2').show();
    });
    
    $('#capture').click(function(){
        $("#exampleInputFile").attr('accept', 'image/*');
        $("#exampleInputFile").attr('capture', 'environment');
        $("#exampleInputFile").click();
    });
    
    $('#upload').click(function(){
        $("#exampleInputFile").removeAttr('accept');
        $("#exampleInputFile").removeAttr('capture');
        $("#exampleInputFile").click();
    });
    
     $('#upload2').click(function(){
        $("#exampleInputFile2").removeAttr('accept');
        $("#exampleInputFile2").removeAttr('capture');
        $("#exampleInputFile2").click();
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#preview').attr('src', e.target.result);
            }
        
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#preview2').attr('src', e.target.result);
            }
        
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    
    $("#exampleInputFile").change(function() {
        readURL(this);
    });
    
     $("#exampleInputFile2").change(function() {
        readURL2(this);
    });

    
    
</script>

@endsection