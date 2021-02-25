
@extends('layouts.invoice')
@section('css')
<style>
    body, h1,h2,h3,h4,h5,h6, p, span{
        font-family: 'Montserrat', sans-serif !important;
    }
    .upper
    {
        /*background: rgb(254,99,7);*/
        border-radius:5px;
        height:70px;

    }
    .card-header{
                background: linear-gradient(90deg, rgba(254,99,7,1) 0%, rgba(246,57,61,1) 50%, rgba(239,19,107,1) 100%);
    }    
   .btn-checkbox{
            font-size: 15px;
    }
    .pay-avail{
        font-size:19px;
    }
    .card-button .btn-secondary.active::before {
        font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f00c";
    }
    .card-button .btn-secondary::before {
        font-family: "Font Awesome 5 Free"; font-weight: 900; content: "\f00d";
    }
    
    label:not(.form-check-label):not(.custom-file-label) {
    font-weight: 700;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    content: "\f00c";
    color: #000;
    }
    
    
    .card-button .btn-secondary{
            display: flex;
    justify-content: center;
    align-items: center;
        border-radius: 50%;
    height: 30px;
    width: 30px;
    /* position: absolute; */
    /* top: 50%; */
    /* right: 0; */
    /* left: 0; */
    /* width: 100px; */
    /* height: 100px; */
    /* margin: 0 auto; */
    background-color: #fff;
    /* transform: translateY(-50%); */
    cursor: pointer;
    transition: 0.2s ease transform, 0.2s ease background-color, 0.2s ease box-shadow;
    overflow: hidden;
    z-index: 1;
    border-color:#f72414;
    border-width:3px;
    }
    .btn-secondary:not(:disabled):not(.disabled).active, .btn-secondary:not(:disabled):not(.disabled):active{
        background-color:#07d410;
        border:none;
    }
    .customer_data{
        font-size:13px;
        
    }
    .bg-pk{
        background: linear-gradient(90deg, #ff2368 -19%, #ff6b1f 47%);
        color: #fff;
    }
    .bg-pk h5{
        margin:0;
    }
    .invoice_data{
        font-size:13px;
    }
    .table{
        font-size:13px;
    }
    .checkbox{
        opacity:0;
        position:absolute;
    }
    .card:hover{
        box-shadow:none;
    }

</style>
@endsection
@section('content') 
    <div class="card rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <img src="{{ asset('payImages/logoz.png') }}" height="auto" width="150"  class="py-3">
            <div class="w-100 float-right">
                <h4 class="text-white py-4 float-right">
                    <b>{{__('data.invoice')}}</b>
                </h4>
                    
            </div>
        </div>
        <div class="card-body p-0">
            <div class="p-3">
                <div class="container-fluid ">
                    <div class="row">
                        <div class="col-12 col-md-12 ">
                            <div class="text-left text-dark">
                                <h6 class="ml-3"><strong>{{__('data.invoicedTo')}}</strong></h6>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                                <address class="text-left ml-3 text-secondary ">
                                    
                                        <span style="text-transform:capitalize">{{ $customer->name }}</span><br>
                                  
                                        {{ $customer->email }}<br>
                                    
                                        {{ $customer->contact }}<br>
                                    
                                        {{ $customer->address }} , <span style="text-transform:capitalize">{{ $customer->country }}</span><br>
                                    
                                </address>
                        </div>
                        
                        <div class="col-12 col-md-12 ">
                            <div class="text-left text-dark">
                                <h6 class="ml-3"><strong>{{__('data.date')}}</strong></h6>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                                <address class="text-left ml-3 text-secondary ">
                                        {{ date('d-m-Y') }}<br>
                                </address>
                        </div>
                        <div class="col-12 col-md-12 ">
                            <hr>
                        </div>
                        <div class="col-12 col-md-12 mt-4">
                            <div class=" text-left d-flex align-items-center p-2  rounded-top bg-pk">
                                <h5><b>{{__('data.productDetail')}}:</b></h5>
                            </div>
                        </div>
                        
                        @if(!empty($products))
                        <div class="col-12 col-md-12 table-responsive">
                            <table class="table  text-center table-sm-responsive    mb-0">
                                <thead class="">
                                    <tr class="">
                                        <th class="text-center text-nowrap ">#</th>
                                        <th class="text-center text-nowrap ">{{__('data.productName')}}</th>
                                        <th class="text-center text-nowrap ">{{__('data.quantity')}}</th>
                                        <th class="text-center text-nowrap ">{{__('data.pricePerPiece')}}</th>
                                        <th class="text-center text-nowrap ">{{__('data.amount')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $product->product_name }}</td>
                                            <td class="text-center">{{ $product->quantity }}</td>
                                            <td class="text-center">{{ $product->price }} {{ $product->currency }}</td>
                                            <td class="text-center">{{ number_format($product->price * $product->quantity,2) }} {{ $product->currency }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="">
                                    <tr class="">
                                        <th colspan="4" class="text-right">{{__('data.totalAmount')}}</th>
                                        <th class="text-right">{{ session('transaction.quantity') }} {{ strtoupper($currency) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endif
                        
                        
                        <div class="col-12 col-md-12">
                            <hr class="mt-5">
                            
                            <h5>
                                @if($customer->customer_wallet->$currency <= session('transaction.quantity')) 
                                <h5 class="text-center text-danger">
                                        {{__('data.AIYWI')}}  <b>{{ $customer->customer_wallet->$currency }} {{ strtoupper($currency) }}</b>
                                </h5>
                                    <p class="text-center text-danger"> {{__('data.YDHEBIYW')}}</p>
                                @else
                                <h5 class="text-center text-success">
                                        {{__('data.AIYWI')}}  <b>{{ $customer->customer_wallet->$currency }} {{ strtoupper($currency) }}</b>
                                </h5>
                                @endif
                            </h5>
                        </div>
                                  
                                  

                                
                        
                    </div> 
                </div>

                <div class="text-center">
                    <p><b>{{__('data.TFUQP')}}</b></p>
                    <form method="post" action="https://dev.quikipay.com/pay/quikipay/complete" class="form_padding">
                    	<input type="hidden" name="access_token" value="{{ $customer->accessToken }}">
                    	<input type="hidden" name="order_id" value="{{ session('transaction.order_id') }}">
                    	<input type="hidden" name="currency_symbol" value="{{ session('transaction.currency_symbol') }}">
                    	<input type="hidden" name="amount" value="{{ session('transaction.quantity') }}">
    
                        <button class="btn bg-success" type="submit" @if($customer->customer_wallet->$currency <= session('transaction.quantity')) disabled title="You don't have enough balance in your wallet" @endif >Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

   
@endsection