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

            <div class="card card-danger advanceSearch  px-5  pt-3 pb-5" style="display:none">
                <h4 class="text-center text-danger text-uppercase"><b>Advance Search</b></h4>
                <hr>
		        <form action="/customer-bacs-transactions" method="post">
		            @csrf
		            <div class="row">
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>User Email:</label>
                                <select class="form-control select2" name="userId" style="width: 100%;">
                                    <option selected="selected">All</option>
            								@foreach($customer_emails as $email)
            								<option value="{{$email->id}}" >{{$email->email}}</option>
            						        @endforeach
                                 </select>
                                
                            </div>
		                </div>
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Transaction Id:</label>
                                <select class="form-control select2" name="txId" style="width: 100%;">
                                <option selected="selected">All</option>
                                
            								@foreach($tx_id as $txId)
            								<option>{{$txId->tx_id}}</option>
            						        @endforeach
                              </select>
                                
                            </div>
		                </div>
		                <!--<div class="col-md-6 d-none">-->
		                <!--    <div class="form-group">-->
                  <!--           <label>Amount</label>-->
                  <!--               <input id="range_1" type="text"  value="">-->
                                
                  <!--          </div>-->
		                <!--</div>-->
		                <div class="col-md-6">
                            <div class="form-group">
                                <label>Date range:</label>
                                <!--<input type="hidden" name="SendStatus" value="confirmed" id="activeTab">-->
                                <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" name="range" value=""  class="form-control float-right" id="reservation" />
                          </div>
                            </div>
                        </div>
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Currency</label>
                                <select class="form-control select2" name="currencySymbol" style="width: 100%;">
                                <option selected="selected">All</option>
                                
            								@foreach($currency as $symbol)
            								<option>{{$symbol->currency_symbol}}</option>
            						        @endforeach
                              </select>
                                
                            </div>
		                </div>
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Status</label>
                                <select class="form-control select2" name="status" style="width: 100%;">
                                <option selected="selected">All</option>
                                	@foreach($status as $stat)
            								<option>{{$stat->status}}</option>
            						        @endforeach
            							
                              </select>
                                
                            </div>
		                </div>
                        <div class="col-md-12 ">
                             <!-- /.input group -->
                          <div class="form-group float-right">
                              <button type="submit" class="btn btn-primary">Search</button>
                          </div>
                        </div>      
		            </div>
		           
		        </form>
		    </div>
	<h2>{{__('data.transaction')}}</h2>


	<div class="row">
		<div class="col-12">
		    <div class="card card-primary card-outline card-tabs table-responsive">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-complete-tab" data-toggle="pill" href="#custom-complete-tab-content" role="tab" aria-controls="custom-complete-tab-content" aria-selected="true">Confirmed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-pending-tab" data-toggle="pill" href="#custom-pending-tab-content" role="tab" aria-controls="custom-pending-tab-content" aria-selected="false">Pending</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" id="custom-reject-tab" data-toggle="pill" href="#custom-reject-tab-content" role="tab" aria-controls="custom-reject-tab-content" aria-selected="false">Rejected</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="col-12 float-right">
                        <button class="btn btn-info float-right btn-md d-none" id="advanceSearch"><i class="fas fa-search-plus"></i> Advance Search</button>
                    </div>
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade active show" id="custom-complete-tab-content" role="tabpanel" aria-labelledby="custom-complete-tab">
                            <div class="table-responsive">
                                <table id="example1" class="table table-hover ">
            						<thead>
            							<tr>
            								<th class="text-nowrap">{{__('data.sr')}}</th>
            								<th class="text-nowrap">{{__('data.userName')}}</th>
            								<th class="text-nowrap">{{__('data.userEmail')}}</th>
            								<th class="text-nowrap">{{__('data.transId')}}</th>
            								<th class="text-nowrap">{{__('data.amount')}}</th>
            								<th class="text-nowrap">{{__('data.currency')}}</th>
            								<th class="text-nowrap">{{__('data.receipt')}}</th>
            								<th class="text-nowrap">{{__('data.customerId')}}</th>
            								<th class="text-nowrap">{{__('data.status')}}</th>
            								<th class="text-nowrap">{{__('data.date')}}</th>
            								<th class="text-nowrap">{{__('data.action')}}</th>
            							</tr>
            						</thead>
            						<tbody>
            							@if(count($transactions['completed']))
            								@foreach($transactions['completed'] as $transaction)
            									<tr>
            										<td>{{ $loop->iteration }}</td>
            										<td>{{ $transaction->name }}</td>
            										<td>{{ $transaction->email }}</td>
            										<td>{{ $transaction->tx_id }}</td>
            										<td>{{ number_format($transaction->amount) }}</td>
            										<td>{{ $transaction->currency_symbol }}</td>
            										<td>
            										     @if($transaction->receipt_image)
            										    <a href="data:image/jpeg;base64,{{ chunk_split(base64_encode($transaction->receipt_image)) }}" data-toggle="lightbox" data-title="Receipt">
                                                            <!--<img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->receipt) }}">-->
                                                            <img src="data:image/jpeg;base64,{{ chunk_split(base64_encode($transaction->receipt_image)) }}" height="100" width="100">
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
                										  
            										        @if($transaction->status == 'completed')
                										        <form action="/customerDisapproveTransaction" onsubmit="return confirm('Are you sure you want to disapprove transaction?')" method="post">
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
            									<td colspan="11">No record Found.</td>
            								</tr>
            							@endif
            						</tbody>
            					</table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-pending-tab-content" role="tabpanel" aria-labelledby="custom-pending-tab">
                            <table id="example2" class="table table-hover">
        						<thead>
        							<tr>
            								<th class="text-nowrap">{{__('data.sr')}}</th>
            								<th class="text-nowrap">{{__('data.userName')}}</th>
            								<th class="text-nowrap">{{__('data.userEmail')}}</th>
            								<th class="text-nowrap">{{__('data.transId')}}</th>
            								<th class="text-nowrap">{{__('data.amount')}}</th>
            								<th class="text-nowrap">Currency</th>
            								<th class="text-nowrap">{{__('data.receipt')}}</th>
            								<th class="text-nowrap">{{__('data.customerId')}}</th>
            								<th class="text-nowrap">{{__('data.status')}}</th>
            								<th class="text-nowrap">{{__('data.date')}}</th>
            								<th class="text-nowrap">{{__('data.action')}}</th>
        							</tr>
        						</thead>
        						<tbody>
        							@if(count($transactions['pending']))
        								@foreach($transactions['pending'] as $transaction)
        									<tr>
        										    <td>{{ $loop->iteration }}</td>
            										<td>{{ $transaction->name }}</td>
            										<td>{{ $transaction->email }}</td>
            										<td>{{ $transaction->tx_id }}</td>
            										<td>{{ number_format($transaction->amount) }}</td>
            										<td>{{ $transaction->currency_symbol }}</td>
        
        										<td>
            										     @if($transaction->receipt_image )
            										    <a href="data:image/jpeg;base64,{{ chunk_split(base64_encode($transaction->receipt_image)) }}" data-toggle="lightbox" data-title="Receipt">
                                                            <!--<img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->receipt) }}">-->
                                                            <img src="data:image/jpeg;base64,{{ chunk_split(base64_encode($transaction->receipt_image)) }}" height="100" width="100">
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
            										        <form action="/customerconfirmTransaction" onsubmit="return confirm('Are you sure you want to confirm transaction?')" method="post">
            										            @csrf
            										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                                <button class="btn btn-success btn-sm">Approve</button>
            										        </form>
            										        <br>
            										        
            										        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal2">
                                                                Reject
                                                              </button>
            										        <form action="/customerRejectTransaction"  method="post">
            										            @csrf
            										            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
            										            <input type="hidden" id="reason2" value="" name="reason" >
                                                                <button class="btn btn-danger btn-sm " style="display:none;" id="rejectButton2">Reject</button>
            										        </form>
        										        @endif
        										       
        										    @endif
        										</td>
        									</tr>
        								@endforeach
        							@else
        								<tr>
        									<td colspan="11">No record Found.</td>
        								</tr>
        							@endif
        						</tbody>
        					</table> 
                        </div>
                        <div class="tab-pane fade" id="custom-reject-tab-content" role="tabpanel" aria-labelledby="custom-reject-tab">
                            <table id="example3" class="table table-hover">
        						<thead>
        							<tr>
            								<th class="text-nowrap">{{__('data.sr')}}</th>
            								<th class="text-nowrap">{{__('data.userName')}}</th>
            								<th class="text-nowrap">{{__('data.userEmail')}}</th>
            								<th class="text-nowrap">{{__('data.transId')}}</th>
            								<th class="text-nowrap">{{__('data.amount')}}</th>
            								<th class="text-nowrap">{{__('data.currency')}}</th>
            								<th class="text-nowrap">{{__('data.receipt')}}</th>
            								<th class="text-nowrap">{{__('data.customerId')}}</th>
            								<th class="text-nowrap">{{__('data.status')}}</th>
            								<th class="text-nowrap">{{__('data.date')}}</th>
            								<th class="text-nowrap">{{__('data.action')}}</th>
        							</tr>
        						</thead>
        						<tbody>
        							@if(count($transactions['reject']))
        								@foreach($transactions['reject'] as $transaction)
        									<tr>
        										    <td>{{ $loop->iteration }}</td>
            										<td>{{ $transaction->name }}</td>
            										<td>{{ $transaction->email }}</td>
            										<td>{{ $transaction->tx_id }}</td>
            										<td>{{ number_format($transaction->amount) }}</td>
            										<td>{{ $transaction->currency_symbol }}</td>
        
        										<td>
            										     @if($transaction->receipt_image)
            										    <a href="data:image/jpeg;base64,{{ chunk_split(base64_encode($transaction->receipt_image)) }}" data-toggle="lightbox" data-title="Receipt">
                                                            <!--<img class="img-fluid mb-2" width="100" height="100" src="{{ asset('storage/' . $transaction->receipt) }}">-->
                                                            <img src="data:image/jpeg;base64,{{ chunk_split(base64_encode($transaction->receipt_image)) }}" height="100" width="100">
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
        									<td colspan="11">No record Found.</td>
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
	  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <input type="text" id="reason-text2" class="form-control">
                </div>
                <button type="button" class="btn btn-secondary float-right" data-dismiss="modal" onclick="promp2()">Submit</button>
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
	function promp2(){
	   // var reason = prompt('Please enter the reason of payment rejection');
	   // console.log(reason);
	     var reason = $("#reason-text2").val();
	    $("#reason2").val(reason);
	    $("#rejectButton2").click();
	    
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
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
		$("#example2").DataTable({
			"responsive": true,
			"autoWidth": false,
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});
		$("#example3").DataTable({
			"responsive": true,
			"autoWidth": false,
			dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
		});



        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                 $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                  });
                
                  $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
                      $(this).val('');
                  });
        
        $( document ).ready(function() {
            var x = $("#ToActiveTab").val();
                    console.log(x);
             if(x == "pending"){
                $(".nav-item #confirm-trasactions-tab").removeClass("active");
                $(".nav-item #pending-trasactions-tab").addClass("active");
                $(".nav-item #reject-trasactions-tab").removeClass("active");
                $(".tab-content #confirm-trasactions-content").removeClass("active show");
                $(".tab-content #pending-trasactions-content").addClass("active show");
                $(".tab-content #reject-trasactions-content").removeClass("active show");
            }else if(x == "reject"){
                $(".nav-item #confirm-trasactions-tab").removeClass("active");
                $(".nav-item #pending-trasactions-tab").removeClass("active");
                $(".nav-item #reject-trasactions-tab").addClass("active");
                 $(".tab-content #confirm-trasactions-content").removeClass("active show");
                $(".tab-content #pending-trasactions-content").removeClass("active show");
                $(".tab-content #reject-trasactions-content").addClass("active show");
            }else{
                console.log(x);
            }
            
            
            $('#advanceSearch').click(function(){
               $('.advanceSearch').slideToggle("slow","linear");
            });
        });
            
            $('#confirm-trasactions-tab').click(function() {
                $("#activeTab").val("confirmed");
            });
             $('#pending-trasactions-tab').click(function() {
                    $("#activeTab").val("pending");
            });
            $('#reject-trasactions-tab').click(function() {
                $("#activeTab").val("reject"); 
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