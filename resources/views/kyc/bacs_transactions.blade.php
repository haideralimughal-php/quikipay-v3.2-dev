{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.ekkoLightbox', true)

@section('content_header')
	<h1>{{__('data.transaction')}}</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
		    <div class="card card-primary card-outline card-tabs table-responsive">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Confirmed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Pending</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-reject" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Rejected</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                            <div class="table-responsive">
                                <table id="example1" class="table table-hover">
            						<thead>
            							<tr>
            								<th>{{__('data.sr')}}</th>
            								<th>{{__('data.merchant')}}</th>
            								<th>{{__('data.transId')}}</th>
            								<th>{{__('data.amount')}}</th>
            								<th>{{__('data.currency')}}</th>
            								<th>{{__('data.customerEmail')}}</th>
            								<th>{{__('data.receipt')}}</th>
            								<th>{{__('data.customerId')}}</th>
            								<th>{{__('data.status')}}</th>
            								<th>{{__('data.date')}}</th>
            								<th>{{__('data.action')}}</th>
            							</tr>
            						</thead>
            						<tbody>
            							@if(count($transactions['completed']))
            								@foreach($transactions['completed'] as $transaction)
            									<tr>
            										<td>{{ $loop->iteration }}</td>
            										<td>{{ $transaction->user->name }}</td>
            										<td>{{ $transaction->tx_id }}</td>
            										<td>{{ number_format($transaction->quantity) }}</td>
            										<td>{{ $transaction->currency_symbol }}</td>
            										<td>{{ $transaction->customer_email }}</td>
            										<td>
            										     @if($transaction->receipt)
            										    <a href="{{ asset('storage/' . $transaction->receipt) }}" data-toggle="lightbox" data-title="Receipt">
                                                            <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->receipt) }}">
                                                        </a>
                                                         @else
                                                           <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/receipts/index.png') }}">
                                                            
                                                        @endif
            										    
            										</td>
            										<td>
            										    @if($transaction->customer_id_image)
            										    <a href="{{ asset('storage/' . $transaction->customer_id_image) }}" data-toggle="lightbox" data-title="Customer Id">
                                                            <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->customer_id_image) }}">
                                                        </a>
                                                        @else
                                                           <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/receipts/index.png') }}">
                                                            
                                                        @endif
            										    
            										</td>
            										<td>{{ $transaction->status }}</td>
            										<td>{{ $transaction->created_at }}</td>
            										<td>
            										    @if(auth()->user()->can('isAdmin'))
                										    @if($transaction->status != 'completed')
                										        <form action="/confirm-transaction" onsubmit="return confirm('Are you sure you want to confirm transaction?')" method="post">
                										            @csrf
                										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                                    <button class="btn btn-success btn-sm">Approve</button>
                										        </form>
            										        @endif
            										        @if($transaction->status == 'completed')
                										        <form action="/disapprove-transaction" onsubmit="return confirm('Are you sure you want to disapprove transaction?')" method="post">
                										            @csrf
                										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                                    <button class="btn btn-danger btn-sm">Disapprove</button>
                										        </form>
                										    @endif
            										    @endif
            										</td>
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
                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                            <table id="example2" class="table table-hover">
        						<thead>
        							<tr>
        								<th>{{__('data.sr')}}</th>
        								<th>{{__('data.merchant')}}</th>
        								<th>{{__('data.transId')}}</th>
        								<th>{{__('data.amount')}}</th>
        								<th>{{__('data.currency')}}</th>
        								<th>{{__('data.customerEmail')}}</th>
        								<th>{{__('data.receipt')}}</th>
        								<th>{{__('data.customerId')}}</th>
        								<th>{{__('data.status')}}</th>
        								<th>{{__('data.date')}}</th>
        								<th>{{__('data.action')}}</th>
        							</tr>
        						</thead>
        						<tbody>
        							@if(count($transactions['pending']))
        								@foreach($transactions['pending'] as $transaction)
        									<tr>
        										<td>{{ $loop->iteration }}</td>
        										<td>{{ $transaction->user->name }}</td>
        										<td>{{ $transaction->tx_id }}</td>
        										<td>{{ number_format($transaction->quantity) }}</td>
        										<td>{{ $transaction->currency_symbol }}</td>
        										<td class="text-nowrap">{{ $transaction->customer_email }}</td>
        
        										<td>
            										     @if($transaction->receipt)
            										    <a href="{{ asset('storage/' . $transaction->receipt) }}" data-toggle="lightbox" data-title="Receipt">
                                                            <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->receipt) }}">
                                                        </a>
                                                         @else
                                                           <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/receipts/index.png') }}">
                                                            
                                                        @endif
            										    
            										</td>
            										<td>
            										    @if($transaction->customer_id_image)
            										    <a href="{{ asset('storage/' . $transaction->customer_id_image) }}" data-toggle="lightbox" data-title="Customer Id">
                                                            <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->customer_id_image) }}">
                                                        </a>
                                                        @else
                                                           <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/receipts/index.png') }}">
                                                            
                                                        @endif
            										    
            										</td>
            										
        										<td>{{ $transaction->status }}</td>
        										<td>{{ $transaction->created_at }}</td>
        										<td>
        										    @if(auth()->user()->can('isAdmin'))
            										    @if($transaction->status == 'pending')
            										        <form action="/confirm-transaction" onsubmit="return confirm('Are you sure you want to confirm transaction?')" method="post">
            										            @csrf
            										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                                <button class="btn btn-success btn-sm">Approve</button>
            										        </form>
            										        <br>
            										        
            										        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                                Reject
                                                              </button>
            										        <form action="/reject-transaction"  method="post">
            										            @csrf
            										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
            										            <input type="hidden" id="reason" value="" name="reason" >
                                                                <button class="btn btn-danger btn-sm " style="display:none;" id="rejectButton">Reject</button>
            										        </form>
        										        @endif
        										        @if($transaction->status == 'completed')
            										        <form action="/disapprove-transaction" onsubmit="return confirm('Are you sure you want to disapprove transaction?')" method="post">
            										            @csrf
            										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                                <button class="btn btn-danger btn-sm">Disapprove</button>
            										        </form>
            										    @endif
        										    @endif
        										</td>
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
                        <div class="tab-pane fade" id="custom-tabs-three-reject" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                            <table id="example2" class="table table-hover">
        						<thead>
        							<tr>
        								<th>{{__('data.sr')}}</th>
        								<th>{{__('data.merchant')}}</th>
        								<th>{{__('data.transId')}}</th>
        								<th>{{__('data.amount')}}</th>
        								<th>{{__('data.currency')}}</th>
        								<th>{{__('data.customerEmail')}}</th>
        								<th>{{__('data.receipt')}}</th>
        								<th>{{__('data.customerId')}}</th>
        								<th>{{__('data.status')}}</th>
        								<th>{{__('data.date')}}</th>
        								<th>{{__('data.action')}}</th>
        							</tr>
        						</thead>
        						<tbody>
        							@if(count($transactions['reject']))
        								@foreach($transactions['reject'] as $transaction)
        									<tr>
        										<td>{{ $loop->iteration }}</td>
        										<td>{{ $transaction->user->name }}</td>
        										<td>{{ $transaction->tx_id }}</td>
        										<td>{{ number_format($transaction->quantity) }}</td>
        										<td>{{ $transaction->currency_symbol }}</td>
        										<td class="text-nowrap">{{ $transaction->customer_email }}</td>
        
        										<td>
            										     @if($transaction->receipt)
            										    <a href="{{ asset('storage/' . $transaction->receipt) }}" data-toggle="lightbox" data-title="Receipt">
                                                            <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->receipt) }}">
                                                        </a>
                                                         @else
                                                           <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/receipts/index.png') }}">
                                                            
                                                        @endif
            										    
            										</td>
            										<td>
            										    @if($transaction->customer_id_image)
            										    <a href="{{ asset('storage/' . $transaction->customer_id_image) }}" data-toggle="lightbox" data-title="Customer Id">
                                                            <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->customer_id_image) }}">
                                                        </a>
                                                        @else
                                                           <img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/receipts/index.png') }}">
                                                            
                                                        @endif
            										    
            										</td>
            										
        										<td>{{ $transaction->status }}</td>
        										<td>{{ $transaction->created_at }}</td>
        										<td>
                                                    
            										        <form action="/confirm-transaction" onsubmit="return confirm('Are you sure you want to confirm transaction?')" method="post">
            										            @csrf
            										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                                <button class="btn btn-success btn-sm">Approve</button>
            										        </form>
            										        <br>
            										         
        										       
        										</td>
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
                </div>
              <!-- /.card -->
            </div>
            <br>
		</div>
	</div>
	  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
              <h5 class="modal-title" id="exampleModalLabel">Payment Reject</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-close text-white"></i></span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Please enter the reason of payment rejection</label>
                  <input type="text" id="reason-text" class="form-control">
                </div>
                <button type="button" class="btn btn-secondary float-right" data-dismiss="modal" onclick="promp()">Submit</button>
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
	function promp(){
	   // var reason = prompt('Please enter the reason of payment rejection');
	   // console.log(reason);
	     var reason = $("#reason-text").val();
	    $("#reason").val(reason);
	    $("#rejectButton").click();
	    
	}
	    $(function () {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
              event.preventDefault();
              $(this).ekkoLightbox({
                alwaysShowClose: true
              });
            });
        });
		console.log('Hi!'); 
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
			   buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
		$("#example2").DataTable({
			"responsive": true,
			"autoWidth": false,
			   buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
	</script>
@stop