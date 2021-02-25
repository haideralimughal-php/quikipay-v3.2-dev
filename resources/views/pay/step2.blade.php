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
    #alertbox .card-header{
        background: rgb(254,99,7);
        background: linear-gradient(90deg, rgba(254,99,7,1) 0%, rgba(246,57,61,1) 50%, rgba(239,19,107,1) 100%);
        border-radius: 16px;
        color:#fff;
        font-size:18px;
    }
    #alertbox .card{
        border-radius: 16px;
    }
     #alertbox .card-text{
         font-size:13px;
         color:gray;
     }
     /* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    #alertbox .card{
        width:auto;
    }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    #alertbox .card{
        width:auto;
    }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {  
    #alertbox .card{
        width:200px;
    }
}
</style>
@extends('layouts.pay')

@section('content')
<div class="container-fluid">
    <div class="pt-2 pb-4">
        <div class="row pt-2 pb-4">
            <div class=" offset-lg-2 col-lg-8 col-12 payment text-center order-lg-0 order-12" id="alertpage">
                
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
            <div class="col-lg-2 col-12 pt-lg-5 pt-0 pb-3 d-none order-lg-12 order-0" id="alertbox">
                <div class="card">
                     <div class="card-header">
                        Alert !!
                     </div>
                     <div class="card-body py-4">
                        <p class="card-text px-2">If QR Code is not loaded then disable your Add blocker.</p>
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

		
	    var dt = new Date();
        dt.setMinutes( dt.getMinutes() + 30 );
        var countDownDate=dt;
        var current_time = new Date().getTime();
        var x = setInterval(function() {
          var now = new Date().getTime();
          var distance = countDownDate - now;
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
            getTransactions(current_time);
            //faketransactions(current_time);
          if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
            window,location.href='fail';
          }
        }, 1000);
	</script>
	<script>

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
    		        if(response.payment_status != '0'){
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
		function faketransactions(curr_time){
		    var now = curr_time;
		    var amount = '<?php print number_format($order['multiplied'], 6); ?>';
		    var currency = "{{ $order['currency'] }}";
    		$.ajax({
    		    method: "GET",
    		    url: "/faketransactions",
    		    data: {time: now, quantity: amount, currency: currency},
    		    success: function(response){
    		        response = JSON.parse(response);
    		  
    		        if(response.payment_status != '0'){
                        clearInterval(x);
                        $("#transactionId").val(response.transaction.id);
                        $("#success").submit();
                       
                    } else if(response.payment_status == 'CANCELED'){
                        clearInterval(x);
                        window.location.href = '/pay/fail';
                    }
    		        return response;
    		    }
    		})
		}
		
		setTimeout(
                function(){ 
                    var alertpage = document.getElementById("alertpage");
                    var alertbox = document.getElementById("alertbox");
                    alertbox.classList.remove("d-none");
                } , 10000
            );
            
    </script>		
@if($order['currency'] == 'BTC')
    <script>
		  var wsUri = "wss://ws.blockchain.info/inv";
          var output;
        
          function init()
          {
            // output = document.getElementById("output");
            testWebSocket();
          }
        
          function testWebSocket()
          {
            websocket = new WebSocket(wsUri);
            websocket.onopen = function(evt) { onOpen(evt) };
            websocket.onclose = function(evt) { onClose(evt) };
            websocket.onmessage = function(evt) { onMessage(evt) };
            websocket.onerror = function(evt) { onError(evt) };
          }
        
          function onOpen(evt)
          {
            console.log("CONNECTED");
            // var amount = '<?php print ltrim(str_replace('.', '', number_format($order['multiplied'], 6)), '0'); ?>';
            // var str = 12345600000;
            // str = str.toString();
            // console.log(str);
            // var repl = str.replace(/^0+(\d)|(\d)0+$/gm, '$1$2');
            // console.log(repl);
            doSend('{"op":"addr_sub", "addr":"1M2qz2Dy4ZxnDvZF72s6jwauFb6UN6jjrR"}');
            // doSend('{"op":"addr_sub", "addr":"bc1q5a36hgqx8y2tjh4qrhxm4fdr7692vrzgeqfnwv"}');
          }
        
          function onClose(evt)
          {
            console.log("DISCONNECTED");
          }
        
          function onMessage(evt)
          {
             //writeToScreen('<span style="color: blue;">RESPONSE: ' + evt.data+'</span>');
            var amount = '<?php print rtrim(ltrim(str_replace('.', '', number_format($order['multiplied'], 6)), '0'), '0'); ?>';
            var now = current_time/1000;
            console.log(amount);
            console.log(now);
            console.log(JSON.parse(evt.data));
            var resp = JSON.parse(evt.data);
            
            resp.x.out.forEach(function(item, index){
                var value = item.value.toString();
                if(value.replace(/^0+(\d)|(\d)0+$/gm, '$1$2') == amount){
                    console.log('amount matched');
                    $.ajax({
                        method: "GET",
                        url: "/save-transaction",
            		    data: {resp: resp},
            		    success: function(response){
            		        console.log(response);
            		        $("#transactionId").val(response.id);
                            $("#success").submit();
            		    }
                    });
                    
                }
            });
            
            // websocket.close();
          }
        
          function onError(evt)
          {
            writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
            console.log(JSON.parse(evt.data));
        
          }
        
          function doSend(message)
          {
            console.log("SENT: " + message);
            websocket.send(message);
          }
        
          function writeToScreen(message)
          {
            var pre = document.createElement("p");
            pre.style.wordWrap = "break-word";
            pre.innerHTML = message;
            output.appendChild(pre);
          }
        
          window.addEventListener("load", init, false);
	</script>
@endif
@endsection