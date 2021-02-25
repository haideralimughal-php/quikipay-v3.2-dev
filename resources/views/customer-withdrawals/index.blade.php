{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')


@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>{{__('data.withdrawRequest')}}</h1>
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
								<th>{{__('data.date')}}</th>
								<th>{{__('data.action')}}</th>
							</tr>
						</thead>
						<tbody>
							@if(count($withdrawals))
								@foreach($withdrawals as $withdrawal)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $withdrawal->customer->name }}</td>
										<td>{{ $withdrawal->bank }}</td>
										<td>{{ number_format($withdrawal->amount) }}</td>
										<td>{{ $withdrawal->status }}</td>
										<td>{{ $withdrawal->created_at }}</td>
										<td>
                                                <a href="/customer-withdrawals/{{ $withdrawal->id }}" data-toggle="tooltip" title="View Detail"  class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
										        @if(auth()->user()->can('isAdmin') && $withdrawal->status == 'pending')
    										        <form action="/customer-withdrawals/review" onsubmit="return confirm('Are you sure you want to approve withdrawal?')" method="post">
    										            @csrf
    										            <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
    										            <input type="hidden" name="status" value="accepted">
                                                        <button data-toggle="tooltip" title="Accecpt Request" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
    										        </form>
    										        <form action="/customer-withdrawals/review" onsubmit="return confirm('Are you sure you want to reject withdrawal?')" method="post">
    										            @csrf
    										            <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
    										            <input type="hidden" name="status" value="rejected">
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
	<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
	<script> 
		console.log('Hi!'); 
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
		});
	</script>
	<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@stop