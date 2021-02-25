{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>Merchants</h1>
@stop

@section('content')
<style>
    .br-none{
       border-right:none !important; 
    }
    .bl-none{
       border-left:none !important; 
    }
    .b-none{
        border:none !important;
    }
    @media (min-width: 992px){
    .modal-lg {
        max-width: 1150px !important;
    }
    .input-tax{
        width: 100%;
    }
    .input-tax:focus{
        border-color: gray;
    }
    
</style>
	<div class="row">
		<div class="col-12">
		    @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"></h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div class="table-responsive">
					    <table id="example1" class="table table-hover">
    						<thead>
    							<tr>
    								<th>Sr. #</th>
    								<th>Merhant Email</th>
    								<th>Email Status</th>
    								<th>Min Limit Order ($)</th>
    								<!--<th>Merchant Address</th>-->
    								<th>Fees Action</th>
    							</tr>
    						</thead>
    						<tbody>
    							@if(count($users))
    								@foreach($users as $user)
    									<tr>
    										<td>{{ $loop->iteration }}</td>
    										<td>{{ $user->email }}</td>
    										<td>{{ $user->email_flag }}</td>
    										<td>{{ $user->order_limit }}</td>
    										<!--<td>{{ $user->address }}</td>-->
    										<td class="text-center"><button type="button" id="{{ $user->id }}" class="btn text-white btn-dark btn-block open_modal" data-toggle="modal" data-target="#exampleModalCenter">Fee Setup</button></td>
    									</tr>
    								@endforeach
    							@else
    								<tr>
    									<td colspan="5">No record Found.</td>
    								</tr>
    							@endif
    						</tbody>
    					</table>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>
	<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">QuickiPay Fee Structure</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="bg-light">
                  
                <tr>
                  <th scope="col">RATES FOR PAYMENT METHODS <br>PROCESSING </th>
                  <th scope="col" class="text-center"><img src="{{ asset('payImages/chilean-flag-small.png') }}" height="30px" width="45px"><br>Chile </th>
                  <th scope="col" class="text-center"><img src="{{ asset('payImages/argentinian-flag-small.png') }}" height="30px" width="45px"><br>Argentina </th>
                  <th scope="col" class="text-center"><img src="{{ asset('payImages/NicePng_peru-flag-png.png') }}" height="30px" width="45px"><br>Peru</th>
                  <th scope="col" class="text-center"><img src="{{ asset('payImages/panamanian-flag-small.png') }}" height="30px" width="45px"><br>Panama</th>
                  <th scope="col" class="text-center"><img src="{{ asset('payImages/venezuelan-flag-small.png') }}" height="30px" width="45px"><br>Venezuela</th>
                  <th scope="col" class="text-center"><img src="{{ asset('payImages/others-flags.png') }}" height="35px" width="35px"><br>Others</th>
                </tr>
              </thead>
              <tbody>
                  
                  
                <form action="/fees_save" method="post" >
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" class="userId" >
                
                    <tr>
                        <td><b>ELECTRONIC TRANSFER / DEPOSIT</b> <br>(MANUAL CONFIRMATION)</td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="bacsChile" name="bacsChile" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="bacsArgentina" name="bacsArgentina" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="bacsPeru" name="bacsPeru" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="bacsPanama" name="bacsPanama" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="bacsVenezuela" name="bacsVenezuela" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="bacsOthers" name="bacsOthers" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>ONLINE CASH PAYMENT PAGO 46</td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="pagoChile" name="pagoChile" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="pagoArgentina" name="pagoArgentina" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="pagoPeru" name="pagoPeru" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="pagoPanama" name="pagoPanama" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="pagoVenezuela" name="pagoVenezuela" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="pagoOthers" name="pagoOthers" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                      <td>DEBIT CARD AND CREDIT CARD</td>
                      <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cardChile" name="cardChile" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cardArgentina" name="cardArgentina" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cardPeru" name="cardPeru" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cardPanama" name="cardPanama" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cardVenezuela" name="cardVenezuela" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cardOthers" name="cardOthers" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!--<tr>-->
                    <!--  <td>CREDIT CARD FROM INTERNATIONAL ISSUER (BLOCKFORT)</td>-->
                    <!--  <td class="text-center">-->
                    <!--        <div class="container">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-8 pr-0">-->
                    <!--                    <input class="input-tax form-control" id="blockfortChile" name="blockfortChile" required>-->
                    <!--                </div>-->
                    <!--                <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">-->
                    <!--                   %-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </td>-->
                    <!--    <td class="text-center">-->
                    <!--        <div class="container">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-8 pr-0">-->
                    <!--                    <input class="input-tax form-control" id="blockfortArgentina" name="blockfortArgentina" required>-->
                    <!--                </div>-->
                    <!--                <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">-->
                    <!--                   %-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </td>-->
                    <!--    <td class="text-center">-->
                    <!--        <div class="container">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-8 pr-0">-->
                    <!--                    <input class="input-tax form-control" id="blockfortPeru" name="blockfortPeru" required>-->
                    <!--                </div>-->
                    <!--                <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">-->
                    <!--                   %-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </td>-->
                    <!--    <td class="text-center">-->
                    <!--        <div class="container">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-8 pr-0">-->
                    <!--                    <input class="input-tax form-control" id="blockfortPanama" name="blockfortPanama" required>-->
                    <!--                </div>-->
                    <!--                <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">-->
                    <!--                   %-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </td>-->
                    <!--    <td class="text-center">-->
                    <!--        <div class="container">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-8 pr-0">-->
                    <!--                    <input class="input-tax form-control" id="blockfortVenezuela" name="blockfortVenezuela" required>-->
                    <!--                </div>-->
                    <!--                <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">-->
                    <!--                   %-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </td>-->
                    <!--    <td class="text-center">-->
                    <!--        <div class="container">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-8 pr-0">-->
                    <!--                    <input class="input-tax form-control" id="blockfortOthers" name="blockfortOthers" required>-->
                    <!--                </div>-->
                    <!--                <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">-->
                    <!--                   %-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </td>-->
                    <!--</tr>-->
                    <tr>
                      <td>CRYPTO PAYMENT (*)</td>
                      <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cryptoChile" name="cryptoChile" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cryptoArgentina" name="cryptoArgentina" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cryptoPeru" name="cryptoPeru" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cryptoPanama" name="cryptoPanama" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cryptoVenezuela" name="cryptoVenezuela" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="cryptoOthers" name="cryptoOthers" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                      <td>HITES</td>
                      <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="hitesChile" name="hitesChile" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="hitesArgentina" name="hitesArgentina" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="hitesPeru" name="hitesPeru" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="hitesPanama" name="hitesPanama" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="hitesVenezuela" name="hitesVenezuela" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="hitesOthers" name="hitesOthers" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                      <td>Fee for conversion local currency to USD</td>
                      <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="usdChile" name="usdChile" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="usdArgentina" name="usdArgentina" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="usdPeru" name="usdPeru" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="usdPanama" name="usdPanama" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="usdVenezuela" name="usdVenezuela" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        <input class="input-tax form-control" id="usdOthers" name="usdOthers" required>
                                    </div>
                                    <div class="col-3 pl-0 bg-secondary d-flex align-items-center justify-content-center">
                                       %
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7" class="">Rates include VAT</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-right b-none">
                            <button type="submit" class="btn btn-primary">Save</button>
                            </td>
                    </tr>
                </form>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
<style>
    .dt-button{
    padding: 5px 15px;
    color: white;
    border: none;
    border-radius: 5px;
    }
    .buttons-copy{
      background-color: #5cb85c;
    border-bottom: 5px solid #5cb85c;
    text-shadow: 0px -1px #5cb85c;   
    }
    .buttons-csv{
      background-color: #0275d8;
    border-bottom: 5px solid #0275d8;
    text-shadow: 0px -1px #2980B9;   
    }
        .buttons-excel{
      background-color: #5bc0de;
    border-bottom: 5px solid #5bc0de;
    text-shadow: 0px -1px #2980B9;   
    }
    .buttons-pdf{
      background-color: #f0ad4e;
    border-bottom: 5px solid #f0ad4e;
    text-shadow: 0px -1px #2980B9;   
    }
    .buttons-print{
      background-color: #d9534f;
    border-bottom: 5px solid #d9534f;
    text-shadow: 0px -1px #2980B9;   
    }
</style>
@stop

@section('js')

<!--DATA TABLES -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
	<script> 
	    $( ".open_modal" ).click(function() {
              var x = $(this).attr('id');
              $(".userId").attr("value",x);
              getFees(x);
        });
		
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
			 dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
		
		function getFees(user_id){
		    var user_id = user_id;
    		$.ajax({
    		    method: "GET",
    		    url: "/get_fees?user_id="+user_id,
    		    success: function(response){
    		        response = JSON.parse(response);
                        console.log(response);
                        $("#bacsChile").val(response.chile["0"].bacs);
                        $("#pagoChile").val(response.chile["0"].pago);
                        $("#cardChile").val(response.chile["0"].debit_credit);
                        $("#cryptoChile").val(response.chile["0"].crypto);
                        $("#hitesChile").val(response.chile["0"].hites);
                        $("#usdChile").val(response.chile["0"].conversion);
                        ///////////////////////////////
                        
                        
                        $("#bacsArgentina").val(response.ars["0"].bacs);
                        $("#pagoArgentina").val(response.ars["0"].pago);
                        $("#cardArgentina").val(response.ars["0"].debit_credit);
                        $("#cryptoArgentina").val(response.ars["0"].crypto);
                        $("#hitesArgentina").val(response.ars["0"].hites);
                        $("#usdArgentina").val(response.ars["0"].conversion);
                        //////////////////////////////
                        
                        
                        
                        $("#bacsPeru").val(response.peru["0"].bacs);
                        $("#pagoPeru").val(response.peru["0"].pago);
                        $("#cardPeru").val(response.peru["0"].debit_credit);
                        $("#cryptoPeru").val(response.peru["0"].crypto);
                        $("#hitesPeru").val(response.peru["0"].hites);
                        $("#usdPeru").val(response.peru["0"].conversion);
                        ///////////////////////////
                        
                        
                        $("#bacsPanama").val(response.panama["0"].bacs);
                        $("#pagoPanama").val(response.panama["0"].pago);
                        $("#cardPanama").val(response.panama["0"].debit_credit);
                        $("#cryptoPanama").val(response.panama["0"].crypto);
                        $("#hitesPanama").val(response.panama["0"].hites);
                        $("#usdPanama").val(response.panama["0"].conversion);
                        //////////////////
                        
                        
                        $("#bacsOthers").val(response.other["0"].bacs);
                        $("#pagoOthers").val(response.other["0"].pago);
                        $("#cardOthers").val(response.other["0"].debit_credit);
                        $("#cryptoOthers").val(response.other["0"].crypto);
                        $("#hitesOthers").val(response.other["0"].hites);
                        $("#usdOthers").val(response.other["0"].conversion);
                        //////////////
                        
                        $("#bacsVenezuela").val(response.venz["0"].bacs);
                        $("#pagoVenezuela").val(response.venz["0"].pago);
                        $("#cardVenezuela").val(response.venz["0"].debit_credit);
                        $("#cryptoVenezuela").val(response.venz["0"].crypto);
                        $("#hitesVenezuela").val(response.venz["0"].hites);
                        $("#usdVenezuela").val(response.venz["0"].conversion);
                         
                        //////////////
        
    		            return response;
    		    }
    		})
		}
	</script>
@stop