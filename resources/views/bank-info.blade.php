{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bank Information</h1>
@stop

@section('content')
    <!--<p>Welcome to this beautiful admin panel.</p>-->
    
    <form class="row" action="/settings/bank-info" method="post" name="myForm" id="with-form">
    @csrf 
        <div class="col-12">
            <div class="card card-outline card-danger ">
                <div class="card-header pt-3 pb-3" >
                    <div class="row">
                    <div class="col-12 mb-3">
                        <h6><b>Select currency:</b></h6>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-md-2 offset-md-1">
                        <label class="form-check-label">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="currency1" name="currency" value="usd" {{ session()->has('bank_info') ? (session('bank_info.currency') == 'usd' ? 'checked' : '') : '' }} >
                                <label for="currency1" class="custom-control-label">PANAMA</label>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 offset-md-1">
                        <label class="form-check-label">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="currency2" name="currency" value="ars" {{ session()->has('bank_info') ? (session('bank_info.currency') == 'ars' ? 'checked' : '') : '' }} >
                                <label for="currency2" class="custom-control-label">ARS</label>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 offset-md-1">
                        <label class="form-check-label">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="currency3" name="currency" value="clp" {{ session()->has('bank_info') ? (session('bank_info.currency') == 'clp' ? 'checked' : '') : '' }}>
                                <label for="currency3" class="custom-control-label">CLP</label>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 offset-md-1">
                        <label class="form-check-label">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="currency4" name="currency" value="sol"{{ session()->has('bank_info') ? (session('bank_info.currency') == 'sol' ? 'checked' : '') : '' }} >
                                <label for="currency4" class="custom-control-label">SOL</label>
                            </div>
                        </label>
                    </div>
                   
                </div>
                <div class="card-body">
                    <div class="row" id="bank_form">
                    <div class="form-group col-md-6">
                        <label>{{__('text.acountName')}}</label>
                        <input type="text" class="form-control"  name="account_name" required value="{{ session()->has('bank_info') ? session('bank_info.account_name') : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{__('text.accountType')}}</label>
                        <input type="text" class="form-control"  name="account_type"  required value="{{ session()->has('bank_info') ? session('bank_info.account_type') : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{__('text.accountNumber')}}</label>
                        <input type="text" class="form-control"  name="account_number" required value="{{ session()->has('bank_info') ? session('bank_info.account_number') : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{__('text.bankName')}}</label>
                        <input type="text" class="form-control"  name="bank_name" required value="{{ session()->has('bank_info') ? session('bank_info.bank_name') : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{__('text.emailforbacs')}}</label>
                        <input type="text" class="form-control"  name="email" required value="{{ session()->has('bank_info') ? session('bank_info.email') : '' }}">
                    </div>
                    
                    <div class="form-group col-md-6 ars">
                        <label>DNI:</label>
                        <input type="text" class="form-control"  name="DNI" value="{{ session()->has('bank_info') ? session('bank_info.DNI') : '' }}">
                    </div> 
                    <div class="form-group col-md-6 ars">
                        <label>CBU/CUV:</label>
                        <input type="text" class="form-control"  name="CBU_CUV" value="{{ session()->has('bank_info') ? session('bank_info.CBU_CUV') : '' }}">
                    </div>
                    <div class="form-group col-md-6 ars">
                        <label>CUIT/CUIL/CDI:</label>
                        <input type="text" class="form-control"  name="CUIT" value="{{ session()->has('bank_info') ? session('bank_info.CUIT') : '' }}">
                    </div>
                    <div class="form-group col-md-6 clp">
                        <label>{{__('text.RUT')}}</label>
                        <input type="text" class="form-control"  name="rut" value="{{ session()->has('bank_info') ? session('bank_info.rut') : '' }}">
                    </div>
                    <div class="form-group col-md-6 sol">
                        <label>RUC:</label>
                        <input type="text" class="form-control"  name="RUC" value="{{ session()->has('bank_info') ? session('bank_info.RUC') : '' }}">
                    </div>
                    <div class="form-group col-md-6 sol">
                        <label>CCI:</label>
                        <input type="text" class="form-control"  name="CCI" value="{{ session()->has('bank_info') ? session('bank_info.CCI') : '' }}">
                    </div>
                    
                     <div class="form-group col-md-6 "style="display:none;" >
                        <label>Swift code:</label>
                        <input type="text" class="form-control"  name="swift_code" value="{{ session()->has('bank_info') ? session('bank_info.swift_code') : '0' }}">
                    </div>
                    <div class="form-group col-md-6 "style="display:none;" >
                        <label>Minimum Payment Account:</label>
                        <input type="text" class="form-control"  name="minimum_payment" value="{{ session()->has('bank_info') ? session('bank_info.minimum_payment') : '0' }}">
                    </div>
                    <div class="form-group col-md-12 " style="display:none;" >
                        <label>Bank Address:</label>
                        <textarea class="form-control"  name="bank_address">{{ session()->has('bank_info') ? session('bank_info.bank_address') : '0' }}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="submit" value="Submit" class="btn btn-success float-right">
                    </div>
                </div>
              </div>
            </div>        
        </div>
        </div>
    </form>
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
    
    

    $(document).ready(function(){
          $("#bank_form").hide();
            $(".ars").hide();
            $(".clp").hide();
            $(".sol").hide();
        $('input[type=radio][name=currency]').change(function() {
          
            // $(".card-body").removeAttr('hidden');
            var radioValue = $("input[name='currency']:checked").val();
            var bank_info;
            switch (radioValue){
                case 'usd':
                    bank_info = @json( auth()->user()->bankInfo()->where('currency', 'usd')->first() ? auth()->user()->bankInfo()->where('currency', 'usd')->first()->toArray() : '');
                        $("#bank_form").show();
                        $(".clp").hide();
                        $(".sol").hide();
                        $(".ars").hide();
                    break;
                case 'ars':
                        bank_info = @json( auth()->user()->bankInfo()->where('currency', 'ars')->first() ? auth()->user()->bankInfo()->where('currency', 'ars')->first()->toArray() : '');
                        $("#bank_form").show();
                        $(".ars").show();
                        $(".clp").hide();
                        $(".sol").hide();
                     break;
                case 'clp':
                        bank_info = @json( auth()->user()->bankInfo()->where('currency', 'clp')->first() ? auth()->user()->bankInfo()->where('currency', 'clp')->first()->toArray() : '');
                        $("#bank_form").show();
                        $(".clp").show();
                        $(".ars").hide();
                        $(".sol").hide();
                    break;
                case 'sol':
                        bank_info = @json( auth()->user()->bankInfo()->where('currency', 'sol')->first() ? auth()->user()->bankInfo()->where('currency', 'sol')->first()->toArray() : '');
                        $("#bank_form").show();
                        $(".sol").show();
                        $(".ars").hide();
                        $(".clp").hide();
                    break;
            }
            
          //  console.log(bank_info);
            
            $('input[name="account_name"]').val(bank_info.account_name)
            $('input[name="account_type"]').val(bank_info.account_type)
            $('input[name="account_number"]').val(bank_info.account_number)
            $('input[name="email"]').val(bank_info.email)
            $('input[name="bank_name"]').val(bank_info.bank_name)
            
            if(radioValue=="ars"){
                 $('input[name="DNI"]').val(bank_info.DNI)
                 $('input[name="CBU_CUV"]').val(bank_info.CBU_CUV)
                 $('input[name="CUIT"]').val(bank_info.CUIT)
            }
            else if(radioValue=="clp"){
               $('input[name="rut"]').val(bank_info.rut)
            }
            else if(radioValue=="sol"){
               $('input[name="RUC"]').val(bank_info.RUC) 
               $('input[name="CCI"]').val(bank_info.CCI) 
            }
            
            $('input[name="swift_code"]').val(bank_info.swift_code)
            $('input[name="minimum_payment"]').val(bank_info.minimum_payment)
            $('textarea[name="bank_address"]').val(bank_info.bank_address)
            
        })
    });
    

     </script>
@stop