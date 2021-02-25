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
		        <form action="/transactions" method="post">
		            @csrf
		            <div class="row">
		             @if($user_id == "1")
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Merchant Email:</label>
                                <select class="form-control select2" name="merchantId"  style="width: 100%;">
                                    <option selected="selected">All</option>
                                    @foreach($merchantEmail as $email)
            								<option value="{{$email['id']}}" @if(Session::get('merchantId') and Session::get('merchantId')==$email['id']) selected @endif>{{$email['email']}}</option>
            						        @endforeach
                                  </select>
                                
                            </div>
		                </div>
		            @endif
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Customer Email:</label>
                                <select class="form-control select2" name="customerEmail" style="width: 100%;">
                                    <option selected="selected">All</option>
            								@foreach($customer_emails as $email)
            								<option value="{{$email['customer_email']}}"  @if(Session::get('customerEmail') and Session::get('customerEmail')==$email['customer_email']) selected @endif >{{$email['customer_email']}} </option>
            						        @endforeach
                                 </select>
                                
                            </div>
		                </div>
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Transaction/Deposit Id:</label>
                                <select class="form-control select2" name="depositId" style="width: 100%;">
                                <option selected="selected">All</option>
                                
            								@foreach($deposit_id as $depositId)
            								<option  value="{{$depositId['deposit_id']}}" @if(Session::get('deposit_id') and Session::get('deposit_id')==$depositId['deposit_id']) selected @endif>{{$depositId['deposit_id']}}</option>
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
                            @if(Session::get('range')) 
                                
                            <input type="text" name="range" value="{{ Session::get('range') }}" class="form-control float-right" id="reservation" />
                            @else
                            
                           
                            <input type="text" name="range" value="" class="form-control float-right" id="reservation" />
                            @endif
                          </div>
                            </div>
                        </div>
		                <div class="col-md-6">
		                    <div class="form-group">
                             <label>Currency</label>
                                <select class="form-control select2" name="currencySymbol" style="width: 100%;">
                                <option selected="selected">All</option>
                                
            								@foreach($currency as $symbol)
            								<option value="{{$symbol['currency_symbol']}}" @if(Session::get('currency_symbol') and Session::get('currency_symbol')==$symbol['currency_symbol']) selected @endif>{{$symbol['currency_symbol']}}</option>
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
            								<option value="{{$stat['status']}}" @if(Session::get('status') and Session::get('status')==$stat['status']) selected @endif>{{$stat['status']}}</option>
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
					<div class="col-12 py-3 float-right">
                        <button class="btn btn-info float-right btn-md " id="advanceSearch"><i class="fas fa-search-plus"></i> Advance Search</button>
                    </div>
					<div class="table-responsive">
					    <table id="example1" class="table text-center table-hover">
    						<thead>
    							<tr>
    								<th class="text-nowrap">{{__('data.sr')}}</th>
    								@if($user_id == "1")
    								<th class="text-nowrap">{{__('data.merchant_email')}}</th>
    								@endif
    								<th class="text-nowrap">{{__('data.customerEmail')}}</th>
    								<th class="text-nowrap">{{__('data.cname')}}</th>
    								<th class="text-nowrap">{{__('data.transId')}}</th>
    								<th class="text-nowrap">{{__('data.orderId')}}</th>
    								<th class="text-nowrap">{{__('data.amount')}}</th>
    								<th class="text-nowrap">{{__('data.currency')}}</th>
    								<th class="text-nowrap">{{__('data.status')}}</th>
    								<th class="text-nowrap">{{__('data.paymentType')}}</th>
    								<th class="text-nowrap">{{__('data.action')}}</th>
    								<th class="text-nowrap">{{__('data.date')}}</th>
    								
    							</tr>
    						</thead>
    						<tbody>
    							@if(count($transactions))
    								@foreach($transactions as $transaction)
    									<tr>
    										<td>{{ $loop->iteration }}</td>
    										@if($user_id == "1")
    										<td>{{ $transaction->email }}</td>
    										@endif
    										<td>{{ $transaction->customer_email }}</td>
    										<td>{{ $transaction->customer_name }}</td>
    										<td style="word-break:break-all">{{ $transaction->deposit_id }}</td>
    										<td>{{ $transaction->order_id }}</td>
    										<td>{{ number_format($transaction->quantity,2) }}</td>
    										<td>{{ $transaction->currency_symbol }}</td>
    										<td>{{ $transaction->status }}</td>
    										<td>{{ $transaction->payment_Type }}</td>
    										<td>
    										    @if($transaction->payment_Type=="BACS")
            										   <div id="form-div">
            										    <input type="hidden" value="{{ $user_id }}" id="user_id" name="user_id"/>
            										    <input type="hidden" value="{{ $transaction->order_id }}" id="order_id" name="order_id"/>
            										    <input type="hidden" value="{{ $transaction->deposit_id }}" id="deposit_id" name="deposit_id"/>
            										    <input type="hidden" value="{{ $transaction->customer_email }}" id="customer_email" name="customer_email"/>
            										    <input type="hidden" value="{{ $transaction->status }}" id="status" name="status"/>
            										    <input type="hidden" value="{{ $transaction->currency_symbol }}" id="currency_symbol" name="currency_symbol"/>
            										    <input type="hidden" value="{{ $transaction->quantity }}" id="quantity" name="quantity"/>
            										    <input type="hidden" value="{{ $transaction->created_at }}" id="created_at" name="created_at"/>
            										    <input type="hidden" value="{{ $transaction->receipt }}" id="receipt" name="receipt"/>
            										    <input type="hidden" value="{{ $transaction->customer_id_image }}" id="customer_id_image" name="customer_id_image"/>
            										   </div>
            										    <button type="button" class="btn btn-info" onclick="assign_data_to_model(this)" data-toggle="modal" data-target="#viewDetail"><i class="fa fa-eye"></i></button>
    										    @else
    										        --
    										    @endif
    										</td>
    										<td>{{ $transaction->created_at }}</td>
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
	
