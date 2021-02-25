<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
	<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
	<meta content="width=device-width" name="viewport"/>
	<!--[if !mso]><!-->
	<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
	<!--<![endif]-->
	<title></title>
	<!--[if !mso]><!-->
	<!--<![endif]-->
	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: separate !important;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
		
	</style>
	<!--<style id="media-query" type="text/css">-->
	<!--	@media (max-width: 540px) {-->

	<!--		.block-grid,-->
	<!--		.col {-->
	<!--			1width: 320px !important;-->
	<!--			max-width: 100% !important;-->
	<!--			display: block !important;-->
	<!--		}-->

	<!--		.block-grid {-->
	<!--			width: 100% !important;-->
	<!--		}-->

	<!--		.col {-->
	<!--			width: 100% !important;-->
	<!--		}-->

	<!--		.col>div {-->
	<!--			margin: 0 auto;-->
	<!--		}-->

	<!--		img.fullwidth,-->
	<!--		img.fullwidthOnMobile {-->
	<!--			max-width: 100% !important;-->
	<!--		}-->

	<!--		.no-stack .col {-->
	<!--			1width: 0 !important;-->
	<!--			display: table-cell !important;-->
	<!--		}-->

	<!--		.no-stack.two-up .col {-->
	<!--			width: 50% !important;-->
	<!--		}-->

	<!--		.no-stack .col.num4 {-->
	<!--			width: 33% !important;-->
	<!--		}-->

	<!--		.no-stack .col.num8 {-->
	<!--			width: 66% !important;-->
	<!--		}-->

	<!--		.no-stack .col.num4 {-->
	<!--			width: 33% !important;-->
	<!--		}-->

	<!--		.no-stack .col.num3 {-->
	<!--			width: 25% !important;-->
	<!--		}-->

	<!--		.no-stack .col.num6 {-->
	<!--			width: 50% !important;-->
	<!--		}-->

	<!--		.no-stack .col.num9 {-->
	<!--			width: 75% !important;-->
	<!--		}-->

	<!--		.video-block {-->
	<!--			max-width: none !important;-->
	<!--		}-->

	<!--		.mobile_hide {-->
	<!--			1height: 0px;-->
	<!--			max-height: 0px;-->
	<!--			max-width: 0px;-->
	<!--			display: none;-->
	<!--			overflow: hidden;-->
	<!--			font-size: 0px;-->
	<!--		}-->

	<!--		.desktop_hide {-->
	<!--			display: block !important;-->
	<!--			max-height: none !important;-->
	<!--		}-->
	<!--		#responsive-->
	<!--		{-->
	<!--		     width: 90% !important;-->
	<!--		     margin-left: 5% !important;-->
	<!--		     margin-right:5% !important; -->
	<!--		}-->
	<!--	}-->
	<!--</style>-->
    </head>
    <body style="background: rgb(255,255,255);   background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(252,96,10,1) 0%, rgba(239,19,106,1) 72%);  text-align: center; padding-bottom:40px">
        <img src="https://dev.quikipay.com/payImages/logox.png" style="text-align: center; margin-top: 30px;">
        <table style="border-radius: 10px; background-color: white; margin-top: 3%; width: 90%; margin-left: 5%; margin-right:5%; font-family: sans-serif;" id="responsive">
            <tbody>
                <tr>
                    <td>
                        <div style="padding: 20px 5% 10px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:18px;">
                            <img src="https://dev.quikipay.com/payImages/Rectangle.png" style="padding-bottom: 10px;">
                            <br>
                            {{__('text.hi')}},
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding: 5px 5% 5px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:18px;">
                            <!--Outer if determined whether its merchant or customer -->
                           
                           @if($withdrawal->customer_id)
                                
                                <!--inner if determined whether type is admin or customer -->
                               @if($withdrawal->type!="admin")
                               
                                    <!--following if determined whether bank type is local/international-->
                                     @if($withdrawal->bank=="local_bank" or $withdrawal->bank=="international_bank")
                                     {{
                                            __('text.withdrawComplete', [
                                                'bank' => $withdrawal->getBank->bank_name, 
                                                'account_number' => $withdrawal->bank == 'local_bank' ? $withdrawal->getBank->bank_account_number : $withdrawal->getBank->account_number,
                                                'name' => $withdrawal->customer->name,
                                                'amount' => $withdrawal->amount,
                                                'currency' => $withdrawal->currency
                                            ]) 
                                        }}
                                        <!--following if determined whether bank type is crypto-->
                                        @elseif($withdrawal->bank=="crypto")
                                            {{
                                                __('text.crypto_withdrawal_completed', [
                                                    'bank' => 'Cryptocurrency', 
                                                    'account_number' => $withdrawal->getBank->crypto_address,
                                                    'cryptocurrency' => $withdrawal->getBank->crypto_currency,
                                                    'fx_rate' => $withdrawal->fx_rate,
                                                    'name' => $withdrawal->customer->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                            }}
                                        <!--following if determined whether bank type is paypal-->
                                        @elseif($withdrawal->bank=="paypal")
                                            {{
                                                __('text.paypal_withdrawal_completed', [
                                                    'bank' => 'Paypal', 
                                                    'paypal_email' => $withdrawal->getBank->email,
                                                    'name' => $withdrawal->customer->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                            }}
                                        @endif
                                @else
                                    <!--following if determined whether bank type is local/international-->
                                     @if($withdrawal->bank=="local_bank" or $withdrawal->bank=="international_bank")
                                        {{
                                            __('text.withdrawComplete_admin', [
                                                'bank' => $withdrawal->getBank->bank_name, 
                                                'account_number' => $withdrawal->bank == 'local_bank' ? $withdrawal->getBank->bank_account_number : $withdrawal->getBank->account_number,
                                                'name' => $withdrawal->customer->name,
                                                'amount' => $withdrawal->amount,
                                                'currency' => $withdrawal->currency
                                            ]) 
                                        }}
                                        <!--following if determined whether bank type is crypto-->
                                        @elseif($withdrawal->bank=="crypto")
                                            {{
                                                __('text.crypto_withdrawal_completed_admin', [
                                                    'bank' => 'Cryptocurrency', 
                                                    'account_number' => $withdrawal->getBank->crypto_address,
                                                    'cryptocurrency' => $withdrawal->getBank->crypto_currency,
                                                    'fx_rate' => $withdrawal->fx_rate,
                                                    'name' => $withdrawal->customer->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                            }}
                                        <!--following if determined whether bank type is paypal-->
                                        @elseif($withdrawal->bank=="paypal")
                                        {{
                                                __('text.paypal_withdrawal_completed_admin', [
                                                    'bank' => 'Paypal', 
                                                    'paypal_email' => $withdrawal->getBank->email,
                                                    'name' => $withdrawal->customer->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                                
                                        }}
                                        @endif
    
                                @endif
                                
                            @else
                            <!--This is else of outer if which determined whether its merchant or customer -->
                            
                                <!--inner if determined whether type is admin or merchant -->
                                @if($withdrawal->type!="admin")
                                    <!--following if determined whether bank type is local/international-->
                                     @if($withdrawal->bank=="local_bank" or $withdrawal->bank=="international_bank")
                                     {{
                                            __('text.withdrawComplete', [
                                                'bank' => $withdrawal->getBank->bank_name, 
                                                'account_number' => $withdrawal->bank == 'local_bank' ? $withdrawal->getBank->bank_account_number : $withdrawal->getBank->account_number,
                                                'name' => $withdrawal->user->name,
                                                'amount' => $withdrawal->amount,
                                                'currency' => $withdrawal->currency
                                            ]) 
                                        }}
                                        <!--following if determined whether bank type is crypto-->
                                        @elseif($withdrawal->bank=="crypto")
                                            {{
                                                __('text.crypto_withdrawal_completed', [
                                                    'bank' => 'Cryptocurrency', 
                                                    'account_number' => $withdrawal->getBank->crypto_address,
                                                    'cryptocurrency' => $withdrawal->getBank->crypto_currency,
                                                    'fx_rate' => $withdrawal->fx_rate,
                                                    'name' => $withdrawal->user->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                            }}
                                        <!--following if determined whether bank type is paypal-->
                                        @elseif($withdrawal->bank=="paypal")
                                            {{
                                                __('text.paypal_withdrawal_completed', [
                                                    'bank' => 'Paypal', 
                                                    'paypal_email' => $withdrawal->getBank->email,
                                                    'name' => $withdrawal->user->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                            }}
                                        @endif
                                @else
    
                                    <!--following if determined whether bank type is local/international-->
                                     @if($withdrawal->bank=="local_bank" or $withdrawal->bank=="international_bank")
                                        {{
                                            __('text.withdrawComplete_admin', [
                                                'bank' => $withdrawal->getBank->bank_name, 
                                                'account_number' => $withdrawal->bank == 'local_bank' ? $withdrawal->getBank->bank_account_number : $withdrawal->getBank->account_number,
                                                'name' => $withdrawal->user->name,
                                                'amount' => $withdrawal->amount,
                                                'currency' => $withdrawal->currency
                                            ]) 
                                        }}
                                        <!--following if determined whether bank type is crypto-->
                                        @elseif($withdrawal->bank=="crypto")
                                            {{
                                                __('text.crypto_withdrawal_completed_admin', [
                                                    'bank' => 'Cryptocurrency', 
                                                    'account_number' => $withdrawal->getBank->crypto_address,
                                                    'cryptocurrency' => $withdrawal->getBank->crypto_currency,
                                                    'fx_rate' => $withdrawal->fx_rate,
                                                    'name' => $withdrawal->user->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                            }}
                                            <!--following if determined whether bank type is paypal-->
                                        @elseif($withdrawal->bank=="paypal")
                                        {{
                                                __('text.paypal_withdrawal_completed_admin', [
                                                    'bank' => 'Paypal', 
                                                    'paypal_email' => $withdrawal->getBank->email,
                                                    'name' => $withdrawal->user->name,
                                                    'amount' => $withdrawal->amount,
                                                    'currency' => $withdrawal->currency
                                                ]) 
                                                
                                        }}
                                        @endif
    
                                @endif
                                <!--End of inner if which determind whether its admin or merchant-->
                            @endif
                            <!--End of outer if which determind whether its merchant of customer-->
                        </div>
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        <div style="padding: 5px 5% 5px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:18px;">
                            {{__('text.PPSDE')}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding: 5px 5% 5px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:18px;">
                            {{__('text.SDEPY')}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="padding: 5px 5% 5px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:18px;">
                            {{__('text.bestRegard')}}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>