{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.icheck-bootstrap', true)
@section('plugins.bootstrapSwitch', true)
@section('content_header')
    <h1>{{__('data.convertCurrencies')}}</h1>
@stop

@section('content')
    <!--<p>Welcome to this beautiful admin panel.</p>-->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Success!</h5>
            @foreach(session('success') as $msg)
                {{ $msg }} <br>
            @endforeach
        </div>
    @endif
    
    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Fail!</h5>
            @foreach(session('errors') as $msg)
                {{ $msg }} <br>
            @endforeach
        </div>
    @endif
    
   
    <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><b>USD</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-info text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : number_format(auth()->user()->wallet->usd, 2) }}</h5>  </span>
                <!--<span class="info-box-number">-->
                <!--    {{ auth()->user()->wallet->usd }}-->
                <!--</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><b>ARS</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-danger text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('ars'), 2) : number_format(auth()->user()->wallet->ars, 2) }}</h5>  </span>
                <span class="text-danger" style="text-align:end"> = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('ars') / $ars, 2) : number_format(auth()->user()->wallet->ars / $ars, 2) }} USD</span>
                <!--<span class="info-box-number">{{ auth()->user()->wallet->ars }}</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><b>CLP</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-success text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('clp'), 2) : number_format(auth()->user()->wallet->clp, 2) }} </h5></span>
                <span class="text-success" style="text-align:end"> = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('clp') / $clp, 2) : number_format(auth()->user()->wallet->clp / $clp, 2) }} USD</span>
                <!--<span class="info-box-number">{{ auth()->user()->wallet->clp }}</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><b>SOL</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-primary text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('sol'), 2) : number_format(auth()->user()->wallet->sol, 2) }} </h5></span>
                <span class="text-primary" style="text-align:end"> = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('sol') / $pen, 2) : number_format(auth()->user()->wallet->sol / $pen, 2) }} USD</span>
                <!--<span class="info-box-number">{{ auth()->user()->wallet->sol }}</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!--From  local Currencies to USD-->
    <div class="row">
        <div class="col-12 col-md-6">
            <!--<form action="/convert-currency" method="POST" onsubmit='return confirm("{{ __("data.WAW", [
                "sol" => round(auth()->user()->wallet->sol, 3),
                "sol_rate" => $pen,
                "sol_converted" => round(auth()->user()->wallet->sol / $pen, 3),
                "clp" => round(auth()->user()->wallet->clp, 3),
                "clp_rate" => $clp,
                "clp_converted" => round(auth()->user()->wallet->clp / $clp, 3),
                "ars" => round(auth()->user()->wallet->ars, 3),
                "ars_rate" => $ars,
                "ars_converted" => round(auth()->user()->wallet->ars / $ars, 3),
                "total" => round(auth()->user()->wallet->clp / $clp, 3) + round(auth()->user()->wallet->ars / $ars, 3) + round(auth()->user()->wallet->sol / $pen, 3)
            ]) }}")'>
                @csrf
                
              <div class="form-group">
                  
                <label for="exampleInputEmail1">{{__('data.WCCU')}}</label>
              </div>
              <button type="submit" class="btn btn-primary">{{__('data.convert')}}</button>
            </form>-->
            <div class="">
            <!-- DIRECT CHAT SUCCESS -->
            <div class="card card-info ">
              <div class="card-header">
                <h3 class="card-title text-white">{{__('data.convertCurrencyToUSD')}}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body px-3">
               <form action="/convert-currency" method="POST"  onsubmit='return confirm("{{ __("data.WAW", [
                
                "ars" => round(auth()->user()->wallet->ars, 3),
                "ars_rate" => $ars,
                "ars_converted" => round(auth()->user()->wallet->ars / $ars, 3),
                
                "clp" => round(auth()->user()->wallet->clp, 3),
                "clp_rate" => $clp,
                "clp_converted" => round(auth()->user()->wallet->clp / $clp, 3),
                
                "sol" => round(auth()->user()->wallet->sol, 3),
                "sol_rate" => $pen,
                "sol_converted" => round(auth()->user()->wallet->sol / $pen, 3),
                
                "total" => round(auth()->user()->wallet->clp / $clp, 3) + round(auth()->user()->wallet->ars / $ars, 3) + round(auth()->user()->wallet->sol / $pen, 3)
                
                ]) }}")'>
                @csrf
                <input type="hidden" value="{{ $ars }}" name="ars_rate"/>
                <input type="hidden" value="{{ $clp }}" name="clp_rate"/>
                <input type="hidden" value="{{ $pen }}" name="sol_rate"/>
              <div class="form-group">
                <h5 class="text-secondary">{{__('data.WCCU')}}</h5>
              </div>
              
                <!-- Minimal style -->
                <div class="row">
                  <div class="col-sm-12">
                    <!-- checkbox -->
                    <div class="form-group  clearfix pt-3" id="checkboxes">
                      <div class="icheck-danger checkboxPrimary1 d-block">
                        <input type="checkbox" name="ars_check" id="checkboxPrimary1"  onchange="checkedOrNot()" >
                        <label class="d-inline-flex" for="checkboxPrimary1">
                        <span class="text-danger font-weight-custom">ARS</span>
                            <div class="input-group AmountboxPrimary1 mb-3">
                                <input type="number"
                                    class="ml-3 form-control" 
                                    step="0.01" 
                                    name="ars_amount" 
                                    max="{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('ars'), 2) : number_format(auth()->user()->wallet->ars, 2) }}"
                                    min="0" 
                                    id="textboxPrimary1"
                                    required 
                                    disabled
                                    
                                />
                                  <div class="input-group-append">
                                    <span class="input-group-text" >
                                        <span >max. {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('ars'), 2) : number_format(auth()->user()->wallet->ars, 2) }}</span>
                                    </span>
                                  </div>
                            </div>
                        </label>
                      </div>
                      <div class="icheck-success checkboxPrimary2 d-block">
                        <input type="checkbox" name="clp_check" id="checkboxPrimary2"   onchange="checkedOrNot()" >
                        <label class="d-inline-flex" for="checkboxPrimary2">
                        <span class="text-success font-weight-custom">CLP</span>
                        <div class="input-group AmountboxPrimary2 mb-3">
                                <input type="number"
                                    class="ml-3 form-control" 
                                    step="0.01" 
                                    name="clp_amount" 
                                    max="{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('clp'), 2) : number_format(auth()->user()->wallet->clp, 2) }}"
                                    min="0" 
                                    id="textboxPrimary2"
                                    required 
                                    disabled
                                />
                                  <div class="input-group-append">
                                    <span class="input-group-text" >
                                        <span>max. {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('clp'), 2) : number_format(auth()->user()->wallet->clp, 2) }}</span>
                                    </span>
                                  </div>
                            </div>
                        </label>
                      </div>
                      <div class="icheck-primary checkboxPrimary3 d-block">
                        <input type="checkbox" name="sol_check"  id="checkboxPrimary3" onchange="checkedOrNot()"  >
                        <label class="d-inline-flex" for="checkboxPrimary3">
                        <span class="text-primary font-weight-custom">SOL</span>
                        <div class="input-group AmountboxPrimary3 mb-3">
                                <input type="number"
                                    class="ml-3 form-control" 
                                    step="0.01" 
                                    name="sol_amount" 
                                    max="{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('sol'), 2) : number_format(auth()->user()->wallet->sol, 2) }}"
                                    min="0" 
                                    id="textboxPrimary3"
                                    required 
                                    disabled
                                />
                                  <div class="input-group-append">
                                    <span class="input-group-text" >
                                        <span >max. {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('sol'), 2) : number_format(auth()->user()->wallet->sol, 2) }}</span>
                                    </span>
                                  </div>
                            </div>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
              <a  onclick="check_checkboxes()" class="btn btn-info text-white float-right mb-3 convertBtn">{{__('data.convert')}}</a>
              <button type="button" class="btn btn-info btn-sm d-none" data-toggle="modal" data-target="#myModal" id="modal"></button>

              <button type="submit"  id="submit" onclick="converting_amounts()" class="btn btn-primary d-none">{{__('data.convert')}}</button>
            </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!--/.direct-chat -->
          </div>
          
             
            
        </div>
        <div class="col-12 col-md-6">
             @if(Session::has('message'))
                    <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif
            <div class="">
            <!-- DIRECT CHAT SUCCESS -->
            <div class="card card-info ">
              <div class="card-header">
                <h3 class="card-title text-white">{{__('data.convertCurrencies')}}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body px-3">
                <form action="convert_currency_auto_setting_update" method="post">
                    @csrf
                      <h5 class="text-secondary">{{__('data.selectCurrency')}}</h5>
                    <div class="d-flex mt-3 mb-4">

                        <input type="checkbox" class="d-block" name="arsToUsd" {{ $data['arsToUsd'] ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        <span class="mx-3 text-danger">{{__('data.ARStoUSD')}}</span>
                    </div>
                    <div class="d-flex mt-4 pt-2">
                        <input type="checkbox" class="d-block" name="clpToUsd" {{ $data['clpToUsd'] ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        <span class="mx-3 text-success">{{__('data.CLPtoUSD')}}</span>
                    </div>
                    <div class="d-flex mt-4 pt-2">
                        <input type="checkbox" class="d-block" name="solToUsd" {{ $data['solToUsd'] ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        <span class="mx-3 text-info">{{__('data.SOLtoUSD')}}</span>
                    </div>
                    <hr class="mt-5 pt-3">
                    <button class="btn btn-info float-right mb-3" type="submit">{{__('data.update')}}</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!--/.direct-chat -->
          </div>
        </div>
        
        <!--From USD to local Currencies-->
        <div class="col-12 col-md-12 ">
             @if(Session::has('messageForUstToFiat'))
                    <p class="alert alert-success">{{ Session::get('messageForUstToFiat') }}</p>
                @endif
                 @if(Session::has('errormessageForUstToFiat'))
                    <p class="alert alert-danger">{{ Session::get('errormessageForUstToFiat') }}</p>
                @endif
                
            <div class="card card-info  ">
              <div class="card-header">
                <h3 class="card-title text-white">{{__('data.convertCurrencyFromUSD')}}</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body px-3">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <form action="/convert-currency-fiatToUSD" method="POST">
                @csrf
                    <input type="hidden" value="{{ $ars }}" name="ars_rate"/>
                    <input type="hidden" value="{{ $clp }}" name="clp_rate"/>
                    <input type="hidden" value="{{ $pen }}" name="sol_rate"/>
                    <input type="hidden" value="0" name="total_usd_remaining" id="total_usd_remaining"/>
                    <div class="form-group">
                        <h5 class="text-secondary">{{__('data.WCFU')}}</h5>
                    </div>
                   
                    <!-- Minimal style -->
                    <div class="row">
                      <div class="col-sm-12">
                        <!-- checkbox -->
                        <div class="form-group  clearfix pt-3" id="LocaltoUSDCheckboxes">
                          <div class="icheck-danger checkboxLocaltoUSD1 d-block">
                            <input type="checkbox" name="ars_check" id="checkboxLocalToUSD1"   onchange="checkedOrNot1(this,1)" >
                            <label class="d-inline-flex" for="checkboxLocalToUSD1">
                            <span class="text-danger font-weight-custom">ARS</span>
                                <div class="input-group AmountboxLocalToUSD1 mb-3">
                                    <input type="text"
                                        class="ml-3 form-control" 
                                          onkeypress="return isNumberKey(event)"
                                        name="ars_amount" 
                                        min="{{ $ars }}" 
                                        value="0" 
                                        id="textboxLocalToUSD1"
                                        required 
                                        onblur="getValues()"
                                        disabled
                                    />
                                </div>
                            </label>
                          </div>
                          <div class="icheck-success checkboxLocalToUSD2 d-block">
                            <input type="checkbox" name="clp_check" id="checkboxLocalToUSD2"   onchange="checkedOrNot1(this,2)" >
                            <label class="d-inline-flex" for="checkboxLocalToUSD2">
                            <span class="text-success font-weight-custom">CLP</span>
                            <div class="input-group AmountboxLocalToUSD2 mb-3 ">
                                    <input type="text"
                                        class="ml-3 form-control" 
                                         onkeypress="return isNumberKey(event)"
                                        name="clp_amount" 
                                        min="{{ $clp }}" 
                                        value="0"
                                        id="textboxLocalToUSD2"
                                        required 
                                        disabled
                                        onblur="getValues()"
                                    />
                                </div>
                            </label>
                          </div>
                          <div class="icheck-primary checkboxLocalToUSD3 d-block">
                            <input type="checkbox" name="sol_check"  id="checkboxLocalToUSD3" onchange="checkedOrNot1(this,3)"  >
                            <label class="d-inline-flex" for="checkboxLocalToUSD3">
                            <span class="text-primary font-weight-custom">SOL</span>
                            <div class="input-group AmountboxLocalToUSD3 mb-3">
                                    <input type="text"
                                        class="ml-3 form-control " 
                                        
                                        name="sol_amount" 
                                        min="{{ $pen }}" 
                                        value="0"
                                        id="textboxLocalToUSD3"
                                        required 
                                        disabled
                                        onkeypress="return isNumberKey(event)"
                                        onblur="getValues()"
                                    />
                                </div>
                            </label>
                          </div>
                        </div>
                      </div>
                </div>
                    <hr>
                    
                   <div class="col-12 float-right">
                    <button type="submit" id="usdtofiat" onclick="check_checkboxes1()"  disabled class="btn btn-info float-right ">{{__('data.convert')}}</button>
                    </div>
                </form>
                    </div>
                    <div class="col-md-6 col-12">
                         <h5 class="text-center text-secondary">{{__('data.YHTUSD')}}</h5>
                         <h4 class="text-info text-center mt-3 mb-3" id="remainingUSD"></h4>
                            <hr>
                        <b><h5 class=" text-center text-danger">
                            <span class="totalUSD"></span>
                            USD = <span class="totalARS"></span> ARS</h5></b>
                            <div class="text-secondary text-center">OR</div>
                        <b><h5 class=" text-center text-success">
                            <span class="totalUSD"></span>
                            USD = <span class="totalCLP"></span> CLP</h5></b>
                            <div class="text-secondary text-center">OR</div>
                        <b><h5 class=" text-center text-primary">
                            <span class="totalUSD"></span>
                            USD = <span class="totalSOL"></span> SOL</h5></b>
                            
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-secondary">
                      <h4 class="modal-title">Required!</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Please Select Any One Currency which you want to Convert</p>
        </div>
      </div>
    </div>
  </div>
  
    
@stop

@section('css')
<style>
    .font-weight-custom{
      font-weight:500;  
    }
    
    .hide{
        display:none;
    }
    
  
    
    /* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
      #textboxPrimary1, #textboxPrimary2,#textboxPrimary3,
      #textboxLocalToUSD1, #textboxLocalToUSD2,#textboxLocalToUSD3{
        min-width:auto;
    }
    .AmountboxPrimary1 .input-group-text,.AmountboxPrimary2 .input-group-text,.AmountboxPrimary3 .input-group-text,
    .AmountboxLocalToUSD1 .input-group-text,.AmountboxLocalToUSD2 .input-group-text,.AmountboxLocalToUSD3 .input-group-text{
        min-width:auto;
        display:flex;
        justify-content:center;
    }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
      #textboxPrimary1, #textboxPrimary2,#textboxPrimary3,
      #textboxLocalToUSD1, #textboxLocalToUSD2,#textboxLocalToUSD3{
        min-width:auto;
    }
    .AmountboxPrimary1 .input-group-text,.AmountboxPrimary2 .input-group-text,.AmountboxPrimary3 .input-group-text,
    .AmountboxLocalToUSD1 .input-group-text,.AmountboxLocalToUSD2 .input-group-text,.AmountboxLocalToUSD3 .input-group-text{
        min-width:auto;
        display:flex;
        justify-content:center;
    }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
      
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
    #textboxPrimary1, #textboxPrimary2,#textboxPrimary3,
     #textboxLocalToUSD1, #textboxLocalToUSD2,#textboxLocalToUSD3{
       min-width:200px;
    }
   
    .AmountboxPrimary1 .input-group-text,.AmountboxPrimary2 .input-group-text,.AmountboxPrimary3 .input-group-text,
    .AmountboxLocalToUSD1 .input-group-text,.AmountboxLocalToUSD2 .input-group-text,.AmountboxLocalToUSD3 .input-group-text{
        min-width:120px;
        display:flex;
        justify-content:center;
    }
}
</style>
@stop

@section('js')
<script>

$(document).ready(function(){
        var usd = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : auth()->user()->wallet->usd }};
        var ars = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : auth()->user()->wallet->usd }} * {{ round($ars, 3) }};
        var clp = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : auth()->user()->wallet->usd }} * {{ round($clp, 3) }};
        var sol = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : auth()->user()->wallet->usd }} * {{ round($pen, 3) }};
        $('#remainingUSD').html(usd.toFixed(2));
        $('.totalUSD').html(usd.toFixed(2));
        $('.totalARS').html(ars.toFixed(2));
        $('.totalCLP').html(clp.toFixed(2));
        $('.totalSOL').html(sol.toFixed(2));
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
        return false;
    return true;
}

    function getValues(){
        
        var rate = [];
        rate["clp_rate"] = {{ $clp }};
        rate["sol_rate"] = {{ $pen }};
        rate["ars_rate"] ={{ $ars }};
        var usd = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : auth()->user()->wallet->usd }};
        var totalcheck = $("#LocaltoUSDCheckboxes input[type=checkbox]");
        var total = $("#LocaltoUSDCheckboxes input[type=text]");
        var total_input_values=0;
        for(var i=0 ; i<total.length;i++){
            if(totalcheck[i].checked){
                
                var j= i+1;
                var amount = $("#textboxLocalToUSD"+j).val();
                var enterAmount = parseInt(amount);
                var currencyUpper=totalcheck[i].nextElementSibling.querySelector("span").innerText;
                var currencyLowerper=currencyUpper.toLowerCase();
                var exchangeRate=currencyLowerper+"_rate";
             
                total_input_values=total_input_values+enterAmount/rate[exchangeRate];
            }        
        }  
        
        //  var remaining = usd - total_input_values ;
        // $('#remainingUSD').html(remaining.toFixed(2));
         var remaining = usd - total_input_values ;
         if(remaining<0){
             alert("You don't have such amount of USD");
              $('#usdtofiat').attr( "disabled", "disabled" );
         }else{
               $('#remainingUSD').html(remaining.toFixed(2));
               $('#total_usd_remaining').val(remaining.toFixed(2));
               $('#usdtofiat').removeAttr("disabled");
         }
      
         
       
    }
  
   function checkedOrNot(){
     var checkbox = $("#checkboxes input[type=checkbox]");
        for(var i=0 ; i<checkbox.length;i++){
                j= i+1;
                if(checkbox[i].checked){
                    $("#textboxPrimary"+j).removeAttr("disabled");
                }else{
                    $("#textboxPrimary"+j).val('');
                    $("#textboxPrimary"+j).attr( "disabled", "disabled" );
                }
        }
    }
    
     function checkedOrNot1(x,id){
          var checkbox = x
            if(checkbox.checked){
                $('#textboxLocalToUSD'+id).removeAttr("disabled");
               
             
            }else{
               $('#textboxLocalToUSD'+id).val("0");
               $('#textboxLocalToUSD'+id).attr( "disabled", "disabled" );
               
               
            }
           getValues(); 
    } 
  
   function check_checkboxes(){
        var checkbox = document.getElementById('checkboxes').getElementsByTagName("input");
        var total_checked=0;
        for(var i=0 ; i<checkbox.length;i++){
                    if(checkbox[i].checked){
                       total_checked++;
                    }   
        }
        
        if(total_checked>0){
            document.getElementById('submit').click();
            
        }else{
           document.getElementById('modal').click();
        }
   }
   
   
   function check_checkboxes1(){
        var checkbox = document.getElementById('LocaltoUSDCheckboxes').getElementsByTagName("input");
        var total_checked=0;
        for(var i=0 ; i<checkbox.length;i++){
                    if(checkbox[i].checked){
                      
                       total_checked++;
                    }   
        }
        
        if(total_checked>0){
            document.getElementById('usdtofiat').click();
            
             $('#usdtofiat').removeAttr( "disabled", "disabled" );
        }else{
             $('#usdtofiat').attr( "disabled", "disabled" );
           document.getElementById('modal').click();
        }
        
   }
   
  
</script>
    <script>
        $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>
@stop