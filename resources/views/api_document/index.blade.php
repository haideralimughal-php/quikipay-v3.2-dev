<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<title>Quikipay Documentation</title>
</head>
<style>
    .main{
	background-color: #eff1f4;
	height: 100%;
    width: 100%;
    font-family: SFProText, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    font-size: 15px;
}
.side_col{
    background-color: #ffffff;
    box-shadow: 1px 0 0 0 #dae1e9;
}
.sidebar{
    font-size: 15px;
    font-weight: bold;
    width: 22%;
}

.sidebar-header{
    height: 65px;
}
.content-wrapper{
    position: relative;
    z-index: 10;
    background-color:#eff1f4;
    min-height: 100%;
    padding-bottom: 1px;
    padding-top: 80px;
}

.menu .list-group,
.menu .list-group .list-group-item{
	background: transparent;
	border:none;
}
.menu .list-group .list-group-item a{
	color: #4e5c6e;
}


.menu .list-group .list-group-item a.active {
    font-family:'Droid Sans', serif;
    font-size: 22px;
    color: #dc3545;
    text-decoration: none;
    line-height: 50px;
}
a {
    font-family:'Droid Sans', serif;
    font-size: 16px;
    color: black;
    text-decoration: none;
    line-height: 50px;
}
table, th, td {
    /*border: 1px solid black;*/
    /*border-collapse: collapse;*/
    /*font-size: 14px;*/
    /*padding: 5px;*/
    /*border-top: 1px solid black !important ;*/
    /*background-color: #ffffff;*/
  }
  .ap_code{
      background-color: #ffffff;
      /*color: #670aba;*/
  }
#home {
    background-color:#eff1f4;
    height: 100%;
    width: 100%;
}
#portfolio {
    height: 100%;
    width: 100%;
    background-color:#eff1f4;
}
#about {
    background-color:#eff1f4;
    height: 100%;
    width: 100%;
}
#contact {
    background-color:#eff1f4;
    height:100%;
    width: 100%;
}
#webhook{
    background-color:#eff1f4;
    height:100%;
    width: 100%;
}
p{
    word-break: break-all;
}
.b-radius{
	border-radius:10px;
	box-shadow:0px 0px 30px 2px rgba(201,189,201,1);
}
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    .quik{
        font-size: 19px;
        text-align: center;
    }
    .menu .list-group,
    .menu .list-group .list-group-item{
        background: transparent;
        border:none;
        padding: 0 5px;
    }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
    .quik{
        font-size: 28px;
    } 
    .menu .list-group,
    .menu .list-group .list-group-item{
        background: transparent;
        border:none;
        padding: 0 15px;
    }
}

