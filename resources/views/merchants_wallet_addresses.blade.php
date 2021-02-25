{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.daterangepicker', true)
@section('plugins.moment', true)
@section('plugins.Datatables', true)
@section('plugins.ekkoLightbox', true)
@section('plugins.Select2', true)
@section('plugins.select2BS4', true)
@section('plugins.ionRangeslider', true)
@section('plugins.bootstrapSlider', true)
@section('plugins.icheck-bootstrap', true)


@section('content')

	<!--<h2>{{__('data.transaction')}}</h2>-->


 @if(Session::has('message'))
            <p class="alert alert-success">{{ Session::get('message') }}</p>
        @elseif(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('message') }}</p>
        @endif
	<div class="row">
	   
		<div class="col-12">
			<div class="card">
				<!--<div class="card-header">-->
				<!--	<h3 class="card-title">{{__('data.DWDF')}}</h3>-->
				<!--</div>-->
				<!-- /.card-header -->
				<div class="card-body">
				    
				    <div class="float-right col-md-12">
				        <button type="button" class=" float-right btn btn-success my-2" data-toggle="modal" data-target="#exampleModal">{{__('data.newAddress')}}</button>
				    </div>

					<div class="table-responsive">
					    <table id="example1" class="table text-center table-hover">
    						<thead>
    							<tr>
    								<th class="text-nowrap">{{__('data.sr')}}</th>
    								<th class="text-nowrap">{{__('data.currency')}}</th>
    								<th class="text-nowrap">{{__('data.address')}}</th>
    								<th class="text-nowrap">{{__('data.date')}}</th>
    								<th class="text-nowrap">{{__('data.action')}}</th>
    								
    							</tr>
    						</thead>
    						<tbody>
    							@if(count($addresses))
    								@foreach($addresses as $address)
    									<tr>
    										<td>{{ $loop->iteration }}</td>
    										<td>{{ $address->currency_symbol }}</td>
    										<td>{{ $address->address }}</td>
    										<td>{{ $address->created_at }}</td>
    										<td>
    										    <form action="/merchants_wallet_addresses/delete" method="post">
    										            @csrf
    										        <input type="hidden" value="{{ $address->id }}" name="id" >
    										        <button class="form-control btn btn-danger">
    										            <i class="fas fa-trash"></i>
    										        </button>
    										    </form>
    										</td>
    									</tr>
    								@endforeach
    						
    							@endif
    						</tbody>
    					</table>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
		</div>
	</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('data.newCryptoAddress')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="/merchants_wallet_addresses" method="POST">
            @csrf
          <div class="modal-body">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">{{__('data.cryptoCurrency')}}</label>
                        <select class="form-control select2" required id="currency_symbol" name="currency_symbol" style="width: 100%;">
            					<option value="BTC"  selected >BTC</option>
            					<option value="LTC" >LTC</option>
            					<option value="ETH" >ETH</option>
            					<option value="XRP" >XRP</option>
            					<option value="USDT" >USDT</option>
                        </select>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">{{__('data.cryptoAddress')}}</label>
                <textarea class="form-control" required id="address" name="address"></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info"><i class="fas fa-add"></i>{{__('data.add')}}</button>
          </div>
        </form>
    </div>
  </div>
</div>
@stop

@section('css')

<style>
    #status_m{
        font-size: 12px;
        padding:10px;
    }
    .cardHeadp2{
        color:gray;
    }
    .cardHeadp4{
        color:gray;
        font-size:12px;
        padding-top:10px;
    }
    .cardHeadp3{
        color:gray;
        font-size: 14px;
    }
    #viewDetail .cardHeadp1{
        color: #455e84 ;
        font-size: 18px;
    }
    #viewDetail .cardHead{
        color: #101a2d;
        font-size: 19px;
    }
    
    #viewDetail .close{
        padding: 4px 10px;
        box-shadow: 0px 0px 10px 0px rgba(189,176,189,1);
        border-radius: 30px;
        font-size: 28px;
        color:gray;
        position: relative;
        top: -15px;
        left: 15px;
        background-color: #fff;
        opacity:1;
    }
    .dt-button{
    padding: 5px 15px;
    color: white;
    border: none;
    border-radius: 5px;
    margin-bottom:20px;
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
    #pic1 , #pic2{
        padding-top:10px;
        overflow:hidden;
        width:97px;
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
		console.log('Hi!'); 
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
		
		  //Date range picker
 
        $('#reservation').daterangepicker({
          autoUpdateInput: false,
          locale: {
              cancelLabel: 'Clear'
          }
        });
        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
         $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
          });
        
          $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
          });
          
           
        $('#advanceSearch').click(function(){
           $('.advanceSearch').slideToggle("slow","linear");
        });

	   
     $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    $('.slider').bootstrapSlider()

    /* ION SLIDER */
    $('#range_1').ionRangeSlider({
      min     : 0,
      max     : 5000,
      from    : 1000,
      to      : 4000,
      type    : 'double',
      step    : 1,
      prefix  : '$',
      prettify: false,
      hasGrid : true
    })
	</script>
@stop