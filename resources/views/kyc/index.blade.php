{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'KYC Verifications')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>KYC Verifications</h1>
@stop

@section('content')

@include('errors')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
	<div class="row">
		<div class="col-12">
			<div class="card">
				<!--<div class="card-header">-->
				<!--	<h3 class="card-title">{{__('data.DWDF')}}</h3>-->
				<!--</div>-->
				<!-- /.card-header -->
				<div class="card-body">
					<div class="table-responsive">
					    <table id="example1" class="table table-hover">
    						<thead>
    							<tr>
    								<th>{{__('data.sr')}}</th>
    								<th>Document Type</th>
    								<th>Document Image</th>
    								<th>Face Image</th>
    								<th>Status</th>
    								<th>Actions</th>
    							</tr>
    						</thead>
    						<tbody>
    							@if(@count($verifications))
    								@foreach($verifications as $verification)
    									<tr>
    										<td>{{ $loop->iteration }}</td>
    										<td>{{ @str_replace("_"," ",strtoupper($verification->document_type)) }}</td>
    										<td>
    										    <img src="data:image/jpeg;base64,{{ chunk_split(base64_encode($verification->document_image)) }}" height="100" width="100">
    										</td>
    										<td>
    										    <img src="data:image/jpeg;base64,{{ chunk_split(base64_encode($verification->face_image)) }}" height="100" width="100">
    									    </td>
    										<td>
    										    <p class="@if($verification->status  === 'accepted') {{'text-success'}} @elseif($verification->status  === 'declined') {{'text-danger'}} @else {{'text-warning'}} @endif">
    										        {{ @strtoupper($verification->status) }}
    										    </p>
    										</td>
    										<td>
    										    <a href="kyc-verifications/{{ $verification->id }}/{{ base64_encode('accepted') }}" class="btn btn-success {{ $verification->status == 'accepted' ? 'd-none' : '' }}">Accept</a>
    										    <a href="kyc-verifications/{{ $verification->id }}/{{ base64_encode('declined') }}" class="btn btn-danger {{ $verification->status == 'declined' ? 'disabled' : '' }}">Decline</a>
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
@stop