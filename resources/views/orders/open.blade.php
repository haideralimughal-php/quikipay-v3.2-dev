{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>{{__('data.openOrders')}}</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<!--<div class="card-header">-->
				<!--	<h3 class="card-title">DataTable with default features</h3>-->
				<!--</div>-->
				<!-- /.card-header -->
				<div class="card-body">
				    <div class="table-responsive">
    					<table id="example1" class="table table-hover">
    						<thead>
    							<tr>
    								<th>{{__('data.sr')}}</th>
    								<th>{{__('data.marketSymbol')}}</th>
    								<th>{{__('data.direction')}}</th>
    								<th>{{__('data.quantity')}}</th>
    								<th>{{__('data.value')}}</th>
    								<th>{{__('data.status')}}</th>
    							</tr>
    						</thead>
    						<tbody>
    							@if($orders)
    								@foreach($orders as $order)
    									<tr>
    										<td>{{ $loop->iteration }}</td>
    										<td>{{ $order->market_symbol }}</td>
    										<td>{{ $order->direction }}</td>
    										<td>{{ $order->quantity }}</td>
    										<td>{{ $order->value }}</td>
    										<td>{{ $order->status }}</td>
    									</tr>
    								@endforeach
    							@else
    								<tr>
    									<td colspan="6">No record Found.</td>
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
@stop

@section('css')
	<link rel="stylesheet" href="/css/admin_custom.css">
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
		console.log('Hi!'); 
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
	</script>
@stop