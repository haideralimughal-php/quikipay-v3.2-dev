{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')


@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
    @if($param =='wh')         
    	<h1>{{__('data.merchantwithdrawHistory')}}</h1>
    @elseif($param == 'ph')
    	<h1>{{__('data.merchantpayout_history')}}</h1>
    @elseif($param == 'wr')
    	<h1>{{__('data.merchantwithdrawRequest')}}</h1>
    @elseif($param == 'pr')
    	<h1>{{__('data.merchantpayoutRequest')}}</h1>
    @endif
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<!--<div class="card-header">-->
				<!--	<h3 class="card-title">{{__('data.DWDF')}}</h3>-->
				<!--</div>-->
				<!-- /.card-header -->
				<div class="card-body">
				    <div class="table-responsive">
					    <table id="example1" class="table table-hover ">
						<thead>
							<tr>
								<th>{{__('data.sr')}}</th>
								<th>{{__('data.user')}}</th>
								<th>{{__('data.bank')}}</th>
								<th>{{__('data.amount')}}</th>
								<th>{{__('data.status')}}</th>
								<th>{{__('data.exchange_rate')}}</th>
								<th>{{__('data.date')}}</th>
								<th>{{__('data.action')}}</th>
							</tr>
						</thead>
						<tbody>
							@if(count($withdrawals))
								@foreach($withdrawals as $withdrawal)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $withdrawal->user->name }}</td>
										<td>{{ $withdrawal->bank }}</td>
										<td>{{ number_format($withdrawal->amount) }} {{$withdrawal->currency}}</td>
										<td>{{ $withdrawal->status }}</td>
										<td  class="text-center">
										    @if(isset($withdrawal->fx_rate))
										    {{ $withdrawal->fx_rate }}
										    @else
										       <span class="text-center">---</span>
										    
										    @endif</td>
										<td>{{ $withdrawal->created_at }}</td>
										<td>
										    <div class="btn-group d-flex justify-content-center">
										        <form action="/withdrawal-modal" method="post">
										            @csrf
										            <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
										            <input type="hidden" name="type" value="{{ $param }}">
                                                    <button type="submit" data-toggle="tooltip" title="View Detail"  class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
										        </form>
										        @if(auth()->user()->can('isAdmin') && $withdrawal->status == 'pending')
    										        <form action="/accept-withdrawal" onsubmit="return confirm('Are you sure you want to approve withdrawal?')" method="post">
    										            @csrf
    										            <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
    										            <input type="hidden" name="type" value="{{ $param }}">
                                                        <button data-toggle="tooltip" title="Accecpt Request" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
    										        </form>
    										        <form action="/reject-withdrawal" onsubmit="return confirm('Are you sure you want to reject withdrawal?')" method="post">
    										            @csrf
    										            <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
    										            <input type="hidden" name="type" value="{{ $param }}">
                                                        <button data-toggle="tooltip" title="Reject Request" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
    										        </form>
    										    @endif
    										    
                                            </div> 
										    
										</td>
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
	<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@stop