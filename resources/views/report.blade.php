{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Report')

@section('plugins.daterangepicker', true)
@section('plugins.moment', true)
@section('plugins.Datatables', true)

@section('content_header')
	<h1>{{__('data.reports')}}</h1>
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
				    <!-- Date range -->
                <form class="form-inline" action="/report" method="post" id="dateRange">
                    @csrf
                          
                    <div class="form-group col-md-6 offset-md-6 col-12">
                      <label>Date range:</label>
    
                      <div class="input-group mx-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" name="range" class="form-control float-right" id="reservation">
                      </div>
                      <!-- /.input group -->
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary mx-3">Search</button>
                      </div>
                    </div>
                    
                </form>
				    <div class="table-responsive">
    					<table id="example1" class="table table-bordered  table-hover">
    						<thead>
    							<tr>
    								<th>{{__('data.sr')}}</th>
    								<th>{{__('data.transId')}}</th>
    								<th>{{__('data.orderId')}}</th>
    								<th>{{__('data.amount')}}</th>
    								<th>{{__('data.fees')}}</th>
    								<th>Fx Rate</th>
    								<th>{{__('data.paymentResource')}}</th>
    								<th>{{__('data.date')}}</th>
    							</tr>
    						</thead>
    						<tbody>
    							@if(count($reports))
    								@foreach($reports as $report)
    									<tr>
    										<td>{{ $loop->iteration }}</td>
    										<td>{{ $report->transaction_id }}</td>
    										<td>{{ $report->order_id }}</td>
    										<td>{{ $report->total_amount }} {{ $report->currency_symbol }}</td>
    										<td>{{ $report->fees }} {{ $report->currency_symbol }}</td>
    										<td>{{ $report->fx_rate }}</td>
    										<td>{{ $report->type }}</td>
    										<td>{{ $report->created_at }}</td>
    									</tr>
    								@endforeach
    							@else
    								<tr>
    									<td colspan="8">No record Found.</td>
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

<script>
    $( document ).ready(function() {
        $('.applyBtn').attr('type', 'submit');
});

</script>
<!--DATE RANGE PICKER-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
			"autoWidth": true,
			   dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
		

    //Date range picker
    $('#reservation').daterangepicker();
    

	</script>

@stop