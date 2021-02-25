{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>Transactions</h1>
@stop

@section('content')
	
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog  modal-md" role="document">
    <div class="text-right button-outer">
        <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">
          <b><span aria-hidden="true">&times;</span></b>
        </button>
    </div>
    <div class="modal-content p-4">
      
      <div class="modal-body pt-3">
          <h5 class="modal-title pb-3 text1" id="exampleModalLabel"><b>Withdrawal Information</b></h5>
           <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Name: </label>
                      <h6> {{ $withdrawal->customer->name }}</h6>
                    </div>
                </div>
                <div class="col-md-6">
                <!-- /.form-group -->
                    <div class="form-group">
                        <label>Currency: </label>
                        <h6> {{ $withdrawal->currency }}</h6>
                    </div>
                <!-- /.form-group -->
                </div>
              <!-- /.col -->
              <div class="col-md-6">
                    <div class="form-group">
                        <label>Amount: </label>
                        <h6> {{ number_format($withdrawal->amount) }}</h6>
                    </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                    <div class="form-group">
                        <label>Status: </label>
                        <h6> {{ $withdrawal->status }}</h6>
                    </div>
                <!-- /.form-group -->
               </div>
              <!-- /.col -->
            </div>
         
          
       @if($withdrawal->bank == 'local_bank')
        <div class="row">
            <!--<div class="col-md-6">-->
            <!--    <div class="form-group">-->
            <!--      <label>Country:</label>-->
            <!--      <h6>{{ $withdrawal->getBank->country }}</h6>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-md-6">
                <div class="form-group">
                  <label>Bank Name:</label>
                  <h6>{{ $withdrawal->getBank->bank_name }}</h6>
                </div>
            </div>
            <div class="col-md-6">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Account Type:</label>
                  <h6>{{ $withdrawal->getBank->account_type }}</h6>
                </div>
                <!-- /.form-group -->
            </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Bank Account Number:</label>
                  <h6>{{ $withdrawal->getBank->bank_account_number }}</h6>
                </div>
                <!-- /.form-group -->
               
              </div>
              <!-- /.col -->
            </div>
            
       @elseif($withdrawal->bank == "international_bank")
         <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Bank Name:</label>
                  <h6>{{ $withdrawal->getBank->bank_name }}</h6>
                </div>
                
                </div>
                <div class="col-md-6">
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Address:</label>
                  <h6>{{ $withdrawal->getBank->address }}</h6>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>City:</label>
                  <h6>{{ $withdrawal->getBank->city }}</h6>
                </div>
                <!-- /.form-group -->
                
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Country:</label>
                  <h6>{{ $withdrawal->getBank->country }}</h6>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
               <div class="col-md-6">
                <div class="form-group">
                  <label>IBAN:</label>
                  <h6>{{ $withdrawal->getBank->iban }}</h6>
                </div>
                <!-- /.form-group -->
                
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Swift Code:</label>
                  <h6>{{ $withdrawal->getBank->swift_code }}</h6>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account Title:</label>
                  <h6>{{ $withdrawal->getBank->account_title }}</h6>
                </div>
                <!-- /.form-group -->
                
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Account Number:</label>
                  <h6>{{ $withdrawal->getBank->account_number }}</h6>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            
        @elseif($withdrawal->bank == 'paypal')
            <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Email:</label>
                      <h6>{{ $withdrawal->getBank->email }}</h6>
                    </div>
                </div>
            </div>

        @elseif($withdrawal->bank == 'crypto')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Crypto Currency:</label>
                      <h6>{{ $withdrawal->getBank->crypto_currency }}</h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Crypto Address:</label>
                      <h6>{{ $withdrawal->getBank->crypto_address }}</h6>
                    </div>
                </div>
            </div>
            
       
       @endif
      </div>
    </div>
  </div>
</div>
</div>
@stop

@section('css')
	<style>
        .text1{
            color:#4e4d4d;
        }
        #exampleModal label{
            color:#4e4d4d;
        }
        #exampleModal h6{
            color:gray;
            overflow-wrap: break-word;
        }
        #exampleModal .button-outer{
            position: relative;
            top: 19px;
            z-index: 1;
            right: -10px;
        }
        
        #exampleModal .button-outer button{
            border: none;
            padding: 1px 15px;
            font-size: 30px;
            color: #4e4d4d;
            background-color: #ffffff;
            border-radius: 25px;
            box-shadow: 0px 0px 2px 0px rgb(191 180 191);
        }
        #exampleModal .modal-content{
            border-radius: 10px;
        }
	</style>

@stop

@section('js')
	<script> 
	  $(document).ready(function(){
	        $('#exampleModal').modal('show'); 
	    });
	    
	    
	    $('#exampleModal').on('hidden.bs.modal',function(){
	        window.history.go(-1);
	    });
	    
		console.log('Hi!'); 
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
		});
	</script>
@stop