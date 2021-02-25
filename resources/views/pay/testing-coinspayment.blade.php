<?php

$private_key = 'c16B6669Ee9229eE20838E69ead4402Fd507021D58E6612AaD3Ecb22D8Ada730';
$public_key = '21ac1b8c4f5ae0089916930b4393336f9f66ddbbd755533721a2c952a7394303';

         

     $endpoint = "https://www.coinpayments.net/api.php";
        
         $data = [
            'version' => 1,
            'key' => $public_key,
            'cmd' => "get_basic_info"
        ];
            
            //$fields['amount'] = "1";
            // $fields['currency1'] = "BTC";
            // $fields['currency2'] = "BTC";
            // $fields['buyer_email'] = "haideralimughalers@gmail.com";
            // $fields['address'] = "1M2qz2Dy4ZxnDvZF72s6jwauFb6UN6jjrR";
           
            
            $post_fields = http_build_query($data, '', '&');

            // Generate the HMAC hash from the query string and private key
            $hmac = hash_hmac('sha512', $post_fields, $private_key);


        $response = Http::withHeaders([
                'HMAC' => $hmac
            ])->post($endpoint, $data);
            
        $response = json_decode($response->getBody());
        print_r($response);
?>