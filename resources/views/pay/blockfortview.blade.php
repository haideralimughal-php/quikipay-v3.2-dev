<style>
    body
    {
        background: rgb(225,104,24);
        background: linear-gradient(180deg, rgba(225,104,24,1) 0%, rgba(220,67,70,1) 53%, rgba(213,32,113,1) 100%);
        background-size:cover;
        height:auto !important;
        background-origin: border-box;
        background-repeat: no-repeat;
        font-family: sans-serif !important;
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
        padding: 10% 19% 5%;
    }
    .payment_btn:hover
    {
        background-color: #e6e6e6;
    }
    .flex
    {
        display: flex !important;
        justify-content: space-evenly;
        align-items: center;
        font-size:10px ;
    }
    .flex p
    {
        margin:0;
        font-size:10px ;
    }
    .flex .p1
    {
        font-size: 14px !important;
        font-weight: bolder;
    }
    form
    {
            margin-block-end: 0em !important;

    }
    .p2
    {
        font-family: Roboto !important;
    }
    label
    {
        margin-bottom: 3px !important;
        font-weight: 100 !important;
        float: left;
        font-size: 9px;
        color: gray;
    }
    .input-group-text-custom
    {
        background-color: white !important;
        padding-left: 7px  !important;
        padding-right: 1px !important;
    }
    .form-control:focus
    {
        border-color: #ced4da !important;
    }
    .btn-green
    {
        background-color:#44ce6f !important;
        color:white !important;
    }
    .red-border
    {
        border-color: red !important;
    }
    #error , #error1 ,#error2 ,#error3 ,#error4 
    {
        font-size:10px;
        color:red;
        text-align:left !important;
        
    }
</style>
@extends('layouts.pay')

@section('content')




             
    <div class="container-fluid">
    <div class="pt-2 pb-3">
        <div class="row pt-2 pb-3">
            <div class=" col-lg-12 payment text-center">
                <div class=" bg-white payment_form">
                   <div class="upper pt-3 pb-3 text-center">
                       <img src="{{ asset('payImages/logox.png') }}" height="auto" width="90"  class="pt-2 pb-2">
                   </div>
                   <div class="payment_buttons">
                       <form method="post" action="/pay/blockfortrequest">
                           <div class="form-group">
                            <label class="text-left">CARDHOLDER NAME</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text input-group-text-custom border-right-0" id="inputGroupPrepend"><img src="{{ asset('payImages/download.png') }}"></span>
                                </div>
                                <input type="text" name="name" id="cardholder_name" class="form-control border-left-0"  placeholder="John Smith"  onblur="nameCheck()" required>
                            </div>
                            <div id="error"></div>
                          </div>
                          <div class="form-group">
                            <label class="text-left">CARD NUMBER</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text input-group-text-custom border-right-0" id="inputGroupPrepend"><img src="{{ asset('payImages/download1.png') }}"></span>
                                </div>
                                <input type="text" onkeypress="return isNumberKey(event)" name="number" id="number" maxlength="19" size="20" autocomplete="off" class="form-control border-left-0"  placeholder="4256 1233 4566 1254" onblur="numberCheck()" required>
                            </div>
                            <div id="error1"></div>
                            <div id="cardtype"></div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-4">
                              <label class="text-left">EXPIRY MONTH</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text input-group-text-custom border-right-0" id="inputGroupPrepend"><img src="{{ asset('payImages/download2.png') }}"></span>
                                </div>
                                <input type="text" onkeypress="return isNumberKey(event)" name="expirymonth" id="expirymonth" class="form-control border-left-0"  placeholder="09" onblur="expirymonthCheck()" required>
                              </div>
                              <div id="error2"></div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="text-left">EXPIRY YEAR</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text input-group-text-custom border-right-0" id="inputGroupPrepend"><img src="{{ asset('payImages/download2.png') }}"></span>
                                </div>
                                <input type="text" onkeypress="return isNumberKey(event)" name="expiryyear" id="expiryyear" class="form-control border-left-0"  placeholder="2020" onblur="expiryyearCheck()" required>
                              </div>
                              <div id="error3"></div>
                            </div>
                            <div class="form-group col-md-4">
                              <label class="text-left">CVC</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text input-group-text-custom border-right-0" id="inputGroupPrepend"><img src="{{ asset('payImages/download3.png') }}"></span>
                                </div>
                                <input type="text" onkeypress="return isNumberKey(event)"  name="cvc" id="cvc" class="form-control border-left-0"  placeholder="123" onblur="cvcCheck()" required>
                              </div>
                              <div id="error4"></div>
                            </div>
                          </div>
                          <input type="submit" class="btn btn-green btn-block mt-4 py-3"  value="PAY">
                        </form>
                        <div class="container text-center  d-flex align-items-center justify-content-center">
                            <img src="{{ asset('payImages/visa-512.png') }}" width="70px" height="auto" class="img-fluid pt-3">
                            <img src="{{ asset('payImages/masterCard.png') }}" width="70px" height="auto" class="img-fluid pt-3 px-3">
                            <img src="{{ asset('payImages/america-Express.png') }}" width="50px" height="auto" class="img-fluid pt-3">
                        </div>
                   </div>
                </div>
            </div>
        </div>    
    </div>
