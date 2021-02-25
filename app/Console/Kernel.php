<?php

namespace App\Console;

use App\User;
use App\Order;

use App\Mail\OrderPlacedMerchant;
use App\Mail\OrderPlacedAdmin;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Helper\Helper;
use App\CurrencyConversion;
use App\Transaction;
use App\Payment;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $schedule->call(function () {
          $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRates";
        $raw = "";
        $contentHash = hash('sha512', $raw);
        $current_timestamp = '""';
        $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
        $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
        
        $response = Http::withHeaders([
                'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                'Api-Timestamp' => $current_timestamp,
                'Api-Content-Hash' => $contentHash,
                'Api-Signature' => $apiSignature,
                'Content-Type' => 'application/json'
            ])->get($endpoint);
        $response = json_decode($response->getBody());
        
        DB::table('fiatrates')
                ->where('id','1')
                ->update([
                    'rate' => $response[0]->rate,
                    ]);
        
        DB::table('fiatrates')
                ->where('id','4')
                ->update([
                    'rate' => $response[1]->rate,
                    ]);
                    
        DB::table('fiatrates')
                ->where('id','3')
                ->update([
                    'rate' => $response[2]->rate,
                    ]);
        
        $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRateForEUR";
        $raw = "";
        $contentHash = hash('sha512', $raw);
        $current_timestamp = '""';
        $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
        $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
        
        $response = Http::withHeaders([
                'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                'Api-Timestamp' => $current_timestamp,
                'Api-Content-Hash' => $contentHash,
                'Api-Signature' => $apiSignature,
                'Content-Type' => 'application/json'
            ])->get($endpoint);
        $response = json_decode($response->getBody());
         DB::table('fiatrates')
                ->where('id','5')
                ->update([
                    'rate' => $response[0]->rate,
                    ]);
                    
        
            $transactions = DB::table('transactions')->where('status', 'PENDING')->get();
            
           
            foreach($transactions as $transaction){
                $endpoint = "https://api.ibitt.co/v2/account/deposit/close";
                
                $raw = "";
                $contentHash = hash('sha512', $raw);
                $current_timestamp = '""';
                $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
                $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
                
                $response = Http::withHeaders([
                            'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                            'Api-Timestamp' => $current_timestamp,
                            'Api-Content-Hash' => $contentHash,
                            'Api-Signature' => $apiSignature
                        ])->get($endpoint);
                $response = json_decode($response->getBody());
                
                foreach($response as $value){
                    if($transaction->currency_symbol=="ETH" or $transaction->currency_symbol=="USDT"){
                        if($value->id!=$transaction->deposit_id){
                            continue;
                            Log::info("inside if ETH if");
                        }
                        
                        
                    }else{
                        if($value->tx_id != $transaction->deposit_id ){
                            continue;
                            Log::info("inside if Other if");
                        }
                    }
                    Log::info('Inside foreach right place!', ['deposit_id' => $transaction->deposit_id, 'tx_id' => $value->tx_id]);
                    
                    if($transaction->currency_symbol=="BTC"){
                        $minus="0.000081";
                    }else if($transaction->currency_symbol=="USDT"){
                        $minus="2";
                    }elseif($transaction->currency_symbol=="ETH"){
                        $minus="0.0032";
                    }else{
                        $minus="3";
                    }
                    $endpoint = "https://api.ibitt.co/v2/market/orders";
                    if($transaction->second_currency == 'SOL') {
                        $data = array(
                            "market_symbol" => $transaction->currency_symbol . '-PEN',
                            "direction" => "SELL",
                            "type" => "MARKET",
                            "quantity" => $transaction->quantity-$minus,
                            "limit" => 20000
                        );
                    } else {
                        $data = array(
                            "market_symbol" => $transaction->currency_symbol . '-' . $transaction->second_currency,
                            "direction" => "SELL",
                            "type" => "MARKET",
                            "quantity" => $transaction->quantity-$minus,
                            "limit" => 20000
                        );
                    }
                    // dd($data);
                    $raw = json_encode($data);
                    $contentHash = hash('sha512', $raw);
                    $current_timestamp = '""';
                    $preSign = "POST|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
                    $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
                    
                    $response = Http::withHeaders([
                            'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                            'Api-Timestamp' => $current_timestamp,
                            'Api-Content-Hash' => $contentHash,
                            'Api-Signature' => $apiSignature,
                            'Content-Type' => 'application/json'
                        ])->post($endpoint, $data);
                    $response = json_decode($response->getBody());
                    
                    if(!isset($response->error_code)){
                        $order = new Order;
                        
                        $order->user_id = $transaction->user_id;
                        $order->order_id = $response->id;
                        $order->market_symbol = $response->market_symbol;
                        $order->direction = $response->direction;
                        $order->quantity = $response->quantity;
                        $order->value = $response->value;
                        $order->status = $response->status;
                        $order->order_created_at = date('Y-m-d H:i:s', strtotime($response->created_at));
                        
                        $order->save();
                        
                        list($crypto, $local) = explode('-', $response->market_symbol);
                        $order->from = $order->quantity . ' ' . $crypto;
                        $order->to = $order->value . ' ' . $local;
                        
                        $user = User::find($order->user_id);
                        $admin = User::find(1);
                        
                       
                
                        $response_rate=Helper::getrates(); 
                        $collection = collect($response_rate);
                        $keyed = $collection->mapWithKeys(function ($item) {
                            return [$item->currency_symbol => $item->rate];
                        });
                      
                         $fees=Helper::fees_calculate($transaction->user_id,$transaction->second_currency,'crypto',$response->value); 
                        $mercant_increment=$response->value-$fees;
                        
                        $report = array(
                            'user_id' => $transaction->user_id,
                            'order_id'=> $transaction->order_id,
                            'transaction_id' => $transaction->deposit_id,
                            'fees' => $fees,
                            'total_amount' => $response->value,
                            'currency_symbol' =>  $transaction->currency_symbol,
                            'type' => 'crypto',
                            'fx_rate'=>$keyed[$transaction->currency_symbol].'x'.$transaction->currency_symbol.'= 1USD',
                            );
                        DB::table('transaction_reports')->insert($report);
                        
                        
                        //  if($local == 'PEN'){
                        //     $user->wallet()->increment('sol', $response->value);
                        // } else {
                        //     $user->wallet()->increment(strtolower($local), $response->value);
                        // }
                        if($local == 'PEN'){
                            $user->wallet()->increment('sol', $mercant_increment);
                        } else {
                            $user->wallet()->increment(strtolower($local), $mercant_increment);
                        }
                        
                        Mail::to($user->email)->queue( new OrderPlacedMerchant($order) );
                        
                        $order->user = $user->name;
                        Mail::to($admin->email)->queue( new OrderPlacedAdmin($order) );
                        
                         
                        $transactions=DB::table('transactions')->where('id', $transaction->id)->update(['status' => 'COMPLETED']);
                        
                        
                        
                        Log::info('API POST market/orders success.', ['order_id' => $order->id]);
                    } else {
                        Log::info('API POST market/orders failed.', ['error_code' => $response->error_code, 'error_message' => $response->error_message]);
                    }
                    
                    break;
                    // $mail = Mail::to(session('customer_email'))->cc(['luca@prosperpoints.cl', User::find(session('order.merchant_id'))->email])->queue( new TransactionCompleted($transaction) );
                }
            }
                 
        })->everyThirtyMinutes();
        $schedule->call(function () {
            
            $date = new \DateTime();
           $date->modify('-168 hours');
            $formatted_date = $date->format('Y-m-d H:i:s');
           $orders=DB::table('bacs_transactions')->where('status','=','pending')->where('created_at','<',$formatted_date)->get();
           // Log::info("data",["data"=>$orders]);
            foreach($orders as $order){
                    $order->status="reject";
                    $order->rejected_reason="Timout";
                    $orderss = (array) $order;
                  DB::table('bacs_transactions_deleted_orders')->insert($orderss);
                  DB::table('bacs_transactions')->where('id','=',$order->id)->update(['status'=>'reject','rejected_reason'=>'Timeout']);
                  Transaction::where('deposit_id', $order->tx_id)->update(['status'=>'REJECT']);
                 $post = array(
                    'tx_id' => $order->tx_id,
                    'payment_method' => 'fiat',
                    'order_id' => $order->order_id,
                    'currency_symbol' => $order->currency_symbol,
                    'customer_name' => $order->customer_name,
                    'quantity' => $order->quantity,
                    'deposit_at' => $order->created_at,
                    'status' => 'reject',
                    'customer_email' => $order->customer_email
                    );
                  Log::info('webhook is sent for reject', ['data' => $post]);
                    $payment = Payment::where(['merchant' => $order->user_id, 'order_id' => $order->order_id])->first();
                if($payment){
                    $endpoint = $payment->site_url . '/wp-json/quikipay/v1/order/' . $bacs_transaction->order_id.'?status=completed';
                    $webhook_endpoint = $payment->redirect;
                    $response_webhook = Http::post($webhook_endpoint, $post);
                    $response_webhook = json_decode($response_webhook->getBody());
                } else {
                    $endpoint = $bacs_transaction->user->coinSettings->success_url_fiat;
                }
                $response = Http::get($endpoint, $post);
                $response = json_decode($response->getBody());
                 }
            
        })->daily();
        
         $schedule->call(function () {
            $coin_settings = DB::table('coin_settings')->orWhere('arsToUsd', '1')->orWhere('clpToUsd', '1')->orWhere('solToUsd', '1')->get();
            foreach($coin_settings as $coin_setting){
               $user= DB::table("wallets")->orwhere('ars','>','0')->orwhere('clp','>','0')->orwhere('sol','>','0')->where('user_id',$coin_setting->user_id)->get();
                 $currencies=array();
            if($coin_setting->arsToUsd=="1" and $user[0]->ars>"0"){
                array_push($currencies,'ARS');
                } 
                if($coin_setting->clpToUsd=="1" and $user[0]->clp>"0"){
                     array_push($currencies,'CLP');
                } 
                if($coin_setting->solToUsd=="1" and $user[0]->sol>"0"){
                     array_push($currencies,'SOL');
                } 
            $responses = [];
            $old_balance = [];
            $converted = [];
            $success = null;
            $errors = null;
            foreach($currencies as $currency){
                $balance = strtolower($currency);
                $old_balance[$balance] = $user[0]->$balance;
                if(!$user[0]->$balance){
                    $converted[$balance . '_converted'] = 0;
                    continue;
                }
                 $response_rate=Helper::getrates(); 
                        $collection = collect($response_rate);
                        $keyed = $collection->mapWithKeys(function ($item) {
                            return [$item->currency_symbol => $item->rate];
                        });
                $fees=Helper::fees_calculate($user[0]->id,strtoupper($currency),'conversion',$user[0]->$balance); 
                $mercant_increment=$user[0]->$balance-$fees;
                $currency_rate=$keyed[strtoupper($balance)];
                $balance_quantity_received_USD=$mercant_increment/$currency_rate;
                    $order = new CurrencyConversion;
                    $order->user_id = $user[0]->id;
                    $order->conversion_id = rand();
                    $order->from_currency = $currency;
                    $order->to_currency = 'USD';
                    $order->received_usd = $balance_quantity_received_USD;
                    $order->taken_fiat = $user[0]->$balance;
                    $order->rate = $currency_rate;
                    $order->status = 'Completed';
                    $order->completed_on = date('Y-m-d H:i:s', strtotime('now'));
                    $order->save();
                        $report = array(
                            'user_id' => $user[0]->id,
                            'order_id'=> rand(),
                            'transaction_id' => rand(),
                            'fees' => $fees,
                            'total_amount' =>$user[0]->$balance,
                            'currency_symbol' =>  $currency,
                            'type' => 'conversion',
                            'fx_rate'=>$keyed[strtoupper($currency)].'x'.$currency.'= 1USD',
                            );
                        DB::table('transaction_reports')->insert($report);
                    $userdata = User::find($user[0]->id);
                    $userdata->wallet()->increment('usd', $balance_quantity_received_USD);
                    if($currency  == 'PEN'){
                        $userdata->wallet()->decrement('sol', $user[0]->$balance);
                    } else {
                        $userdata->wallet()->decrement(strtolower($currency), $user[0]->$balance);
                    }
                }  
            }
            
        })->daily();
        
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
