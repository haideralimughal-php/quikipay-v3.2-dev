<style>
     body
    {
        background: rgb(225,104,24);
        background: linear-gradient(180deg, rgba(225,104,24,1) 0%, rgba(220,67,70,1) 53%, rgba(213,32,113,1) 100%);
        background-size:cover;
        background-origin: border-box;
        background-repeat: no-repeat;
        font-family: raleway !important;
        
    }
    .upper
    {
        background: rgb(254,99,7);
        background: linear-gradient(90deg, rgba(254,99,7,1) 0%, rgba(246,57,61,1) 50%, rgba(239,19,107,1) 100%);
        border-radius:15px;
    }
    .payment_form
    {
       border-radius:16px; 
    }
    .payment_btn
    {
       text-align:left !important;
       -webkit-box-shadow: 0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        -moz-box-shadow:    0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        box-shadow:         0px 0px 6px 0px rgba(196, 196, 196, 0.75);
        padding: 12px 10px !important;
        border-radius:12px !important;
        font-weight: bold;
        color: #717171 !important;
    }
    .payment_buttons
    {
        padding: 0% 10% 10%;
    }
    
    .flexx
    {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        
    }
    .link
    {
        border-radius: 12px !important;
        padding: 41px 0 20px 0 !important;
        font-size:12px !important;
        
    }
    .upperx
    {
        position: relative;
        top:21px;
    }
    .btn_copy
    {
        background-color: #44ce6f !important;
        font-weight:bold;
    }
    .text-color
    {
        color:#a7a7a7;
        font-size 12px
    }
    .payment
    {
        font-size:14px;
    }
    .font
    {
        font-family: roboto !important;
    }
    
</style>
@extends('layouts.pay')

@section('content')
<div class="container-fluid">
    <div class="pt-2 pb-4">
        <div class="row pt-2 pb-4">
            <div class="offset-lg-2 col-lg-8 payment text-center">
                
               <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center flexx">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                       <p  class="text-center text-white pt-2 font" >{{__('text.timeLeft')}}<br>
                       <i class="fa fa-clock"></i> &nbsp;<span id="demo"><span></p>
                   </div>
                   <div class="payment_buttons">
                       <div class="payment text-center">
                            <div class="upper upperx pt-3 pb-3 text-center">
                                <p  class="text-center text-white" style="font-size:18px;" ><b>{{ number_format($order['amount']) }} {{ $order['cur_currency'] }} </b> = <span class="text-white"><strong>{{ number_format($order['multiplied'],6) }} {{ $order['currency'] }}</strong></span></p>    
                            </div> 
                            
                            <div class="">
                                <input type="text" id="wallet_address" name="code" class="form-control text-center text-muted link" value="{{ $order['wallet']->wallet }}" readonly="">
                                <center>
                                <img  class="img-float font" height="auto" width="200"  src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ $order['wallet']->wallet }}?amount={{ number_format($order['multiplied'],6) }}&choe=UTF-8"  />
                             <button class="btn btn-lg btn-block btn_copy py-3 mt-3 text-white" onclick="myFunction()">{{__('text.copyText')}}</button>
                            </center>
                            <br>
                                @if(isset($order['wallet']->tag))
                                    Tag
                                    <input type="text" id="wallet_tag" name="tag" class="form-control text-center text-muted font" value="{{ $order['wallet']->tag }}" readonly>
                                     <img  class="img-float font" height="auto" width="150"  src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={{ $order['wallet']->tag }}&choe=UTF-8"  />
                            
                             <button class="btn btn-lg btn-block btn_copy py-3 mt-3 text-white" onclick="myFunction1()">{{__('text.copyTag')}}</button>
<br>
                                @endif
                                 <center>
                                <p  class="text-center text-color" style="font-size:16px">{{__('text.QRText')}}</p>
                            </center>
                               
                            </div>
                            
                       </div>
                   </div>
                   
                </div>
            </div>
        </div>    
    </div>
</div>

<form action="/pay/success" method="post" id="success">
    <input type="hidden" name="transaction_id" id="transactionId">
</form>
    
@endsection


<style>
    .tooltip {
  position: relative;
  display: inline-block;
}.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
@section('js')

    <script>
        $(".lang").hide();
        function myFunction() {
            /* Get the text field */
            var copyText = document.getElementById("wallet_address");
    
            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    
            /* Copy the text inside the text field */
            document.execCommand("copy");
    
            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        } 
        function myFunction1() {
            /* Get the text field */
            var copyText = document.getElementById("wallet_tag");
    
            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    
            /* Copy the text inside the text field */
            document.execCommand("copy");
    
            /* Alert the copied text */
            alert("Copied the text: " + copyText.value);
        } 
	    // Set the date we're counting down to
	
//         var dt = new Date();
//         dt.setMinutes( dt.getMinutes() + 30 );
//         var countDownDate=dt;
// 	    // Update the count down every 1 second
	    
// 	    var current_time = new Date().getTime();
	    
// 	    var x = setInterval(function() {
// 			// Get today's date and time
// 			var now = new Date().getTime();

// 			// Find the distance between now and the count down date
// 			var distance = countDownDate - now;

// 			// Time calculations for days, hours, minutes and seconds
// 			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
// 			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
// 			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
// 			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

// 			// Output the result in an element with id="demo"
// 			document.getElementById("demo").innerHTML =  minutes + ":" + seconds ;
// 			getTransactions(current_time);
// 			// If the count down is over, write some text 
// 			if (distance < 0) {
// 				clearInterval(x);
// 				document.getElementById("demo").innerHTML = "EXPIRED";
// 			}
// 		}, 1000);
		
		
		
	        var dt = new Date();
        dt.setMinutes( dt.getMinutes() + 30 );
        var countDownDate=dt;
// Update the count down every 1 second
var current_time = new Date().getTime();
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
    getTransactions(current_time);
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
	</script>
	<script>
		//$.ajax({
// 			method: "GET",
// 			url: "https://blockchain.info/tobtc",
// 			data: {currency:'USD',value:'500'},
// 			success: function (response){
// 				console.log(response);
// 			}
// 		});
		
		
		
		function getTransactions(curr_time){
		    var now = curr_time;
		    var amount = '<?php print number_format($order['multiplied'], 6); ?>';
		    var currency = "{{ $order['currency'] }}";
    		$.ajax({
    		    method: "GET",
    		    url: "/get-transactions",
    		    data: {time: now, quantity: amount, currency: currency},
    		    success: function(response){
    		        response = JSON.parse(response);
    		      //  console.log(response.transaction.id);
    		      //  console.log($("#transactionId").val());
    		        if(response.payment_status == 'COMPLETED'){
                        clearInterval(x);
                        $("#transactionId").val(response.transaction.id);
                        $("#success").submit();
                        // window.location.href = '/pay/success';
                    } else if(response.payment_status == 'CANCELED'){
                        clearInterval(x);
                        window.location.href = '/pay/fail';
                    }
    		        return response;
    		    }
    		})
		}
		
		
	</script>
@endsection