</div> 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>

   
    function numberCheck()
    {
        var numberValue = document.getElementById("number").value;
        
        if( numberValue.length !=19)
        {
            document.getElementById("error1").innerHTML = "Please enter valid number";
            var element = document.getElementById("number");
            element.classList.add("red-border");
        }
        else{
            var element = document.getElementById("number");
            element.classList.remove("red-border");
            document.getElementById("error1").innerHTML = "";
        }

    }
    function space(el, after) {
        // defaults to a space after 4 characters:
        after = after || 4;
    
        var v = el.value.replace(/[^\dA-Z]/g, ''),
            reg = new RegExp(".{" + after + "}","g")
        el.value = v.replace(reg, function (a, b, c) {
            return a + ' ';
        });
    }
    function isNumberKey(evt){   
        var numberValue = document.getElementById("number").value;
        var numberV = document.getElementById("number");
        
        if(numberValue.length < 16){
            space(numberV, 4);
        }
        
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
        
    }
    function cc_brand_id(cur_val) {
    // the regular expressions check for possible matches as you type, hence the OR operators based on the number of chars
    // regexp string length {0} provided for soonest detection of beginning of the card numbers this way it could be used for BIN CODE detection also

    //JCB
    jcb_regex = new RegExp('^(?:2131|1800|35)[0-9]{0,}$'); //2131, 1800, 35 (3528-3589)
    // American Express
    amex_regex = new RegExp('^3[47][0-9]{0,}$'); //34, 37
    // Diners Club
    diners_regex = new RegExp('^3(?:0[0-59]{1}|[689])[0-9]{0,}$'); //300-305, 309, 36, 38-39
    // Visa
    visa_regex = new RegExp('^4[0-9]{0,}$'); //4
    // MasterCard
    mastercard_regex = new RegExp('^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[01]|2720)[0-9]{0,}$'); //2221-2720, 51-55
    maestro_regex = new RegExp('^(5[06789]|6)[0-9]{0,}$'); //always growing in the range: 60-69, started with / not something else, but starting 5 must be encoded as mastercard anyway
    //Discover
    discover_regex = new RegExp('^(6011|65|64[4-9]|62212[6-9]|6221[3-9]|622[2-8]|6229[01]|62292[0-5])[0-9]{0,}$');
    ////6011, 622126-622925, 644-649, 65


    // get rid of anything but numbers
    cur_val = cur_val.replace(/\D/g, '');

    // checks per each, as their could be multiple hits
    //fix: ordering matter in detection, otherwise can give false results in rare cases
    var sel_brand = "unknown";
    if (cur_val.match(jcb_regex)) {
        sel_brand = "jcb";
    } else if (cur_val.match(amex_regex)) {
        sel_brand = "amex";
    } else if (cur_val.match(diners_regex)) {
        sel_brand = "diners_club";
    } else if (cur_val.match(visa_regex)) {
        sel_brand = "visa";
    } else if (cur_val.match(mastercard_regex)) {
        sel_brand = "mastercard";
    } else if (cur_val.match(discover_regex)) {
        sel_brand = "discover";
    } else if (cur_val.match(maestro_regex)) {
        if (cur_val[0] == '5') { //started 5 must be mastercard
            sel_brand = "mastercard";
        } else {
            sel_brand = "maestro"; //maestro is all 60-69 which is not something else, thats why this condition in the end
        }
    }

    return sel_brand;
}
    function  expirymonthCheck()
    {
        var expirymonthValue = document.getElementById("expirymonth").value;
        
        if( expirymonthValue.length !=2 )
        {
            var element = document.getElementById("expirymonth");
            document.getElementById("error2").innerHTML = "Please enter valid month.";
            element.classList.add("red-border");
        }
        else
        {
            var element = document.getElementById("expirymonth");
            document.getElementById("error2").innerHTML = "";
            element.classList.remove("red-border");
        }
    }
    function  expiryyearCheck()
    {
         var expiryyearValue = document.getElementById("expiryyear").value;
         
        if( expirymonthValue.length !=4 )
        {
            var element = document.getElementById("expiryyear");
            document.getElementById("error3").innerHTML = "Please enter valid year.";
            element.classList.add("red-border");
        }
        else
        {
            var element = document.getElementById("expiryyear");
            document.getElementById("error3").innerHTML = "";
            element.classList.remove("red-border");
        }
    }
    function  cvcCheck()
    {
        var cvcValue = document.getElementById("cvc").value;
        
        if( expirymonthValue.length !=3 )
        {
            var element = document.getElementById("cvc");
            document.getElementById("error4").innerHTML = "Please enter valid cvc.";
            element.classList.add("red-border");
        }
        else
        {
            var element = document.getElementById("cvc");
            document.getElementById("error4").innerHTML = "";
            element.classList.remove("red-border");
        }
        
    }
</script>
      

@endsection
