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
	
    </head>
    <body style="background: rgb(255,255,255);   background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(252,96,10,1) 0%, rgba(239,19,106,1) 72%);  text-align: center; padding-bottom:40px">
        <img src="https://dev.quikipay.com/payImages/logox.png" style="text-align: center; margin-top: 30px;">
        <table style="border-radius: 10px; background-color: white; margin-top: 3%; width: 90%; margin-left: 5%; margin-right:5%; font-family: sans-serif;" id="responsive">
            <tbody>
                <tr>
                    <td>
                        <div style="padding: 20px 5% 10px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:16px;">
                            <center><img src="https://dev.quikipay.com/payImages/Group60.png" style="padding-bottom: 10px;height:100px; width:100px;"></center>
                            <br>
                            {{__('text.hi')}},
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div style="padding: 5px 5% 5px 5%; text-align:left; color: #707070; font-family: sans-serif !important;  font-size:16px;">
                            {{
                                __('text.bacsrejected', [
                                    'orderid' => $bank_info->tx_id,
                                    'amount' => number_format($bank_info->amount, 6),
                                    'currency' => $bank_info->currency_symbol,
                                    'rejected' => $bank_info->rejected_reason,
                                ])
                            }}
                            <span>Quikipay</span> 
                        </div>
                    </td>
                    
                </tr>
                
                <tr>
                    <td>
                        <div style="padding: 0 5% 10px 5%; text-align:center;">
                            <a href="#" style=" color: #707070; font-family: sans-serif !important; font-size:16px;">www.quikipay.com</a>
                        </div>
                    </td>
                </tr> 
            </tbody>
        </table>
    </body>
</html>