</style>
<body>
	<section class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-md-3 d-lg-block d-md-block d-none side_col ">
					<div class="sidebar side_menu position-fixed">

						<div class="sidebar-header text-center pt-3">
							<p class="h3 text-lg-center text-danger quik">Quikipay<b class="text-dark"> - API</b></p>
						</div>
						<hr>
						<div class="menu">
							<ul class="list-group">
								<li class="list-group-item">
									<a class="active" href="#home">Process</a>
								</li>
								<li class="list-group-item">
									<a href="#api">Api Key</a>
								</li>
								<li class="list-group-item">
									<a href="#portfolio">Save Order</a>
								</li>
								<li class="list-group-item">
									<a href="#about">Fetch Order</a>
								</li>
								<li class="list-group-item">
									<a href="#fxRate">FX Rate</a>
								</li>
								<li class="list-group-item">
									<a href="#integration">Third Party</a>
								</li>
								<li class="list-group-item">
									<a href="#upload">File Stream Upload</a>
								</li>
								<li class="list-group-item">
									<a href="#contact">Document Re-upload</a>
								</li>
								<li class="list-group-item">
									<a href="#order_limit">Change Order Limit</a>
								</li>
								<li class="list-group-item">
									<a href="#webhook">Webhook</a>
								</li>
								<li class="list-group-item">
									<a href="#webhook_implement">Implement Webhook</a>
								</li>
								<li class="list-group-item">
									<a href="#error_code">Error Codes</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-12">
					<section class="content-wrapper px-lg-3 px-2">
						<div id="home">
							<div class="container py-4 px-3 bg-white b-radius">
								<div class="row">
									<div class=" col-lg-12 col-md-12 col-12">
										<p class="h3">Process</p>
										<hr>
										<ul>
											<li>Signup as merchant in dev.quikipay.com and get api key.</li>
											<li>Save order as “On Hold” status before clicking quikipay button on
												checkout page.</li>
											<li>Create a bank information page with following form fields.</li>
											<ul>
												<li>Transaction Id.</li>
												<li>Receipt image upload.</li>
												<li>Customer Identification image upload.</li>
											</ul>
											<li>Hit “Fiat Order Submit” api with all required parameters</li>
											<li>For getting information about orders, hit “get Orders” api.</li>
										</ul>
										<div class="pt-5">
											<p class="h5">API Explanation</p>
											<hr>
											<div class="container">
												<!-- <p class="font-weight-bold h6 m-0">APIS:</p> -->
												<div class="d-lg-flex d-block justify-content-start py-3">
													<a href="https://www.getpostman.com/collections/02410cafd3b3cda8e0a8">
														<div class="m-0 pl-lg-4">
															<button class="btn btn-danger" style="width:240px">Download Postman Collection</button>
														</div>
													</a>
													<a href="{{ asset('payImages/apis.zip') }}" download>
														<div class="m-0 pl-lg-4">
															<button class="btn btn-danger" style="width:240px">Download sample php code</button>
														</div>
													</a>
												</div>
												<!--<p class="pl-4">You can find the Api Key through Quikipay Merchant panel.</p>-->
												
												<!--<img src="{{ asset('payImages/api_key_Screenshot.png') }}" width=100%>-->
												<p class="font-weight-bold h6 m-0">Base URL:</p>
												<p class="pl-4">https://dev.quikipay.com/api/</p>
												<!--<p class="font-weight-bold h6">Get Token Api</p>-->
												<!--<div class="container">-->
												<!--	<p class="font-weight-bold m-0">Endpoint:</p>-->
												<!--	<p class="pl-4">/get-token</p>-->
												<!--	<p class="font-weight-bold m-0">Method:</p>-->
												<!--	<p class="pl-4">Get</p>-->
												<!--	<p class="font-weight-bold m-0">Response Body:</p>-->
												<!--	<p class="pl-4">-->
												<!--		{"token":"o6Z8EtQH5y6Q43ygAGL3iCbu4MeIgt2o3xvukHJ1"}-->
												<!--	</p>-->
												<!--</div>-->
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
						    <div id="api">
								<div class="container pt-5">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<div class="">
												<p class="h3">How to find the Api Key</p>
												<hr>
												<p class="m-0">You can find Api Key from QuikiPay Merchant panel</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="portfolio">
								<div class="container py-5">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<div class="">
												<p class="h3">Save Order</p>
												<hr>
												<p class="font-weight-bold m-0">Endpoint:</p>
												<p class="pl-4">/fiat-order</p>
												<p class="font-weight-bold m-0">Method:</p>
												<p class="pl-4">post</p>
												<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
												<!--<div class="container pl-4">-->
												<!--	<p class="m-0">X-CSRF-TOKEN: 6tm0mkXIWYDUPaj4Ue1l<br>Pnpb6di92Kic0sGPTJs6</p>-->
												<!--	<p>(It is the response you get from get-token api)</p>-->
												<!--</div>-->
												<p class="font-weight-bold">Requested Form Body:</p>
												<div class="table-responsive">
													<table class="table table-bordered bg-white">
														<tr>
															<th>Parameters</th>
															<th>Status</th>
															<th>Example</th>
															<th>Type</th>
															<th>Comments</th>
														</tr>
														<tr>
															<td>quantity</td>
															<td>Required</td>
															<td>12</td>
															<td>String</td>
															<td>Amount should be greater than 6USD.</td>
														</tr>
														<tr>
															<td>currency_symbol</td>
															<td>Required</td>
															<td>USD</td>
															<td>String</td>
															<td>USD, CLP, ARS, SOL only.
																If other than these will consider USD.
															</td>
														</tr>
														<tr>
															<td>customer_email</td>
															<td>Required</td>
															<td>abc@gmail.com</td>
															<td>String</td>
															<td>Customer email</td>
														</tr>
														<tr>
															<td>customer_name</td>
															<td>Optional</td>
															<td>John Doe</td>
															<td>String</td>
															<td>Customer name</td>
														</tr>
														<tr>
															<td>order_id</td>
															<td>Required</td>
															<td>132153</td>
															<td>String</td>
															<td>A unique order id.</td>
														</tr>
														<tr>
															<td>merchant_id</td>
															<td>Required</td>
															<td>pCyJV5OtRqmhFPS4qzLb3fSSYs6P5MoPGgUIPLeo</td>
															<td>String</td>
															<td>Merchant api key, you can find in merchant panel=>API KEY
																section.
															</td>
														</tr>
														<tr>
															<td>tx_id</td>
															<td>Required</td>
															<td>213521dsdfd3</td>
															<td>String</td>
															<td>User’s transaction id input</td>
														</tr>
														<tr>
															<td>site_url</td>
															<td>Required</td>
															<td>https://project7.erstechno.online</td>
															<td>String</td>
															<td>Website base url</td>
														</tr>
														<tr>
															<td>redirect</td>
															<td>Required</td>
															<td>https://project7.erstechno.online</td>
															<td>String</td>
															<td>A link where webhook data will send</td>
														</tr>
														<tr>
															<td>products_data</td>
															<td>Optional</td>
															<td>{"246":{"product_name":"Crypto low price","quantity":1,"price":"1000","image":"https:\/\/project7.erstechno.online\/wp-content\/uploads\/2020\/12\/71ExQm9MrUL._AC_SL1500_.jpg","currency":"CLP"},"10":{"product_name":"Test Product","quantity":2,"price":"5000","image":"https:\/\/project7.erstechno.online\/wp-content\/uploads\/woocommerce-placeholder.png","currency":"CLP"},"57":{"product_name":"Crypto","quantity":3,"price":"12","image":"","currency":"CLP"}}</td>
															<td>JSON OBJECT</td>
															<td>Detail of order, used for sending invoice with products data</td>
														</tr>
														<tr>
															<td>receipt_upload</td>
															<td>Required</td>
															<td>Image file</td>
															<td>file</td>
															<td>Multi-part data file object or array.
																(png, jpg, jpeg)
															</td>
														</tr>
														<tr>
															<td>customer_id_upload</td>
															<td>Optional</td>
															<td>Image file</td>
															<td>file</td>
															<td>Multi-part data file object or array.
																(png, jpg, jpeg)
															</td>
														</tr>
														
													</table>
												</div>
												<p class="font-weight-bold pt-3 mt-4 mb-0">Response Body:</p>
												<p class="pl-4">{"code":"200","message":"Successfully Uploaded"}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div id="about">
								<div class="container pt-2 pb-4">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<p class="h3">Fetch Orders</p>
											<hr>
											<p class="font-weight-bold m-0">Endpoint:</p>
											<p class="pl-4">/get-orders</p>
											<p class="font-weight-bold m-0">Method:</p>
											<p class="pl-4">post</p>
											<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
											<!--<p class="m-0 pl-4">X-CSRF-TOKEN: 6tm0mkXIWYDUPaj4Ue1lPnpb6di92Kic0sGPTJs6</p>-->
											<!--<p class="pl-4">(It is the response you get from get-token api)</p>-->
											<p class="font-weight-bold">Requested Form Body:</p>
											<div class="table-responsive">
												<table class="table table-bordered bg-white">
													<tr>
														<th>Parameters</th>
														<th>Status</th>
														<th>Example</th>
														<th>Type</th>
														<th>Comments</th>
													</tr>
													<tr>
														<td>merchant_id</td>
														<td>Required</td>
														<td>pCyJV5OtRqmhFPS4qzLb3fSSYs6P5MoPGgUIPLeo</td>
														<td>String</td>
														<td>Merchant api key, you can find in merchant panel=>API KEY
															section
														</td>
													</tr>
													<tr>
														<td>status</td>
														<td>Optional</td>
														<td>1</td>
														<td>String</td>
														<td>1=> COMPLETED, 0=> PENDING. 2=> REJECT</td>
													</tr>
													<tr>
														<td>order_id</td>
														<td>Optional</td>
														<td>1351sd3sd</td>
														<td>String</td>
														<td>A unique order id</td>
													</tr>
												</table>
											</div>
											<p class="font-weight-bold pt-3">Response Body:</p>
											<div class="container pl-4 ap_code">
												<p class="m-0">[{</p>
												<div class="container">
													<p class="m-0">"id": 271,</p>
													<p class="m-0">"user_id": 2,</p>
													<p class="m-0">"tx_id": "23453234",</p>
													<p class="m-0">"order_id": "268",</p>
													<p class="m-0">"currency_symbol": "CLP",</p>
													<p class="m-0">"status": "reject",</p>
													<p class="m-0">"customer_email": "abc@gmail.com",</p>
													<p class="m-0">"customer_name": "John Doe",</p>
													<p class="m-0">"created_at": "2020-12-28 20:52:38",</p>
													<p class="m-0">"quantity": 13157</p>
													<p class="m-0">"rejected_reason": "the amount is not completed"</p>
												</div>
												<p>},</p>
												<p class="m-0">{</p>
												<div class="container">
													<p class="m-0">"id": 272,</p>
													<p class="m-0">"user_id": 2,</p>
													<p class="m-0">"tx_id": "2345321434",</p>
													<p class="m-0">"order_id": "258",</p>
													<p class="m-0">"currency_symbol": "CLP",</p>
													<p class="m-0">"status": "pending",</p>
													<p class="m-0">"customer_email": "abc@gmail.com",</p>
													<p class="m-0">"customer_name": "John Doe",</p>
													<p class="m-0">"created_at": "2020-12-28 20:52:38",</p>
													<p class="m-0">"quantity": 1314457</p>
													<p class="m-0">"rejected_reason": null</p>
												</div>
												<p>},</p>
												<p class="m-0">{</p>
												<div class="container">
													<p class="m-0">"id": 2723,</p>
													<p class="m-0">"user_id": 2,</p>
													<p class="m-0">"tx_id": "2345321434rsdf34",</p>
													<p class="m-0">"order_id": "2358",</p>
													<p class="m-0">"currency_symbol": "CLP",</p>
													<p class="m-0">"status": "completed",</p>
													<p class="m-0">"customer_email": "abc@gmail.com",</p>
													<p class="m-0">"customer_name": "John Doe",</p>
													<p class="m-0">"created_at": "2020-12-28 20:52:38",</p>
													<p class="m-0">"quantity": 37</p>
													<p class="m-0">"rejected_reason": null</p>
												</div>
												<p>}]</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="fxRate">
							    <div class="container pt-4 pb-2">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<p class="h3">FX Rate</p>
											<hr>
											<!--<p class="pl-4">Through this API we can check the live FX Rates</p>-->
											<p class="font-weight-bold m-0">Endpoint:</p>
											<p class="pl-4">/fx-rates</p>
											<p class="font-weight-bold m-0">Method:</p>
											<p class="pl-4">GET</p>
											<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
											<!--<p class="m-0 pl-4">X-CSRF-TOKEN: 6tm0mkXIWYDUPaj4Ue1lPnpb6di92Kic0sGPTJs6</p>-->
											<!--<p class="pl-4">(It is the response you get from get-token api)</p>-->
											<p class="font-weight-bold">Requested Form Body:</p>
											<p class="pl-4">Not Required</p>
											<p class="font-weight-bold pt-3 m-0">Response Body:</p>
											<p class="pl-4">{"CLP":"790","ARS":"150","PEN":"3.630519","EUR":"0.903697","USD":"1"}</p>
										</div>
									</div>
								</div> 
							</div>
							<div id="integration">
								<div class="container pt-4 pb-4">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<p class="h3">Third Party</p>
											<hr>
											<p class="font-weight-bold m-0">Note:</p>
											<p class="pl-4">User required to save order as “pending” status before hit this api, </p>
											<p class="font-weight-bold m-0">Endpoint:</p>
											<p class="pl-4">/payment</p>
											<p class="font-weight-bold m-0">Method:</p>
											<p class="pl-4">post</p>
											<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
											<!--<p class="m-0 pl-4">X-CSRF-TOKEN: 6tm0mkXIWYDU<br>Paj4Ue1lPnpb6di92Kic0sGPTJs6</p>-->
											<!--<p class="pl-4">(It is the response you get from get-token api)</p>-->
											<p class="font-weight-bold">Requested Form Body:</p>
											<div class="table-responsive">
												<table class="table table-bordered bg-white">
													<tr>
														<th>Parameters</th>
														<th>Status</th>
														<th>Example</th>
														<th>Type</th>
														<th>Comments</th>
													</tr>
													<tr>
														<td>amount</td>
														<td>Required</td>
														<td>10</td>
														<td>String</td>
														<td>Value of order
														</td>
													</tr>
													<tr>
														<td>currency</td>
														<td>Required</td>
														<td>USD</td>
														<td>String</td>
														<td>Should be USD, CLP, ARS, SOL . if not system will save as USD</td>
													</tr>
													<tr>
														<td>customer_email</td>
														<td>Required</td>
														<td>abc@gmail.com</td>
														<td>String</td>
														<td>Customer Email</td>
													</tr>
													<tr>
														<td>order_id</td>
														<td>Required</td>
														<td>1sd321</td>
														<td>String</td>
														<td>System generated order ID or invoice ID</td>
													</tr>
													<tr>
														<td>merchant</td>
														<td>Required</td>
														<td>pCyJV5OtRqmhFPS4qzLb3fSSYs6P5MoPGgUIPLeo</td>
														<td>String</td>
														<td>Merchant key of Quikipay, you can get this key from Quikipay Merchant panel
														</td>
													</tr>
													<tr>
														<td>site_url</td>
														<td>Required</td>
														<td>https://project7.erstechno.online</td>
														<td>String</td>
														<td>Base URL of your Website
														</td>
													</tr>
													<tr>
														<td>redirect</td>
														<td>Required</td>
														<td>https://project7.erstechno.online/webhook</td>
														<td>String</td>
														<td>A link where webhook data will send
														</td>
													</tr>
													<tr>
														<td>products_data</td>
														<td>Required</td>
														<td>{"246": {"product_name":"Crypto low price","quantity":1,"price":"1000","image":
                                                        "https:\/\/project7.erstechno.online\/wp-content\/uploads\/2020\/12\/71ExQm9MrUL._AC_SL1500_.jpg",
                                                        "currency":"CLP"} ,"10": {"product_name":"Test Product","quantity":2,"price":"5000",
                                                        "image":"https:\/\/project7.erstechno.online\/wp-content\/uploads\/woocommerce- placeholder.png",
                                                        "currency":"CLP"},"57": {"product_name":"Crypto","quantity":3,
                                                        "price":"12","image":"","currency":"CLP"}}
                                                        </td>
														<td>JSON OBJECT</td>
														<td>Detail of order, used for sending invoice with products data
														</td>
													</tr>
												</table>
											</div>
											<p class="font-weight-bold pt-3 m-0">Response Body:</p>
											<p class="pl-4">{"payment_url": "https://dev.quikipay.com/pay/t0MmHOQGy2"}</p>
											<p class="font-weight-bold m-0">Note:</p>
											<p class="pl-4">A successful hit returns payment_url, redirect your site to payment_url, the  whole process  will continue under Quikipay server, when user will pay, quikipay sends data on “redirect” url. You may study webhook section.</p>
										</div>
									</div>
								</div>
							</div>
							<div id="upload">
								<div class="container pt-4 pb-4">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<p class="h3">File Stream Upload</p>
											<hr>
											<p class="font-weight-bold m-0">Endpoint:</p>
											<p class="pl-4">/file-stream-upload</p>
											<p class="font-weight-bold m-0">Method:</p>
											<p class="pl-4">post</p>
											<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
											<!--<p class="m-0 pl-4">X-CSRF-TOKEN: 6tm0mkXIWYDU<br>Paj4Ue1lPnpb6di92Kic0sGPTJs6</p>-->
											<!--<p class="pl-4">(It is the response you get from get-token api)</p>-->
											<p class="font-weight-bold">Requested Form Body:</p>
											<div class="table-responsive">
												<table class="table table-bordered bg-white">
													<tr>
														<th>Parameters</th>
														<th>Status</th>
														<th>Example</th>
														<th>Type</th>
														<th>Comments</th>
													</tr>
													<tr>
														<td>merchant_id</td>
														<td>Required</td>
														<td>pCyJV5OtRqmhFPS4qzLb3fSSYs6P5MoPGgUIPLeo</td>
														<td>String</td>
														<td>Merchant api key, you can find in merchant panel=>API KEY
															section
														</td>
													</tr>
													<tr>
														<td>order_id</td>
														<td>Required</td>
														<td>1351sd3sd</td>
														<td>String</td>
														<td>A unique order id</td>
													</tr>
													<tr>
														<td>customer_email</td>
														<td>Required</td>
														<td>abc@gmail.com</td>
														<td>String</td>
														<td>Customer email for sending emails</td>
													</tr>
													<tr>
														<td>receipt_upload</td>
														<td>Optional</td>
														<td>receipt_upload parameter value is base64 encoded uploaded file stream. The API may be tested using any online file to base64 string tool like https://www.browserling.com/tools/file-to-base64 </td>
														<td>base64 encoded</td>
														<td>Encode
														</td>
													</tr>
													<tr>
														<td>customer_id_upload</td>
														<td>Optional</td>
														<td>customer_id_upload parameter value is base64 encoded uploaded file stream. The API may be tested using any online file to base64 string tool like https://www.browserling.com/tools/file-to-base64 </td>
														<td>base64 encoded</td>
														<td>Encode
														</td>
													</tr>
												</table>
											</div>
											<p class="font-weight-bold pt-3 m-0">Response Body:</p>
											<p class="pl-4">{"code":"200","message":"Successfully Uploaded"}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="contact">
								<div class="container pt-4 pb-4">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<p class="h3">Document Re-upload</p>
											<hr>
											<p class="font-weight-bold m-0">Endpoint:</p>
											<p class="pl-4">/document-re-upload</p>
											<p class="font-weight-bold m-0">Method:</p>
											<p class="pl-4">post</p>
											<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
											<!--<p class="m-0 pl-4">X-CSRF-TOKEN: 6tm0mkXIWYDU<br>Paj4Ue1lPnpb6di92Kic0sGPTJs6</p>-->
											<!--<p class="pl-4">(It is the response you get from get-token api)</p>-->
											<p class="font-weight-bold">Requested Form Body:</p>
											<div class="table-responsive">
												<table class="table table-bordered bg-white">
													<tr>
														<th>Parameters</th>
														<th>Status</th>
														<th>Example</th>
														<th>Type</th>
														<th>Comments</th>
													</tr>
													<tr>
														<td>merchant_id</td>
														<td>Required</td>
														<td>pCyJV5OtRqmhFPS4qzLb3fSSYs6P5MoPGgUIPLeo</td>
														<td>String</td>
														<td>Merchant api key, you can find in merchant panel=>API KEY
															section
														</td>
													</tr>
													<tr>
														<td>order_id</td>
														<td>Required</td>
														<td>1351sd3sd</td>
														<td>String</td>
														<td>A unique order id</td>
													</tr>
													<tr>
														<td>customer_email</td>
														<td>Required</td>
														<td>abc@gmail.com</td>
														<td>String</td>
														<td>Customer email for sending emails</td>
													</tr>
													<tr>
														<td>receipt_upload</td>
														<td>Optional</td>
														<td>Image file</td>
														<td>file</td>
														<td>Multi-part data file object or array.
															(png, jpg, jpeg)
														</td>
													</tr>
													<tr>
														<td>customer_id_upload</td>
														<td>Optional</td>
														<td>Image file</td>
														<td>file</td>
														<td>Multi-part data file object or array.
															(png, jpg, jpeg)
														</td>
													</tr>
												</table>
											</div>
											<p class="font-weight-bold pt-3 m-0">Response Body:</p>
											<p class="pl-4">{"code":"200","message":"Successfully Uploaded"}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="order_limit">
								<div class="container pt-4 pb-2">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<p class="h3">Change Order Limit</p>
											<hr>
											<p class="font-weight-bold m-0">Endpoint:</p>
											<p class="pl-4">/ change-min-order-limit</p>
											<p class="font-weight-bold m-0">Method:</p>
											<p class="pl-4">post</p>
											<!--<p class="font-weight-bold m-0">Headers Data:</p>-->
											<!--<p class="m-0 pl-4">X-CSRF-TOKEN: 6tm0mkXIWYDUPaj4Ue1lPnpb6di92Kic0sGPTJs6</p>-->
											<!--<p class="pl-4">(It is the response you get from get-token api)</p>-->
											<p class="font-weight-bold">Requested Form Body:</p>
											<div class="table-responsive">
												<table class="table table-bordered bg-white">
													<tr>
														<th>Parameters</th>
														<th>Status</th>
														<th>Example</th>
														<th>Type</th>
														<th>Comments</th>
													</tr>
													<tr>
														<td>merchant_id</td>
														<td>Required</td>
														<td>pCyJV5OtRqmhFPS4qzLb3fSSYs6P5MoPGgUIPLeo</td>
														<td>String</td>
														<td>Merchant api key, you can find in merchant panel=>API KEY section
														</td>
													</tr>
													<tr>
														<td>limit</td>
														<td>Required</td>
														<td>6</td>
														<td>integer</td>
														<td>Minimum order limit in USD</td>
													</tr>
												</table>
											</div>
											<p class="font-weight-bold pt-3 m-0">Response Body:</p>
											<p class="pl-4">{"code":"200","message":"Successfully Uploaded"}</p>
										</div>
									</div>
								</div>
							</div>
							<div id="webhook">
								<div class="container py-5">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<div class="">
											    <p class="h3">Webhook</p>
    											<hr>
    											<p class="m-0">Quikipay allows our customers to use well generated webhook, its
    												implementation is quite easy.</p>
    											<p class="mt-0">“Redirect” parameter is the url where quikipay triggered webhook
    												data in POST method request.</p>
    											
												<p class="pt-3">Webhook makes it easier to integrate with Quikipay by allowing you to subscribe to a set of orders. You can subscribe to the webhook by sending <b>return <br>URL </b>(where you want to get webhook data) in <b>“redirect”</b> parameter of “FIAT-ORDER” api .</p>
												<p>e.g ” https://project7.erstechno.online/checkout/order-webhook-data-recived/” </p>
												<p class="font-weight-bold">Below is the list of all available webhook fields you will received:</p>
												<div class="container pl-4">
    												<p class="m-0">tx_id</p>
    												<p class="m-0">payment_method</p>
    												<p class="m-0">order_id</p>
    												<p class="m-0">currency_symbol</p>
    												<p class="m-0">quantity</p>
    												<p class="m-0">deposit_at</p>
    												<p class="m-0">status</p>
    												<p class="m-0">customer_email</p>
    												<p class="m-0">customer_name</p>
    											</div>
												<p class="font-weight-bold pt-4">Response you get:</p>
												<div class="container pl-4">
    												<p class="m-0">Format=> json</p>
    												<p class="m-0">Type=>POST Request </p>
    											</div>
												<p class="font-weight-bold pt-4">Sample Response (Format Json) POST request:</p>
												<p>
												{<br>
													"tx_id": "7896",<br>
													"payment_method": "fiat",<br>
													"order_id": "123",<br>
													"currency_symbol": "USD",<br>
													"quantity": 100,<br>
													"deposit_at": "2021-01-04 02:10:02",<br>
													"status": "completed",<br>
													"customer_email": "abc@gmail.com"<br>
													"customer_name": "John Doe"<br>
												}
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="webhook_implement">
								<div class="container py-5">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<div class="">
											    <p class="h3">How to implement Webhook on client side:</p>
    											<hr>
    											<p class="m-0">Create an order update function in <b>“redirect parameter url”<br> e.g:</b> https://project7.erstechno.online/checkout/order-webhook-data-recived/</p>
    											<p class="mt-0"> which can receive data and update status against order_id. You can download sample code in PHP.</p>
    											<p class="font-weight-bold">Webhook Testing:</p>
												<p>You can test webhook by using test-webhook api in postman collection</p>
												<p class="font-weight-bold">Endpoint:</p>
												<p>/ webhook</p>
												<p class="font-weight-bold">Method:</p>
												<p>post</p>
												<p class="font-weight-bold">Requested Form Body:</p>
    											<div class="table-responsive">
												<table class="table table-bordered bg-white">
													<tr>
														<th>Parameters</th>
														<th>Status</th>
														<th>Example</th>
														<th>Type</th>
														<th>Comments</th>
													</tr>
													<tr>
														<td>redirect</td>
														<td>Required</td>
														<td>https://dev.quikipay.com/api/webhook-received</td>
														<td>String</td>
														<td>url  where you want to receive data from webhook </td>
													</tr>
												</table>
												<p class="font-weight-bold">Response:</p>
												<p>
													{<br>
														"tx_id": "7896",<br>
														"payment_method": "fiat",<br>
														"order_id": "123",<br>
														"currency_symbol": "USD",<br>
														"quantity": 100,<br>
														"deposit_at": "2021-01-04 02:10:02",<br>
														"status": "completed",<br>
														"customer_email": "abc@gmail.com"<br>
													}
												</p>
											</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="error_code">
						<div class="container pt-2 pb-5">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-12 py-4 px-3 bg-white b-radius">
											<div class="">
											    <p class="h3">Error Codes</p>
    											<hr>
    											<div class="pl-4">
    											    <p>422 validation error</p>
    												<p>200 success</p>
    												<p>500 server issue</p>
    												<p>404 invalid merchant id or authentication</p>
    												<!--<p>419 invalid token</p>-->
    											</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
					</section>
				</div>
			</div>
		</div>
	</section>


</body>

<script src="https://code.jquery.com/jquery-3.4.0.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> 
<script type="text/javascript">
	$(document).ready(function () {
		$(document).on("scroll", onScroll);

		//smoothscroll
		$('a[href^="#"]').on('click', function (e) {
			e.preventDefault();
			$(document).off("scroll");

			$('a').each(function () {
				$(this).removeClass('active');
			})
			$(this).addClass('active');

			var target = this.hash,
				menu = target;
			$target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top + 2
			}, 500, 'swing', function () {
				window.location.hash = target;
				$(document).on("scroll", onScroll);
			});
		});
	});

	function onScroll(event) {
		var scrollPos = $(document).scrollTop();
		$('.menu a').each(function () {
			var currLink = $(this);
			var refElement = $(currLink.attr("href"));
			if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
				$('.menu ul li a').removeClass("active");
				currLink.addClass("active");
			}
			else {
				currLink.removeClass("active");
			}
		});
	}
</script>

</html>