<div class="modal fade" id="viewDetail" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div ><button type="button" class="close" data-dismiss="modal">&times;</button></div>
        <div class="d-flex justify-content-between px-4"><p class="cardHead mb-0"><b>Transaction Detail</b></p><span id="status_m" class=""></span></div>
        <div class="modal-body px-4 py-2">
          <p class="cardHeadp1"><b>You have successfully submit this transaction.</b>  </p>
          <p class="cardHeadp2">The order no. <b><span id="deposit_id_m"></span></b> was placed on <b><span id="created_at_m"></span></b>.</p>
          
          <p class="mb-0 cardHeadp3">TRANSACTION DETAIL</p>
          <div class="container-fluid">
              <form action="/reuploadImages" method="post" enctype="multipart/form-data" >
                  <div class="row border" style="border-radius:5px;">
                      <div class="col-5" style="color:gray;">
                        <p class="pl-3 py-2 mb-0">User Id</p>  
                        <p class="pl-3 py-2 mb-0">Order Id</p> 
                        <p class="pl-3 py-2 mb-0">Customer Email</p> 
                        <p class="pl-3 py-2 mb-0">Amount</p>
                        
                        
                      </div>
                      <div class="col-7 border-left px-0">
                        <p id="user_id_m" class="pl-3 py-2 mb-0 border-bottom"></p>  
                        <p id="order_id_m" class="pl-3 py-2 mb-0 border-bottom"></p> 
                        <p id="customer_email_m" class="pl-3 py-2 mb-0 border-bottom"></p>  
                        <p class="pl-3 py-2 border-bottom"><span id="quantity_m"></span><span id="currency_symbol_m"></span> </p>
                      </div>
                      <div class="col-5"><p class="pl-3 py-2 mb-0" style="color:gray;">Transaction ID Image</p></div>
                      <div class="col-7 border-left px-0">
                        <div class="d-flex justify-content-center">
                            @csrf()
                            <input type="hidden" value="" id="order_id_m_m" name="order_id_m_m"/>
						    <input type="hidden" value="" id="deposit_id_m_m" name="deposit_id_m_m"/>
						    <input type="hidden" value="" id="customer_email_m_m" name="customer_email_m_m"/>
						    
                            <p id="" class="pl-3 py-2 mb-0">
                                <img class="img-fluid mb-2" width="100" id="receipt_m" height="100" src="https://dev.quikipay.com/storage/receipts/index.png">
                                 @if(!auth()->user()->can('isAdmin'))
                                <input type="file" id="pic1" name="pic1" accept="image/png, image/jpeg">
                                  @endif
                            </p>
                            
                            <p id="" class="pl-3 py-2 mb-0">
                                <img class="img-fluid mb-2" width="100" id="customer_id_image_m" height="100" src="https://dev.quikipay.com/storage/receipts/index.png">
                               @if(!auth()->user()->can('isAdmin'))
                                <input type="file" id="pic2" name="pic2" accept="image/png, image/jpeg">
                                @endif
                            </p>

                        </div>
                      </div>
                      @if(!auth()->user()->can('isAdmin'))
                      <div class="col-12">
                          <div class="p-3">
                              <button class="btn-block btn btn-success">{{__('data.submit')}}</button>
                          </div>
                      </div>
                      @endif
                  </div>
              </form>
          </div>
          <p class="cardHeadp4">Transaction has been submit at <span id="created_at_m_m"></span>.</p>
        </div>
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
<script>
    function assign_data_to_model(x){
      
        var form_data=x.previousElementSibling;

        document.getElementById("customer_email_m_m").value = form_data.querySelector("#customer_email").value;
        document.getElementById("order_id_m_m").value = form_data.querySelector("#order_id").value;
        document.getElementById("deposit_id_m_m").value = form_data.querySelector("#deposit_id").value;
        document.getElementById("user_id_m").innerHTML = form_data.querySelector("#user_id").value;
        document.getElementById("order_id_m").innerHTML = form_data.querySelector("#order_id").value;
        document.getElementById("deposit_id_m").innerHTML = form_data.querySelector("#deposit_id").value;
        document.getElementById("customer_email_m").innerHTML = form_data.querySelector("#customer_email").value;
        document.getElementById("currency_symbol_m").innerHTML = form_data.querySelector("#currency_symbol").value;
        document.getElementById("quantity_m").innerHTML = form_data.querySelector("#quantity").value;
        document.getElementById("status_m").innerHTML =  form_data.querySelector("#status").value;
        document.getElementById("created_at_m").innerHTML = form_data.querySelector("#created_at").value;
        document.getElementById("created_at_m_m").innerHTML = form_data.querySelector("#created_at").value;
        
        if(form_data.querySelector("#receipt").value.length>0)
        {   
            document.getElementById("receipt_m").src  = "https://dev.quikipay.com/storage/"+form_data.querySelector("#receipt").value;
            console.log("if");
        }
        else
        {
            document.getElementById("receipt_m").src  = "https://dev.quikipay.com/storage/receipts/index.png";
            console.log("else");
        }
        
        if(form_data.querySelector("#customer_id_image").value.length>0)
        document.getElementById("customer_id_image_m").src = "https://dev.quikipay.com/storage/"+form_data.querySelector("#customer_id_image").value;
        else
        document.getElementById("customer_id_image_m").src  = "https://dev.quikipay.com/storage/receipts/index.png";
    
        var statusElement = form_data.querySelector("#status").value;
        var statusm = document.getElementById("status_m");
        
        if(statusElement == "PENDING") {
            statusm.setAttribute("class", "bg-info");
        }
        if(statusElement == "REJECT") {
            statusm.setAttribute("class", "bg-danger");
        }
        if(statusElement == "COMPLETED") {
            statusm.setAttribute("class", "success"); 
        }
    }
    function readURL(input , x) {
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        
            reader.onload = function(e) {
                document.getElementById(x).src = e.target.result;
            } 
        
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#pic2").change(function() {
      readURL(this , "customer_id_image_m");
    });
    $("#pic1").change(function() {
      readURL(this , "receipt_m");
    });

	</script>	
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