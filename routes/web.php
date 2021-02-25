<?php
use Illuminate\Support\Facades\Route;

use Carbon\Carbon;

// use Coinbase\Wallet\Client;
// use Coinbase\Wallet\Configuration;
use ccontrerasleiva\Hitespay\Hitespay;

use App\Order;
use App\Transaction;
use App\Withdrawal;
use App\BankInfo;
use App\User;
use App\Fees;
use App\CurrencyConversion;
use App\BacsTransaction;
use App\Mail\TransactionCompleted;
use App\Mail\BacsTransactionCompleted;
use App\Mail\TransactionPending;
use App\Mail\BacsTransactionPending;
use App\Mail\WithdrawPending;
use App\Mail\PayoutPending;
use App\Mail\PayoutCompleted;
use App\Mail\PayoutRejected;
use App\Mail\WithdrawRejected;
use App\Mail\WithdrawCompleted;
use App\Mail\SendTokenizedLink;
use App\Mail\SendFailForBacs;
use App\Mail\SendBankInfo;
use App\Mail\OrderPlacedMerchant;
use App\Mail\OrderPlacedAdmin;
use App\Mail\ConversionCompleted;
use App\Mail\NewUser;
use App\Mail\Invoice;
use App\Payment;
use App\Pago46\Pago46;
use Illuminate\Support\Facades\Log;
use App\Helper\Helper;
use CryptoQr\BitcoinQr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/blockchain-api', function() {
    Log::info('Blockchain API Success??', request()->all());
  
});

Route::get('/api/test', function() {
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
        
    dd($response);
});

Route::get('/get-equivalent-crypto', function(){
    
    request()->validate([
        'crypto' => ['required'],
        'fiat' => ['required'],
        'amount' => ['required'],
    ]);
    
    $crypto = request()->crypto;
    $fiat = request()->fiat;
    $amount = request()->amount;
            
    if($fiat == 'SOL'){
       $endpoint = "https://api.ibitt.co/v2/public/marketSummaries/$crypto-PEN";
    }else{
        $endpoint = "https://api.ibitt.co/v2/public/marketSummaries/$crypto-$fiat";
    }
    
    $client = new \GuzzleHttp\Client();

    try{
        $response = $client->request('GET', $endpoint);
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        dd($e->getResponse()->getBody()->getContents());
    }
    
    $statusCode = $response->getStatusCode();
    $content = $response->getBody();

    $converted = json_decode($content);
    
    $rate = 1 / $converted->bid;
    $equivalentCrypto = $rate * $amount;
    
    return response()->json(['rate' => $rate, 'equivalentCrypto' => $equivalentCrypto]);
});


Route::get('/pay/order-received/bacs/', function(){
    Log::info('Success??', ['tx_id' => request()->tx_id]);
    return view('welcome');
});


/////////Admin and Merchant Routes/////////

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/settings/profile', 'AccountController@index');
Route::get('/settings/edit', 'AccountController@edit');
Route::patch('/settings/profile', 'AccountController@update');
Route::get('/settings/security', 'AccountController@security');
Route::patch('/settings/security', 'AccountController@updateSecurity');
Route::get('/settings/bank-info', 'AccountController@bankInfo');
Route::post('/settings/bank-info', 'AccountController@storeBankInfo');

Route::get('/apikey', 'AccountController@apikey');

Route::get('/transactions', 'TransactionsController@index');
Route::post('/transactions', 'TransactionsController@specificTransactions');
Route::get('/bacs-transactions', 'TransactionsController@bacsTransactions');
Route::post('/bacs-transactions', 'TransactionsController@specificBacsTransactions');
Route::get('/customer-bacs-transactions', 'TransactionsController@customerBacsTransactions');
Route::post('/customer-bacs-transactions', 'TransactionsController@specificCustomerBacsTransactions');
Route::post('/confirm-transaction', 'TransactionsController@confirmTransaction');
Route::post('/customerconfirmTransaction', 'TransactionsController@customerconfirmTransaction');
Route::get('/confirmTransactiontesting', 'TransactionsController@confirmTransactiontesting');
Route::post('/reject-transaction', 'TransactionsController@rejectTransaction');
Route::post('/reuploadImages', 'TransactionsController@reuploadImages');
Route::post('/customerRejectTransaction', 'TransactionsController@customerRejectTransaction');
Route::post('/disapprove-transaction', 'TransactionsController@disapproveTransaction');
Route::post('/customerDisapproveTransaction', 'TransactionsController@customerDisapproveTransaction');
Route::get('/report', 'TransactionsController@transactionReports');
Route::post('/report', 'TransactionsController@specificTransactionReports');

Route::get('/shared-balances', 'SharedBalanceController@index');

Route::post('/fees_save', 'FeesController@fees_save');
Route::get('/get_fees', 'FeesController@get_fees');
Route::get('/api_document',function(){
    return view('api_document.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', 'UserController@index');
    
    //Withdrawal Routes
    Route::get('withdraw/{param}', function($param){
        // dd($param);
    $local_bank = auth()->user()->withdrawals()->where('bank', 'local_bank')->latest()->first();
    $international_bank = auth()->user()->withdrawals()->where('bank', 'international_bank')->latest()->first();
    $paypal = auth()->user()->withdrawals()->where('bank', 'paypal')->latest()->first();
    $crypto = auth()->user()->withdrawals()->where('bank', 'crypto')->latest()->first();
    $data = compact('local_bank', 'international_bank', 'paypal', 'crypto', 'param');
// dd($data);
    return view('withdraw', $data); 
});

Route::post('withdraw', function(){
    $attributes = request()->all();
 
    $attributes += ['user_id' => auth()->user()->id, 'status' => 'pending'];
  
    auth()->user()->wallet()->decrement(strtoupper(request()->currency),request()->amount);
    
    $withdrawal = new Withdrawal();
    if($withdrawal = $withdrawal->addWithdrawal($attributes)){
        
        if(request()->type=="wh"){
                $withdrawal->type="merchant";
                Mail::to(auth()->user()->email)->send( new WithdrawPending($withdrawal) );
                $withdrawal->type="admin";
                Mail::to('payment@quikipay.com')->cc(['la@quikipay.com','la@ibitt.co','fg@quickex.cl','admin@quikipay.com'])->send( new WithdrawPending($withdrawal) );
        }
        else{
            $withdrawal->type="merchant";
            Mail::to(auth()->user()->email)->send( new PayoutPending($withdrawal) );
            
            $withdrawal->type="admin";
            //Mail::to("haideralimughalers@gmail.com")->send( new PayoutPending($withdrawal) );
            Mail::to('payment@quikipay.com')->cc(['la@quikipay.com','la@ibitt.co','fg@quickex.cl','admin@quikipay.com'])->send( new PayoutPending($withdrawal) );
        }
        
        echo "<script>alert('se envía la solicitud de retiro')</script>";
        session()->flash('message', 'Withdrawal request submitted successfully!');
    } else {
        session()->flash('message', 'Withdrawal request submission failed!');
    }
    
    return back();
});

Route::get('/withdrawal-requests/{param}', function($param){
    if(auth()->user()->can('isAdmin')){
        if($param == 'wh'){
            // for withdraw history page at admin site
            $withdrawals = Withdrawal::where('status','!=', 'pending')->where('type',$param)->latest()->get();
        }else if($param == 'wr'){
            // for withdraw request page admin site
            $withdrawals = Withdrawal::where('status', 'pending')->where('type', 'wh')->latest()->get();
        }else if($param == 'pr'){
            // for Payout request page at admin site
            $withdrawals = Withdrawal::where('status', 'pending')->where('type', 'ph')->latest()->get();
        }else{
            // for Payout history page at admin site
            $withdrawals = Withdrawal::where('status','!=', 'pending')->where('type', $param)->latest()->get();
        }
    } else {
        $withdrawals = auth()->user()->withdrawals->where('type', $param);
    }
    
    return view('withdrawal-requests', compact('withdrawals','param'));
});
    
Route::post('withdrawal-modal', function(){
    $withdrawal = Withdrawal::find(request()->withdrawal_id);
    
    return view('withdrawal-modal', compact('withdrawal'));
});

Route::post('accept-withdrawal', function(){
    
    $withdrawal = Withdrawal::find(request()->withdrawal_id);
    $withdrawal->update(['status' => 'accepted']);
  
    if(request()->type=="wr"){
        //$withdrawal->type="admin";
        //Log::info("data",["data"=>$withdrawal]);
        //Mail::to("payment@quikipay.com")->cc(['la@quikipay.com','la@ibitt.co','fg@quickex.cl','admin@quikipay.com'])->queue( new WithdrawCompleted($withdrawal) );
        //$withdrawal->type="merchant";
        Log::info("data",["data"=>$withdrawal]);
        Mail::to($withdrawal->user->email)->cc([User::first()->email])->queue( new WithdrawCompleted($withdrawal) );

    }else{
        //$withdrawal->type="admin";
        //Mail::to("payment@quikipay.com")->cc(['la@quikipay.com','la@ibitt.co','fg@quickex.cl','admin@quikipay.com'])->queue( new PayoutCompleted($withdrawal) );
       // Mail::to("payment@quikipay.com")->cc([User::first()->email])->queue( new PayoutCompleted($withdrawal) );
        //$withdrawal->type="merchant";
        Mail::to(auth()->user()->email)->cc([User::first()->email])->queue( new PayoutCompleted($withdrawal) );
        //Mail::to($withdrawal->user->email)->cc(['payment@quikipay.com','la@quikipay.com','la@ibitt.co','fg@quickex.cl','admin@quikipay.com', User::first()->email])->queue( new PayoutCompleted($withdrawal) );
    
    }
    return back();
});
    
Route::post('reject-withdrawal', function(){
    
    $withdrawal = Withdrawal::find(request()->withdrawal_id);
    $withdrawal->update(['status' => 'rejected']);
     $withdrawal->user->wallet()->increment(strtolower($withdrawal->currency), $withdrawal->amount);

    if(request()->type=="pr"){
        Mail::to($withdrawal->user->email)->cc([User::first()->email])->queue( new PayoutRejected($withdrawal) );
    }
    else{
        Mail::to($withdrawal->user->email)->cc([ User::first()->email])->queue( new WithdrawRejected($withdrawal) );
    }
    return back();
});
    //End Withdrawal Routes

    //Convert Currency Routes
Route::post('convert-currency', function(Request $request){
    
   $currencies=array();
    if(isset(request()->ars_check)){
        array_push($currencies,'ARS');
        } 
        if(isset(request()->clp_check)){
             array_push($currencies,'CLP');
        } 
        if(isset(request()->sol_check)){
             array_push($currencies,'SOL');
        } 
        //dd($currencies);
    //$currencies = ['CLP', 'SOL', 'ARS'];
    $responses = [];
    $old_balance = [];
    $converted = [];
    $success = null;
    $errors = null;
    foreach($currencies as $currency){
        $balance = strtolower($currency);
      
        $old_balance[$balance] = auth()->user()->wallet->$balance;
        if(!auth()->user()->wallet->$balance){
            $converted[$balance . '_converted'] = 0;
            $errors[$balance] = trans('data.convertFailBalance', ['currency' => $balance]);
            continue;
        }
       
        $currency_rate=$_POST[$balance.'_rate'];
        $balance_quantity_received_USD=$_POST[$balance.'_amount']/$currency_rate;
    
       
            $order = new CurrencyConversion;
        
            $order->user_id = auth()->user()->id;
            $order->conversion_id = rand();
            $order->from_currency = $currency;
            $order->to_currency = 'USD';
            $order->received_usd = $balance_quantity_received_USD;
            //$order->taken_fiat = auth()->user()->wallet->$balance;
            $order->taken_fiat =$_POST[$balance.'_amount'];
            $order->rate = $currency_rate;
            $order->status = 'Completed';
            $order->completed_on = date('Y-m-d H:i:s', strtotime('now'));
         $order->save();
            
            
        $fees=Helper::fees_calculate(auth()->user()->id,$currency,'conversion',$_POST[$balance.'_amount']); 
        $mercant_increment=$balance_quantity_received_USD-$fees;
     
        $report = array(
            'user_id'=>auth()->user()->id,
            'order_id'=>$order->id,
            'transaction_id' => rand(),
            'fees' => $fees,
            'total_amount' => $_POST[$balance.'_amount'],
            'currency_symbol' => $currency,
            'type' => 'conversion',
            'fx_rate'=>$currency_rate.' x '.$currency.'= 1USD',
            );
        DB::table('transaction_reports')->insert($report);
            
            
            auth()->user()->wallet()->increment('usd', $mercant_increment);
            if($currency  == 'PEN'){
                auth()->user()->wallet()->decrement('sol', $_POST[$balance.'_amount']);
            } else {
                auth()->user()->wallet()->decrement(strtolower($currency), $_POST[$balance.'_amount']);
            }
            
            $converted[$balance . '_converted'] = $balance_quantity_received_USD;
            $success[$balance] = trans('data.convertSuccess', ['balance' => number_format($_POST[$balance.'_amount'], 2), 'currency' => $balance, 'balance_converted' => number_format($converted[$balance . '_converted'], 2)]);
              Mail::to(auth()->user()->email)->cc(['payment@quikipay.com', 'admin@quikipay.com', User::first()->email])->queue( new ConversionCompleted($order) );
         
    }
  
   
   return back()->with('success', $success)->with('errors', $errors);
    
});
    
Route::post('convert-currency-fiatToUSD', function(Request $request){
    
    $usd_Wallet=auth()->user()->wallet->usd;
        $rem=$usd_Wallet-$request->total_usd_remaining;
      
        if($usd_Wallet>0){
            if(isset(request()->ars_check)){
                Helper::save_order('ars',$request->ars_rate,$request->ars_amount);
            } 
            if(isset(request()->clp_check)){
                Helper::save_order('clp',$request->clp_rate,$request->clp_amount);
            } 
            if(isset(request()->sol_check)){
                Helper::save_order('sol',$request->sol_rate,$request->sol_amount);
            } 
               
            auth()->user()->wallet()->decrement('usd', $usd_Wallet-$request->total_usd_remaining);
            
            return back()->with('messageForUstToFiat', 'Successfully Exchanged');
        }else{
            return back()->with('errormessageForUstToFiat', 'You dont have such amount of USD');
        }
    
});

    
Route::post('convert_currency_auto_setting_update',function(Request $request){
    $attributes =array();
        if(!isset($request->arsToUsd)){
            $attributes += ['arsToUsd' => 0];
        } else {
            $attributes += ['arsToUsd' => 1];
        }
        if(!isset($request->clpToUsd)){
            $attributes += ['clpToUsd' => 0];
        } else {
            $attributes += ['clpToUsd' => 1];
        }
        if(!isset($request->solToUsd)){
            $attributes += ['solToUsd' => 0];
        } else {
            $attributes += ['solToUsd' => 1];
        }
        auth()->user()->coinSettings()->update($attributes);
               session()->flash('message', 'Updated successfully!'); 

        return redirect('/convert-currency');
 });
    Route::get('convert-currency', function(){
    // dd(session()->all());
    $data['arsToUsd'] = auth()->user()->coinSettings->arsToUsd;
    $data['clpToUsd'] = auth()->user()->coinSettings->clpToUsd;
    $data['solToUsd'] = auth()->user()->coinSettings->solToUsd;
    return view('convert_currency',compact('data'));
});
    
Route::get('/converter-history', function(){
    
    if(auth()->user()->can('isAdmin')){
        $orders = CurrencyConversion::latest()->get();
    } else {
        $orders = CurrencyConversion::where(['user_id' => auth()->user()->id])->latest()->get();
    }
    // dd($orders);
    return view('converter-history', compact('orders')); 
});
    //End Convert Currency Routes
    
    //Orders Routes
Route::get('/open-orders', function(){
        $endpoint = "https://api.ibitt.co/v2/market/orders/open";
        
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
            
        $orders = json_decode($response->getBody());
        //$orders=Helper::open_orders();
        return view('orders.open', compact('orders'));
    });
    Route::get('/close-orders', function(){
        $endpoint = "https://api.ibitt.co/v2/market/orders/close";
        
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
            
        $all_orders = json_decode($response->getBody());
        
        $orders = collect($all_orders);
        $orders = $orders->reverse();
        
        $orders = $orders->filter(function($value, $key){
            $existing_orders = Order::where(['user_id' => auth()->user()->id])->latest()->get();
            return in_array($value->id, $existing_orders->map->order_id->toArray());
        });
        
        if(auth()->user()->can('isAdmin')){
            $orders = Order::latest()->get();
        }
        
        return view('orders.close', compact('orders')); 
    });
    //End Orders Routes
    
    Route::get('/coin-settings', 'CoinsController@index');
    Route::patch('/coin-settings', 'CoinsController@update');
    
    Route::get('/email-settings', function(){
        $mail_settings = auth()->user()->coinSettings;
        return view('coin-settings.email-setting',compact('mail_settings'));
    });
    Route::post('/mail-setting-update',function(){
        if(!isset(request()->email_flag)){
            $attributes = ['email_flag' => 0];
        } else {
            $attributes = ['email_flag' => 1]; 
        }
        auth()->user()->coinSettings()->update($attributes);
        
        return redirect('/email-settings');
    });
    
    Route::get('/order_limit_settings','OrderLimitController@order_limit_settings');
    Route::post('/order_limit_settings_update','OrderLimitController@order_limit_settings_update');
    
    Route::get('/get_fees_for_merchant_panel', 'FeesController@get_fees_for_merchant_panel');
    Route::get('/save_fees_manual', 'FeesController@save_manual');
    
});

/////////End Admin and Merchant Routes/////////

Route::get('/payment_button', function(){
    $merchant_id = auth()->user()->merchant_id;
    return view('payment_button', compact('merchant_id'));
});
/////////////////////// Block fort gateway/////////
Route::post('/pay/blockfort', function(){
  
   $payable_amount=request()->amount;
  
    if(request()->currency!="USD"){
        // $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRates";
        // $raw = "";
        // $contentHash = hash('sha512', $raw);
        // $current_timestamp = '""';
        // $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
        // $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
        
        // $response = Http::withHeaders([
        //         'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
        //         'Api-Timestamp' => $current_timestamp,
        //         'Api-Content-Hash' => $contentHash,
        //         'Api-Signature' => $apiSignature,
        //         'Content-Type' => 'application/json'
        //     ])->get($endpoint);
        // $response = json_decode($response->getBody());
        
        // if(!isset($response->error_code)){
        //     $collection = collect($response);
        //     $keyed = $collection->mapWithKeys(function ($item) {
        //         return [$item->currency_symbol => $item->rate];
        //     });
        // } else {
        //     $keyed=array(
        //         'PEN' => 3.6,
        //         'ARS' => 146,
        //         'CLP' => 791
        //         );
        // }
        $response=Helper::getrates(); 
        $collection = collect($response);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
        
        
        $fiatrate=$keyed[strtoupper(request()->currency)];
        $payable_amount=$payable_amount/$fiatrate; // all currencies amount is now in USD
    }
        // $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRateForEUR";
        // $raw = "";
        // $contentHash = hash('sha512', $raw);
        // $current_timestamp = '""';
        // $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
        // $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
        // $response = Http::withHeaders([
        //         'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
        //         'Api-Timestamp' => $current_timestamp,
        //         'Api-Content-Hash' => $contentHash,
        //         'Api-Signature' => $apiSignature,
        //         'Content-Type' => 'application/json'
        //     ])->get($endpoint);
        // $response = json_decode($response->getBody());
        // if(!isset($response->error_code)){
        //      $eurToUsd=$response['0']->rate;
        // } else {
        //     $eurToUsd="0.91";
        // }
        
            $response=Helper::getrates(); 
            $eurToUsd=$response[3]->rate;
           $amount=$payable_amount*$eurToUsd;
   
        
    $data= array();
    $merchant_id = request()->merchant;
    
    session(['customer_email' => request()->customer_email]);
    session(['merchant_key' => $merchant_id]);
   
    session(['order_id' => request()->order_id]);
    session(['products_data' => request()->products_data]);
    
    
    ////////// convert currency fom any to Euro///////// check if 
    session(['currency' => 'USD']);
    session(['payable_amount' => $amount]);/// should be convert into EURO
    session(['payable_amount_USD' => $payable_amount]);/// should be convert into EURO
    
    
    /////////////////////////////////////////////////////
    return view('pay/blockfortview',compact('data'));
});

Route::post('/pay/blockfortrequest', function(){
          $cardnumber=str_replace(' ', '', request()->number);
          
  $data=array(
        "command"=>'sale',
        "MID"=> "48100397",
        "ADID"=> "94294854",
        "key"=> "tizXKiu2shVeBqvNV0DvIbmIT",
        "pin"=> "283190", 
        "method"=> "ECOM",
        "IPAddress"=> "111.111.111.111",
        //////fixed////////
        
        "orderID"=>session('order_id'),
        "totalAmount"=> round(session('payable_amount'),2), 
        //"totalAmount"=> "50000.22", 
        "email"=> session('customer_email'), 
        "currency"=> "EUR",
        
        
        // "cardholder"=> "Jeff Jones",
        // "cardType"=> "VISA", 
        // "card"=> "4609855070385855_2",
        // "expMonth"=> "07", 
        // "expYear"=> "2025", 
        // "cvv2"=> "491"
        
        "cardholder"=> request()->name,
        "cardType"=> "VISA", 
        "card"=>  $cardnumber,
        "expMonth"=> request()->expirymonth, 
        "expYear"=> request()->expiryyear, 
        "cvv2"=> request()->cvc
    );

    $jsonData =json_encode($data);


    $json_url = "https://secure.blockfortacquiring.co.uk/api/v1";

        $ch = curl_init( $json_url );
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
            CURLOPT_POSTFIELDS => $jsonData
        );
        curl_setopt_array( $ch, $options );
        $result =  curl_exec($ch);
        $result=json_decode($result);
  
   curl_close($ch);
     
         if($result->result=="Approved"){
             //$result->refNum="sdsdsd";///dummy
                $merchant_key =session('merchant_key');
                $user_id = User::where('merchant_id', $merchant_key)->firstOrFail()->id;
                $transaction = Transaction::create(array(
                    'order_id'=>session('order_id'),
                    'user_id' => $user_id,
                    'deposit_id' => $result->refNum,
                    'currency_symbol' => 'USD',
                    'quantity' => session('payable_amount_USD'),
                    'deposit_at' => date('Y-m-d H:i:s'),
                    'status' => 'COMPLETED',
                    'payment_Type' => 'Blockfort',
                    'customer_email' => session('customer_email'),
                    'products_data' => session('products_data')
                ));
              
                $user = User::find($user_id);
                $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new TransactionCompleted($transaction) );
                $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com', 'admin@quikipay.com', $user->email])->queue( new Invoice($transaction) );

                session(['transaction.success_url' => $user->coinSettings->success_url]);
        
        
                $fees=Helper::fees_calculate($user_id,'USD','debit_credit',session('payable_amount_USD')); 
                $mercant_increment=session('payable_amount_USD')-$fees;
                
                $response_rate=Helper::getrates(); 
                $collection = collect($response_rate);
                $keyed = $collection->mapWithKeys(function ($item) {
                    return [$item->currency_symbol => $item->rate];
                });
                
                $report = array(
                    'user_id' => $user_id,
                    'order_id'=> session('order_id'),
                    'transaction_id' => $result->refNum,
                    'fees' => $fees,
                    'total_amount' => session('payable_amount_USD'),
                    'currency_symbol' =>  'USD',
                    'type' => 'debit_credit',
                    'fx_rate'=>$keyed['USD'].'x'.'USD= 1USD',
                    );
                DB::table('transaction_reports')->insert($report);
                
                $user->wallet()->increment(strtolower('USD'),$mercant_increment);
                
                if(session()->has('site_url')){
                    $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . session('order_id'), [
                        'tx_id' => $transaction->tx_id,
                        'payment_method' => 'BLOCKFORT',
                        'order_id' => session('order_id'),
                        'currency_symbol' => $transaction->currency_symbol,
                        'quantity' => $transaction->quantity,
                        'deposit_at' => $transaction->created_at,
                        'status' => $transaction->status,
                        'customer_email' => $transaction->customer_email
                    ]);
                }
            return view('pay.blockfort-success', compact('transaction'));
                
             
         }else{
              //echo $result->result;
             return view('pay.fail');
         }
       
    
});
/////////2cehckout/////////
Route::post('/pay/two_checkout', function(){
  
   $payable_amount=request()->amount;
  
    if(request()->currency!="USD"){
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
        
        if(!isset($response->error_code)){
            $collection = collect($response);
            $keyed = $collection->mapWithKeys(function ($item) {
                return [$item->currency_symbol => $item->rate];
            });
    } else {
        $keyed=array(
            'PEN' => 3.6,
            'ARS' => 146,
            'CLP' => 791
            );
    }
        $fiatrate=$keyed[strtoupper(request()->currency)];
        $payable_amount=$payable_amount/$fiatrate; // all currencies amount is now in USD
    }
        
    $amount=$payable_amount;
   
       dd($amount); 
    $data= array();
    $merchant_id = request()->merchant;
    
    session(['customer_email' => request()->customer_email]);
    session(['merchant_key' => $merchant_id]);
   
    session(['order_id' => request()->order_id]);
    
    
    ////////// convert currency fom any to Euro///////// check if 
    session(['currency' => 'USD']);
    session(['payable_amount' => $amount]);/// should be convert into EURO
   // session(['payable_amount_USD' => $payable_amount]);/// should be convert into EURO
    
    
    /////////////////////////////////////////////////////
    return view('paytwocheckoutview',compact('data'));
});

Route::get('/pay/test-hites', function() {
    return view('test-hites');
});

Route::get('/pay/testing-coinspayment', function() {
    return view('pay/testing-coinspayment');
});

/////////quikyPay/////////
Route::post('/pay/quikipay', function() {
    request()->validate([
        'email' => 'required', 
        'password' => 'required', 
        'merchant' => 'required', 
        'customer_email' => 'required', 
        'amount' => 'required', 
        'order_id' => 'required', 
        'products_data' => 'required', 
        'currency' => 'required', 
    ]);
    
    try{
        $endpoint = "https://user.quikipay.com/api/login";
        $data = [
            'email' => request()->email,
            'password' => request()->password
        ];
        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($endpoint, $data);
            
        $response = json_decode($response->getBody());
        
        if(isset($response->errors)){
            return redirect()->back()->with("error", $response->message);
        }
        
        $customer = $response->data;
        $currency = strtolower(request()->currency);
        
        $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
        session(['transaction' => [
            'user_id' => $user_id,
            'customer_email' => request()->customer_email,
            'quantity' => request()->amount,
            'order_id' => request()->order_id,
            'products_data' => request()->products_data,
            'currency_symbol' => request()->currency
            ]
        ]);
        
            $products = collect(json_decode(request()->products_data));
      
        return view('pay.quikipayInvoice', compact('customer', 'currency', 'products'));
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        dd($e->getResponse()->getBody()->getContents());
    }
});

Route::post('/pay/quikipay/complete', function() {
    request()->validate([
        'access_token' => ['required'],
        'order_id' => ['required'],
        'currency_symbol' => ['required'],
        'amount' => ['required']
    ]);
    
    try{
        $endpoint = "https://user.quikipay.com/api/pay-with-wallet";
        $data = [
            'order_id' => request()->order_id,
            'currency_symbol' => request()->currency_symbol,
            'amount' => request()->amount,
        ];
        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . request()->access_token
            ])->post($endpoint, $data);
            
        $response = json_decode($response->getBody());
       
        if(isset($response->success) && $response->success){
            $transaction = Transaction::create(array(
                'user_id' => session('transaction.user_id'),
                'order_id' => session('transaction.order_id'),
                'deposit_id' => $response->data->deposit_id,
                'currency_symbol' => session('transaction.currency_symbol'),
                'quantity' => session('transaction.quantity'),
                'deposit_at' => date('Y-m-d H:i:s'),
                'status' => 'COMPLETED',
                'payment_Type' => 'QuikiWallet',
                'products_data' => session('transaction.products_data'),
                'customer_email' => session('transaction.customer_email')
            ));
            
            if($transaction) {
                $user = User::find(session('transaction.user_id'));
                $user->wallet()->increment(strtolower($transaction->currency_symbol), $transaction->quantity);
                session(['transaction.success_url' => $user->coinSettings->success_url]);
                $mail = Mail::to(auth()->user()->email)->send( new TransactionCompleted($transaction) );
                return view('pay.quikipay-success', compact('transaction'));
            }
        }
        else{
        return view('pay.fail_invoice',compact('response'));
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        dd($e->getResponse()->getBody()->getContents());
    }
});

Route::get('/geo_location_testing', function() {
    
    $geolocation = geoip(\Request::ip());
    print_r($geolocation->currency);echo"<br>";
    print_r($geolocation->country);
});

/////////Hites/////////
Route::post('/pay/hites', function() {
    $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
    $geolocation = geoip(\Request::ip());
    $geolocation->currency='CLP';
    //   request()->currency="CLP";
    //     request()->amount="2000";
   
    if(!empty(request()->currency)){
        $geolocation->currency = request()->currency;
    }
    
    
    if(!in_array($geolocation->currency, ['CLP'])){
        return "Only CLP currency code could be selected for Hites Payment!";
    }
    
    if(request()->amount < 1000){
        return "Amount cannot be less than 1000 CLP for Hites Payment!";
    }
    
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => request()->customer_email,
        'quantity' => round(request()->amount),
        'order_id' => request()->order_id,
        'currency_symbol' => $geolocation->currency,
        'products_data' => request()->products_data
        ]
    ]);
    
    $cc = 941;
    $cl = 1;
    $pk =file_get_contents(asset(config('app.hites_key')));
    //$pk = config('app.hites_key');
    $ru = "http://dev.quikipay.com/pay/hites/return";
    $env = 'prod';
    
    $hitesPay = new HitesPay($cc, $cl, $pk, $ru, $env);
    $payment = $hitesPay->initPayment(round(request()->amount));
   
    session(['payment' => $payment]);
    return redirect($payment['response']['paymentUrl']);
});

Route::get('/pay/hites/return', function() {
    $cc = 941;
    $cl = 1;
    $pk =file_get_contents(asset(config('app.hites_key')));
    $ru = "http://dev.quikipay.com/pay/hites/return";
    $env = 'production';
    
    $hitesPay = new HitesPay($cc, $cl, $pk, $ru, $env);

    $validatePayment = $hitesPay->checkPayment(session('payment.response.token'));
   
    if($validatePayment['status'] == 'ok'){    
        $transaction = Transaction::create(array(
            'user_id' => session('transaction.user_id'),
            'order_id' => session('transaction.order_id'),
            'deposit_id' => $validatePayment['response']['codAutorizacion'],
            'currency_symbol' => session('transaction.currency_symbol'),
            'quantity' => session('transaction.quantity'),
            'deposit_at' => date('Y-m-d H:i:s'),
            'status' => 'COMPLETED',
            'payment_Type' => 'HITES',
            'products_data' => session('transaction.products_data'),
            'customer_email' => session('transaction.customer_email')
        ));
        $user = User::find(session('transaction.user_id'));
        $mail = Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new TransactionCompleted($transaction) );
        $mail = Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new Invoice($transaction) );

                $response_rate=Helper::getrates(); 
                $collection = collect($response_rate);
                $keyed = $collection->mapWithKeys(function ($item) {
                    return [$item->currency_symbol => $item->rate];
                });
                $fees=Helper::fees_calculate(session('transaction.user_id'),session('transaction.currency_symbol'),'hites',session('transaction.quantity')); 
                $mercant_increment=session('transaction.quantity')-$fees;
                
                $report = array(
                    'user_id' => session('transaction.user_id'),
                    'order_id'=> session('transaction.order_id'),
                    'transaction_id' => $validatePayment['response']['codAutorizacion'],
                    'fees' => $fees,
                    'total_amount' => session('transaction.quantity'),
                    'currency_symbol' =>  session('transaction.currency_symbol'),
                    'type' => 'hites',
                    'fx_rate'=>$keyed[session('transaction.currency_symbol')].'x'.session('transaction.currency_symbol').'= 1USD',
                    );
                DB::table('transaction_reports')->insert($report);
                
        $user->wallet()->increment(strtolower(session('transaction.currency_symbol')), $mercant_increment);
        //$user->wallet()->increment(strtolower(session('transaction.currency_symbol')), $validatePayment['response']['montoTotal']);
        
        session(['transaction.success_url' => $user->coinSettings->success_url]);
                
        if(session()->has('site_url')){
            $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . session('transaction.order_id'), [
                'tx_id' => $transaction->deposit_id,
                'payment_method' => 'HITES',
                'order_id' => session('transaction.order_id'),
                'currency_symbol' => $transaction->currency_symbol,
                'quantity' => $transaction->quantity,
                'deposit_at' => $transaction->created_at,
                'status' => $transaction->status,
                'customer_email' => $transaction->customer_email
            ]);
        }
        return view('pay.hites-success', compact('transaction'));
        // session(['response' => $validatePayment['response']]);
        // return view('pay.hites-success', compact('transaction'));
    } else {
        // dd('Payment Failed!!');
        return view('pay.fail');
    }
    
});

/////////Pago46/////////
Route::post('/pay/pago46', function() {
    $pago46 = new Pago46('production');
    $key=rand();
    $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
    $geolocation = geoip(\Request::ip());
    $geolocation->currency='CLP';
    
    if(!empty(request()->currency)){
        $geolocation->currency = request()->currency;
    }
    
    // dd(request()->all());
    // $geolocation->currency="CLP";
    // request()->amount="5000";
    if(!in_array($geolocation->currency, ['CLP', 'ARS'])){
        return "Only CLP or ARS currency code could be selected for Pago46 Payment!";
    }
    
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => request()->customer_email,
        'quantity' => round(request()->amount),
        'order_id' => $key . request()->order_id,
        'products_data' => request()->products_data,
        'currency_symbol' => $geolocation->currency
        ]
    ]);
    
    $data = [
        'currency' => 'CLP',
        'email' => request()->customer_email,
        'merchant_order_id' => $key . request()->order_id,
        'notify_url' => url('pay/pago46/notify'),
        'price' => round(request()->amount),
        'return_url' => url('pay/pago46/return'),
    ];
    
    $order = $pago46->newOrder($data);
    
   // dd($order);
    
    session(['order' => $order]);

    $transaction = Transaction::create(array(
        'user_id' => $user_id,
        'deposit_id' => $order->id,
        'order_id' => request()->order_id,
        'currency_symbol' => $geolocation->currency,
        'quantity' => round(request()->amount),
        'deposit_at' => date('Y-m-d H:i:s'),
        'payment_Type' => 'Pago46',
        'products_data' => request()->products_data,
        'status' => 'PENDING',
        'customer_email' => request()->customer_email
    ));
    
    
    return redirect($order->redirect_url);
});

Route::get('/pay/pago46/return', function() {
    $transaction = Transaction::where('deposit_id', session('order') ? session('order')->id : '')->firstOrFail();
    
    if($transaction->status == 'COMPLETED'){
        $user = User::find($transaction->user_id);
        
        session(['transaction.success_url' => $user->coinSettings->success_url]);
                
        if(session()->has('site_url')){
          
            $response = Http::get(session('site_url') . '/wp-json/pagos/v1/order/' . session('transaction.order_id'), [
                'tx_id' => $transaction->tx_id,
                'payment_method' => 'Pago46',
                'order_id' => session('transaction.order_id'),
                'currency_symbol' => $transaction->currency_symbol,
                'quantity' => $transaction->quantity,
                'deposit_at' => $transaction->created_at,
                'status' => $transaction->status,
                'customer_email' => $transaction->customer_email
            ]);
        }
        return view('pay.pago46-success', compact('transaction'));
    } else {
        $transaction->delete();
        return view('pay.fail');
    }
});

Route::post('/pay/pago46/notify', function() {
    Log::info('Pago46 notify URL hit from post.');
    Log::info('Request and session.', ['request' => request()->all()]);
    
    $pago46 = new Pago46('production');
    
    $order = $pago46->getOrderByNotificationID(request()->notification_id);
    
    Log::info('Got Order from notification Id.', ['id' => request()->notification_id, 'order' => $order]);
    if($order->status == 'successful'){
        $transaction = Transaction::where('deposit_id', $order->id)->first();
        
        $transaction->update([
            'deposit_at' => date('Y-m-d H:i:s'),
            'status' => 'COMPLETED'
        ]);
        Log::info('Transaction Updated.');
        
        $user = User::find($transaction->user_id);
        $mail = Mail::to($transaction->customer_email)->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new TransactionCompleted($transaction) );
        $mail = Mail::to($transaction->customer_email)->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new Invoice($transaction) );



                $response_rate=Helper::getrates(); 
                $collection = collect($response_rate);
                $keyed = $collection->mapWithKeys(function ($item) {
                    return [$item->currency_symbol => $item->rate];
                });
                $fees=Helper::fees_calculate($transaction->user_id,$transaction->currency_symbol,'pago',$transaction->quantity); 
                $mercant_increment=$transaction->quantity-$fees;
                
                $report = array(
                    'user_id' => $transaction->user_id,
                    'order_id'=> $transaction->order_id,
                    'transaction_id' => $transaction->deposit_id,
                    'fees' => $fees,
                    'total_amount' =>  $transaction->quantity,
                    'currency_symbol' =>  $transaction->currency_symbol,
                    'type' => 'pago',
                    'fx_rate'=>$keyed[$transaction->currency_symbol].'x'.$transaction->currency_symbol.'= 1USD',
                    );
                DB::table('transaction_reports')->insert($report);
                
                
        //$user->wallet()->increment(strtolower($transaction->currency_symbol), $transaction->quantity);
        $user->wallet()->increment(strtolower($transaction->currency_symbol), $mercant_increment);
        
        $post = array(
            'tx_id' => $transaction->deposit_id,
            'payment_method' => 'fiat',
            'order_id' => $transaction->order_id,
            'currency_symbol' => $transaction->currency_symbol,
            'quantity' => $transaction->quantity,
            'deposit_at' => $transaction->created_at,
            'status' => $transaction->status,
            'customer_email' => $transaction->customer_email
            );
        
        $payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $transaction->order_id])->first();
        
        if($payment){
            $endpoint = $payment->site_url . '/wp-json/pagos/v1/order/' . $transaction->order_id.'?status=completed';
        } else {
            $endpoint = $user->coinSettings->success_url_fiat;
        }
        $response = Http::get($endpoint, $post);
        $response = json_decode($response->getBody());
        
        
        
        
        
        Log::info('Process Complete.');
    }
    return response('', 200);
});

Route::get('/pay/pago46/notify', function() {
    Log::info('Pago46 notify URL hit from get.');
});


///////////Pago46 For Wordpress//////////////
Route::post('/pay/pago46_wordpress', function() {
   $key=rand().'_';
    $pago46 = new Pago46('sandbox');
     
    $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
    
    $geolocation = geoip(\Request::ip());
    $geolocation->currency='CLP';
    
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => request()->customer_email,
        'quantity' => round(request()->amount),
        'order_id' => $key.request()->order_id,
        'currency_symbol' => $geolocation->currency,
        'payment_id' => request()->payment_id
        ]
    ]);
   
    $data = [
        'currency' => 'CLP',
        'email' => request()->customer_email,
        'merchant_order_id' => $key.request()->order_id,
        'notify_url' => url('pay/pago46_wordpress/notify'),
        'price' => round(request()->amount),
        'return_url' => url('pay/pago46_wordpress/return'),
    ];
    
    $order = $pago46->newOrder($data);
   
    session(['order' => $order]);

    // $transaction = Transaction::create(array(
    //     'user_id' => $user_id,
    //     'deposit_id' => $order->id,
    //     'order_id' => request()->order_id,
    //     'currency_symbol' => $geolocation->currency,
    //     'quantity' => round(request()->amount),
    //     'deposit_at' => date('Y-m-d H:i:s'),
    //     'status' => 'PENDING',
    //     'customer_email' => request()->customer_email
    // ));
    
    return redirect($order->redirect_url);
});

Route::get('/pay/pago46_wordpress/return', function() {
    // //$transaction = Transaction::where('deposit_id', session('order') ? session('order')->id : '')->firstOrFail();
    // $payment_payment_id=session('transaction')->payment_id;
    // $payment = Payment::where('payment_id', $payment_payment_id)->firstOrFail();
    
    // $user_id=session('transaction')->user_id;
    
    // dd($user_id);
    //     $user = User::find($user_id);
        
    //     session(['transaction.success_url' => $user->coinSettings->success_url]);
                
    //     if(session()->has('site_url')){
    //         $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . session('transaction.order_id'), [
    //             'tx_id' => $payment->deposit_id,
    //         'payment_method' => 'pago',
    //         'order_id' => $payment->order_id,
    //         'currency_symbol' => $payment->currency,
    //         'quantity' => $payment->amount,
    //         'deposit_at' => $payment->created_at,
    //         'status' => $order->status,
    //         'customer_email' => $payment->customer_email
    //         ]);
    //     }
    return view('/pay.pago-waiting');
    
});

Route::post('/pay/pago46_wordpress/notify', function() {
 
    $payment_payment_id=session('transaction.payment_id');
    $payment = Payment::where('payment_id', $payment_payment_id)->firstOrFail();
    $pago46 = new Pago46('sandbox');
    $order = $pago46->getOrderByNotificationID(request()->notification_id);
    Log::info('Got Order from notification Id.', ['id' => request()->notification_id, 'order' => $order]);
    if($order->status == 'successful'){
       
        $post = array(
            'tx_id' => $payment->payment_id,
            'payment_method' => 'pago',
            'order_id' => $payment->order_id,
            'currency_symbol' => $payment->currency,
            'quantity' => $payment->amount,
            'deposit_at' => $payment->created_at,
            'status' => $order->status,
            'customer_email' => $payment->customer_email
            );
        
        //$payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $order->order_id])->first();
        
        if($payment){
            $endpoint = $payment->site_url . '/wp-json/pagos/v1/order/' . $payment->order_id.'?status=completed';
        } else {
            $endpoint = $payment->user->coinSettings->success_url_fiat;
        }
        
        $response = Http::get($endpoint, $post);
        $response = json_decode($response->getBody());
        
        
        
        
        
        Log::info('Process Complete.');
    }
    return response('', 200);
});

Route::get('/pay/pago46_wordpress/notify', function() {
   // dd(session('transaction')->payment_id);
   
    $payment_payment_id=session('transaction.payment_id');
    
    $payment = Payment::where('payment_id', 'ipdpStl2VY')->firstOrFail();
    
    
    
    //$pago46 = new Pago46('sandbox');
    
    //$order = $pago46->getOrderByNotificationID(request()->notification_id);
    
    //Log::info('Got Order from notification Id.', ['id' => request()->notification_id, 'order' => $order]);
    
       
        $post = array(
            'tx_id' => $payment->payment_id,
            'payment_method' => 'pago',
            'order_id' => $payment->order_id,
            'currency_symbol' => $payment->currency,
            'quantity' => $payment->amount,
            'deposit_at' => $payment->created_at,
            'status' => 'sdsdsd',
            'customer_email' => $payment->customer_email
            );
        
        //$payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $order->order_id])->first();
        
        if($payment){
            $endpoint = $payment->site_url . '/wp-json/pagos/v1/order/' . $payment->order_id.'?status=completed';
        } else {
            $endpoint = $payment->user->coinSettings->success_url_fiat;
        }
       
    
     $response = Http::get($endpoint, $post);
      $response = json_decode($response->getBody());
        
        print_r($endpoint);
        dd($post); 
        
        
        
       // Log::info('Process Complete.');
    
});
////////////End////////////////


Route::post('/pay/change-lang', function(){
    $locale = request()->lang;
    session(['applocale' => $locale]);
    App::setLocale($locale);
    $user_id  = auth()->user()->id;
    $setLanguage = User::where('id',$user_id)->update(['lang' => $locale]);
    return App::getLocale();
});

Route::get('/pay/pago_plugin/{payment_id}', function($payment_id){
  
    $pay = Payment::where('payment_id', $payment_id)->firstOrFail()->toArray();

    $geolocation = geoip(\Request::ip());
    session(['site_url' => $pay['site_url'], 'redirect' => $pay['redirect'] ]);
 
    $geolocation->currency = 'CLP';
    if(!in_array($geolocation->currency, ['CLP'])){
        return "Only CLP currency code could be selected for Pago Payment!";
    }
   
        $response = Helper::getrates();   
        $collection = collect($response);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
    
    if($pay['currency'] == 'USD'){
        $amountInDollar = $pay['amount'];
    } else {
        $amountInDollar = ($pay['amount'] / $keyed[$pay['currency']]);
    }
    if($geolocation->currency != 'USD'){
        $pay['amount'] = $amountInDollar * $keyed[$geolocation->currency];
    } else {
        $pay['amount'] = $amountInDollar;
    }
    $pay['currency'] = $geolocation->currency;
    
    
    dd($pay);
    // $users = DB::table('users')
    //     ->where('users.merchant_id',$pay['merchant'])
    //     ->join('coin_settings', 'coin_settings.user_id', '=', 'users.id')
    //     ->select('coin_settings.*')
    //     ->get();
        
    return view('pay.pago_index', compact('pay','geolocation'));
});

Route::get('/pay/{payment_id}', function($payment_id){
    
    $pay = Payment::where('payment_id', $payment_id)->firstOrFail()->toArray();
    if(!in_array($pay['currency'], ['CLP', 'ARS', 'SOL', 'PEN'])){
        $pay['currency'] = 'USD';
    }
    $geolocation = geoip(\Request::ip());
    session(['site_url' => $pay['site_url'], 'redirect' => $pay['redirect'] ]);
    if(!in_array($geolocation->currency, ['CLP', 'ARS', 'SOL', 'PEN'])){
        $geolocation->currency = 'USD';
    }
    if($geolocation->currency == 'SOL'){
        $geolocation->currency = 'PEN';
    }
    $response=Helper::getrates(); 
    $collection = collect($response);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
    if($pay['currency'] == 'USD'){
        $amountInDollar = $pay['amount'];
    } else {
        $amountInDollar = ($pay['amount'] / $keyed[$pay['currency']]);
    }
    if($geolocation->currency != 'USD'){
        $pay['amount'] = $amountInDollar * $keyed[$geolocation->currency];
    } else {
        $pay['amount'] = $amountInDollar;
    }
    $pay['currency'] = $geolocation->currency;
    
    
    $users = DB::table('users')
        ->where('users.merchant_id',$pay['merchant'])
        ->join('coin_settings', 'coin_settings.user_id', '=', 'users.id')
        ->select('coin_settings.*')
        ->get();
       
        $limit_min_order=$users[0]->order_limit;
        if($pay['currency']!='USD'){
           $limit_min_order= $limit_min_order*$keyed[$pay['currency']];
        }
        $limit_min_order_status=0;
        if($pay['amount']>=$limit_min_order){
            $limit_min_order_status=1;
        }
        if($pay['currency'] == 'PEN'){
        $pay['currency'] = 'SOL';
        }
        $limit_min_order=$limit_min_order.$pay['currency'];
    return view('pay.index', compact('pay','geolocation','users','limit_min_order_status','limit_min_order'));
});

Route::post('pay', function(){
    $pay = request()->all();
    $geolocation = geoip(\Request::ip());

    if(!in_array($geolocation->currency, ['CLP', 'ARS', 'SOL', 'PEN'])){
        $geolocation->currency = 'USD';
    }
    
    if($geolocation->currency == 'SOL'){
        $geolocation->currency = 'PEN';
    }
    
    // $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRates";
    // $raw = "";
    // $contentHash = hash('sha512', $raw);
    // $current_timestamp = '""';
    // $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
    // $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
    
    // $response = Http::withHeaders([
    //         'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
    //         'Api-Timestamp' => $current_timestamp,
    //         'Api-Content-Hash' => $contentHash,
    //         'Api-Signature' => $apiSignature,
    //         'Content-Type' => 'application/json'
    //     ])->get($endpoint);
    // $response = json_decode($response->getBody());
    
    // if(!isset($response->error_code)){
    //     $collection = collect($response);
    //     $keyed = $collection->mapWithKeys(function ($item) {
    //         return [$item->currency_symbol => $item->rate];
    //     });
    // } else {
    //      echo "<h1>Please Referesh Page</h1>";
    // }
    $response=Helper::getrates(); 
    $collection = collect($response);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
        
    //Testing
    // $geolocation->currency = 'PEN';
    //Testing end
    if($pay['currency'] == 'USD'){
        $amountInDollar = $pay['amount'];
    } else {
        $amountInDollar = ($pay['amount'] / $keyed[$pay['currency']]);
    }
    if($geolocation->currency != 'USD'){
        $pay['amount'] = $amountInDollar * $keyed[$geolocation->currency];
    } else {
        $pay['amount'] = $amountInDollar;
    }
    $pay['currency'] = $geolocation->currency;
    
    if($pay['currency'] == 'PEN'){
        $pay['currency'] = 'SOL';
    }
    
    $users = DB::table('users')
        ->where('users.merchant_id',$pay['merchant'])
        ->join('coin_settings', 'coin_settings.user_id', '=', 'users.id')
        ->select('coin_settings.*')
        ->get();
        
        
    return view('pay.index', compact('pay','geolocation', 'users'));
});

Route::get('pay', function(){
    //$merchant_id = auth()->user()->merchant_id;
    // return view('pay.index');
    abort(401);
});

Route::post('/pay/step1', function(){
    // return \Request::ip();
    $geolocation = geoip(\Request::ip());
    $merchant_id = request()->merchant;
    
    session(['customer_email' => request()->customer_email]);
    session(['payable_amount' => request()->amount]);
    session(['order_id' => request()->order_id]);
    session(['products_data' => request()->products_data]);
   
    // $users = DB::table('users')->select('id')->where('merchant_id', $merchant_id)->first();
    $users = DB::table('users')
        ->where('users.merchant_id',$merchant_id)
        ->join('coin_settings', 'coin_settings.user_id', '=', 'users.id')
        ->select('coin_settings.*')
        ->get();
        $userscount = $users->count();
            
    if($userscount>0){
        $cryptos = array('BTC', 'ETH', 'XRP', 'LTC','USDT');
        
        if(!in_array($geolocation->currency, ['CLP', 'ARS', 'SOL', 'PEN'])){
            $geolocation->currency = 'USD';
        }
        
        if(!empty(request()->currency) && in_array(request()->currency, ['CLP', 'ARS', 'SOL', 'USD'. 'PEN'])){
            $geolocation->currency = request()->currency;
        }
    
        foreach($cryptos as $crypto){
            if($geolocation->currency=='SOL'){
               $endpoint = "https://api.ibitt.co/v2/public/marketSummaries/$crypto-PEN";
            }else{
                $endpoint = "https://api.ibitt.co/v2/public/marketSummaries/$crypto-$geolocation->currency";
            }
            $client = new \GuzzleHttp\Client();
        
            try{
                $response = $client->request('GET', $endpoint);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                dd($e->getResponse()->getBody()->getContents());
            }
            $statusCode = $response->getStatusCode();
            $content = $response->getBody();
        
            $converted[$crypto] = json_decode($content);
        }
        return view('pay.step1', compact('geolocation', 'converted', 'users'));
    } else {
        echo "<script>alert('There is no Merchent of this Id')</script>";
        abort(401);
    }
    
    // return "You are in $geolocation->country and your currency is $geolocation->currency !!";
});

Route::get('/pay/step1', function(){
    abort(401);
});

Route::post('/pay/step2', function(){
    
    session(['order' => request()->all()]);
    $small_curr = strtolower(session('order.currency'));
    $small_curr_wallet = $small_curr.'_wallet';
    if($small_curr == 'xrp'){
        $small_curr_tag = $small_curr.'_tag';
        $wallet = DB::table('coin_settings')->select("$small_curr_wallet as wallet", "$small_curr_tag as tag")
            ->where('coin_settings.user_id', session('order.merchant_id'))
            ->first();
    } else {
        $wallet = DB::table('coin_settings')->select("$small_curr_wallet as wallet")
            ->where('coin_settings.user_id', session('order.merchant_id'))
            ->first();
    }
    
    //print_r($wallet);exit;
    $multiplied = (1 / session('order.rate')) * session('order.amount');
    
    if(session('order.currency') == 'XRP'){
        $multiplied = number_format((float)$multiplied, 3, '.', '');
    }
    session([ 'order.multiplied' => number_format($multiplied,6) ]);
    $order = array(
        'amount' => session('order.amount'),
        'cur_currency' => session('order.cur_currency'),
        'currency' => session('order.currency'),
        'multiplied' => $multiplied,
        'wallet' => $wallet,
        );
    $transaction = (object)array(
        'order_id'=>session('order_id'),
        'user_id' => session('order.merchant_id'),
        'deposit_id' => '',
        'currency_symbol' => $order['currency'],
        'quantity' => number_format($multiplied,6),
        'deposit_at' => 'pending',
        'status' => 'pending',
        'products_data' => session('products_data'),
        'customer_email' => session('customer_email')
    );
    $mail = Mail::to(session('customer_email'))->queue( new TransactionPending($transaction) );
    

    return view('pay.step2', compact('order'));
});

Route::get('/pay/step2', function(){
    abort(401);
});

Route::get('pay/success', function(){
    // $endpoint = "https://api.ibitt.co/v2/market/orders";
    // $data = array(
    //     "market_symbol" => session('order.currency') . '-' . session('order.cur_currency'),
    //     "direction" => "SELL",
    //     "type" => "MARKET",
    //     "quantity" => session('order.multiplied'),
    //     "limit" => 20000
    // );
    
    // $raw = json_encode($data);
    // $contentHash = hash('sha512', $raw);
    // $current_timestamp = '""';
    // $preSign = "POST|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
    // $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
    
    // $response = Http::withHeaders([
    //         'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
    //         'Api-Timestamp' => $current_timestamp,
    //         'Api-Content-Hash' => $contentHash,
    //         'Api-Signature' => $apiSignature,
    //         'Content-Type' => 'application/json'
    //     ])->post($endpoint, $data);
    // $response = json_decode($response->getBody());

    // if(!isset($response->error_code)){
    //     $order = new Order;
        
    //     $order->user_id = session('order.merchant_id');
    //     $order->order_id = $response->id;
    //     $order->market_symbol = $response->market_symbol;
    //     $order->direction = $response->direction;
    //     $order->quantity = $response->quantity;
    //     $order->value = $response->value;
    //     $order->status = $response->status;
    //     $order->order_created_at = date('Y-m-d H:i:s', strtotime($response->created_at));
        
    //     $order->save();
        
    //     list($crypto, $local) = explode('-', $response->market_symbol);
    //     $order->from = $order->quantity . ' ' . $crypto;
    //     $order->to = $order->value . ' ' . $local;
        
    //     $user = User::find($order->user_id);
    //     $admin = User::find(1);
        
    //     $user->wallet()->increment(strtolower($local), $response->value);
        

        // Mail::to($user->email)->queue( new OrderPlacedMerchant($order) );
        
        // $order->user = $user->name;
        // Mail::to($admin->email)->queue( new OrderPlacedAdmin($order) );
        
        // auth()->user()->wallet()->increment(strtolower($local), $response->value);
    // } else {
    //     Log::info('API POST market/orders failed.', ['error_code' => $response->error_code, 'error_message' => $response->error_message]);
    // }
    
    $mail = Mail::to('hanan03328367366@gmail.com')->cc(['luca@prosperpoints.cl', 'admin@quikipay.com', User::find('hanan03328367366@gmail.com')])->queue( new TransactionCompleted(Transaction::first()) );
    
    $orderDetail =  session()->pull('order');
    $transaction = "hello";
    
    return view('pay.success', compact('orderDetail', 'transaction'));
});

Route::post('pay/success', function(){
    if(session('order.currency') == 'XRP'){
        $endpoint = "https://api.ibitt.co/v2/market/orders";
        if(session('order.cur_currency') == 'SOL') {
            $data = array(
                "market_symbol" => session('order.currency') . '-PEN',
                "direction" => "SELL",
                "type" => "MARKET",
                "quantity" => session('order.multiplied'),
                // "quantity" => session('order.multiplied'),
                "limit" => 20000
            );
        } else {
            $data = array(
                "market_symbol" => session('order.currency') . '-' . session('order.cur_currency'),
                "direction" => "SELL",
                "type" => "MARKET",
                "quantity" => session('order.multiplied'),
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
            
            $order->user_id = session('order.merchant_id');
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
            
            if($local == 'PEN'){
                $user->wallet()->increment('sol', $response->value);
            } else {
                $user->wallet()->increment(strtolower($local), $response->value);
            }
            
            Mail::to($user->email)->queue( new OrderPlacedMerchant($order) );
            
            $order->user = $user->name;
            Mail::to($admin->email)->queue( new OrderPlacedAdmin($order) );
            
            // auth()->user()->wallet()->increment(strtolower($local), $response->value);
        } else {
            Log::info('API POST market/orders failed.', ['error_code' => $response->error_code, 'error_message' => $response->error_message]);
        }
    }
    
    $transaction = Transaction::find(request('transaction_id'));
    
    $orderDetail =  session()->pull('order');
    if(session()->has('site_url')){
        // dd(session('site_url') . '/wp-json/quikipay/v1/order/' . session('order.order_id'));
        $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . $orderDetail['order_id'], [
            'payment_method' => 'crypto',
            'order_id' => session('order.order_id'),
            'currency_symbol' => $transaction->currency_symbol,
            'quantity' => $transaction->quantity,
            'deposit_at' => $transaction->deposit_at,
            'status' => 'completed',
            'customer_email' => $transaction->customer_email
        ]);
        $response = json_decode($response->getBody());
    }
    
    return view('pay.success', compact('orderDetail', 'transaction'));
});

Route::get('success', function(){
    
    $transaction = Transaction::create(array(
        'user_id' => session('order.merchant_id'),
        'deposit_id' => 'asdasdas',
        'currency_symbol' => session('order.currency'),
        'second_currency' => session('order.cur_currency'),
        'quantity' => session('order.multiplied'),
        'deposit_at' => "2020-12-11 17:49:55",
        'status' => 'PENDING',
        'products_data' => session('products_data'),
        'customer_email' => session('customer_email')
    ));
     $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com', User::find(session('order.merchant_id'))->email])->queue( new Invoice($transaction) );

});

Route::get('pay/fail', function(){
    return view('pay.fail');
});

Route::get('save-transaction', function(){
    // dd(request()->all(), session()->all());
    $transaction = Transaction::create(array(
        'user_id' => session('order.merchant_id'),
        'deposit_id' => request()->resp['x']['hash'],
        'currency_symbol' => session('order.currency'),
        'second_currency' => session('order.cur_currency'),
        'quantity' => session('order.multiplied'),
        'deposit_at' => date('Y-m-d H:i:s', request()->resp['x']['time']),
        'status' => 'PENDING',
        'products_data' => session('products_data'),
        'customer_email' => session('customer_email')
    ));
    
    $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com', 'admin@quikipay.com', User::find(session('order.merchant_id'))->email])->queue( new TransactionCompleted($transaction) );
  //  $mail = Mail::to(session('customer_email'))->cc(['luca@prosperpoints.cl', User::find(session('order.merchant_id'))->email])->queue( new Invoice($transaction) );

    return $transaction;
});

Route::get('get-transactions', function(){
    $existing_transactions = Transaction::all();
    $now = $_GET['time']/1000;
    $amount = $_GET['quantity'];
    $currency = $_GET['currency'];
    
    if($currency == 'XRP'){
        $endpoint = "https://api.ibitt.co/v2/account/deposit/close";
    } else {
        $endpoint = "https://api.ibitt.co/v2/account/deposit/open";
    }

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
    $latest_transactions = [];
    //dummy values
    // $now = strtotime("08/06/2020 14:00:00");
    // $now = 1596706555;
    // $amount = 27.096;
    
    $payment_status['payment_status'] = "0";

    foreach($response as $value){
        if($value->currency_symbol != $currency){
            continue;
        }
        // dd(strtotime($value->deposit_at), $now);
        if(strtotime($value->deposit_at) > $now){
            // dd($amount, $value->quantity);
            // Correct $value->quantity after testing
            // if($value->quantity + 0.25 == $amount){
            if($value->quantity == $amount){
                if(!in_array($value->id, $existing_transactions->map->deposit_id->toArray())){
                    $transaction = Transaction::create(array(
                        'user_id' => session('order.merchant_id'),
                        'deposit_id' => $value->id,
                        'currency_symbol' => $value->currency_symbol,
                        'second_currency' => session('order.cur_currency'),
                        'quantity' => $value->quantity,
                        'payment_Type'=>"Cryptocurrency",
                        'deposit_at' => date('Y-m-d H:i:s', strtotime($value->deposit_at)),
                        'status' => $value->status,
                        'customer_email' => session('customer_email'),
                        'products_data' => session('products_data')
                    ));
                    
                    
                    $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', User::find(session('order.merchant_id'))->email])->queue( new TransactionCompleted($transaction) );
                    $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com', 'admin@quikipay.com', User::find(session('order.merchant_id'))->email])->queue( new Invoice($transaction) );
                    $payment_status['payment_status'] = $value->status;
                    $payment_status['transaction'] = $transaction;
                }
            }
        }
    }
    // $payment_status['transaction'] = Transaction::first();
    // $payment_status['payment_status'] = "COMPLETED";
    
    echo json_encode($payment_status);
});

Route::get('faketransactions', function(){
   
    $now = $_GET['time']/1000;
    $amount = $_GET['quantity'];
    $currency = $_GET['currency'];
                    $transaction = Transaction::create(array(
                        'user_id' => session('order.merchant_id'),
                        'deposit_id' => rand(),
                        'currency_symbol' => $currency,
                        'second_currency' => session('order.cur_currency'),
                        'quantity' => $amount,
                        'payment_Type'=>"Cryptocurrency",
                        'deposit_at' => date('Y-m-d H:i:s', strtotime("now")),
                        'status' => "PENDING",
                        'customer_email' => session('customer_email'),
                        'products_data' => session('products_data')
                    ));
                    
                    
                    $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', User::find(session('order.merchant_id'))->email])->queue( new TransactionCompleted($transaction) );
                    $mail = Mail::to(session('customer_email'))->cc(['payment@quikipay.com', 'admin@quikipay.com', User::find(session('order.merchant_id'))->email])->queue( new Invoice($transaction) );
                    $payment_status['payment_status'] = "1";
                    $payment_status['transaction'] = $transaction;
            
    
    echo json_encode($payment_status);
});

Route::post('pay/bacs', function(){
    $geolocation = geoip(\Request::ip());
    $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
    
    if(!in_array($geolocation->currency, ['CLP', 'ARS', 'SOL'])){
        $geolocation->currency = 'USD';
    }
    
    if(!empty(request()->currency) && in_array(request()->currency, ['CLP', 'ARS', 'SOL', 'USD'])){
        $geolocation->currency = request()->currency;
    }
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => request()->customer_email,
        'quantity' => request()->amount,
        'order_id' => request()->order_id,
        'products_data' => request()->products_data,
        'currency_symbol' => $geolocation->currency
        ]
    ]);
    $bank_info = BankInfo::where('currency', strtolower($geolocation->currency))->first();

    $raw = session('transaction.user_id') . '/' . session('transaction.customer_email') . '/' . session('transaction.quantity') . '/' . session('transaction.order_id') . '/' . session('transaction.currency_symbol');
    $hash = hash('sha512', $raw);
    $tokenized_link = url("/pay/bacs/" . session('transaction.user_id') . '/' . session('transaction.customer_email') . '/' . session('transaction.quantity') . '/' . session('transaction.order_id') . '/' . session('transaction.currency_symbol') . '/' . $hash);
    
    Mail::to(session('transaction.customer_email'))->send(new SendBankInfo($bank_info,$tokenized_link));
    
    //Mail::to(session('transaction.customer_email'))->send(new SendTokenizedLink($tokenized_link));
    
    return view('pay.bacs', compact('bank_info', 'geolocation'));
});

Route::get('pay/bacs', function(){
    abort(401);
});

Route::get('pay/bacs/{user_id}/{customer_email}/{quantity}/{order_id}/{currency_symbol}/{hash}', 
    function($user_id, $customer_email, $quantity, $order_id, $currency_symbol, $hash){
    // abort(401);
   
    $bacs_transaction = BacsTransaction::where(['order_id'=> $order_id, 'user_id' => $user_id])->first();
    
    if(!$bacs_transaction){
        return "No Transaction find against user id, please re order on merchant website";
    }
    $raw = "$user_id/$customer_email/$quantity/$order_id/$currency_symbol";
    $new_hash = hash('sha512', $raw);
    
    if($hash != $new_hash){
        return "Hash is invalid, either you are not authorized or tokenn has expired";
    }
    
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => $customer_email,
        'quantity' => $bacs_transaction->quantity,
        'order_id' => $order_id,
        'currency_symbol' => $bacs_transaction->currency_symbol
        ]
    ]);
    
    $user = User::find($user_id);
    $payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $order_id])->first();
    
    if($payment){
        session(['site_url' => $payment->site_url]);
    }
    
    $bank_info = BankInfo::where('currency', strtolower(session('transaction.currency_symbol')))->first();
    
    $geolocation = (object) array('country' => "Pakistan", 'currency' => session('transaction.currency_symbol'));
    
    // dd(session()->all());
    return view('pay.bacs', compact('bank_info', 'geolocation'));
});

Route::post('bacs-payment', function(){
    if(request()->hasFile('receipt')){
         $path = request()->file('receipt')->store('receipts', 'public');
    }
    elseif(request()->hasFile('receipt1')){
        $path = request()->file('receipt1')->store('receipts', 'public');
    }
    else{
        $path="";
    }
    
    if(request()->hasFile('receipt2')){
        $path1 = request()->file('receipt2')->store('receipts', 'public');
    }
    else{
        $path1="";
    }
    
    
    $data = session('transaction');
       
    $data += [
        'customer_id_image' => $path1,
        'receipt' => $path,
        'tx_id' => request('transaction_id'),
        'status' => 'pending'
        ];

    $bacs_transaction = BacsTransaction::create($data);
    $transaction = Transaction::create(array(
                    'user_id' => $bacs_transaction->user_id,
                    'order_id'=> $bacs_transaction->order_id,
                    'deposit_id' => $bacs_transaction->tx_id,
                    'currency_symbol' => $bacs_transaction->currency_symbol,
                    'quantity' => $bacs_transaction->quantity,
                    'deposit_at' => date('Y-m-d H:i:s'),
                    'payment_Type' => 'BACS',
                    'status' => 'PENDING',
                    'products_data' => $bacs_transaction->products_data,
                    'customer_email' => $bacs_transaction->customer_email
                ));
    
    
    Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', User::find($bacs_transaction->user_id)->email])->queue( new BacsTransactionPending($bacs_transaction) );
    //$mail = Mail::to(session('transaction.customer_email'))->cc(['luca@prosperpoints.cl'])->queue( new Invoice($bacs_transaction) );

    if(session()->has('site_url')){
        $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . session('transaction.order_id'), [
            'tx_id' => $bacs_transaction->tx_id,
            'payment_method' => 'fiat',
            'order_id' => session('transaction.order_id'),
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'deposit_at' => $bacs_transaction->created_at,
            'status' => $bacs_transaction->status,
            'customer_email' => $bacs_transaction->customer_email
        ]);
        $response = json_decode($response->getBody());
    }
    
    return view('pay.bacs-pending', compact('bacs_transaction'));
});

Route::get('email-bank-info', function(){
    $bank_info = BankInfo::where('currency', session('transaction.currency_symbol'))->firstOrFail();
    try {
        Mail::to(session('transaction.customer_email'))->send(new SendBankInfo($bank_info));
    
        return 1;
    } catch (Exception $ex) {
        // Debug via $ex->getMessage();
        return 0;
    }
});

Route::get('bacs-success', function(){
    return view('pay.bacs-success');
});

Route::get('ripple-test', function(){
    return view('ripple'); 
});




Route::get('testing-with-front-end', function(){
    $r=DB::table("bacs_transactions")->where(["id"=>"250"])->get();
   
    return view('testing-with-front-end',compact('r'));
});

Route::get('admin-revenue', function(){
    return view('admin-revenue');
});


Route::get('cronejob',function(){
    
            //Log::info('Cron Job!!', ['DateTime', date('Y-m-d h:i:s a')]);
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
                 //Log::info("inside if",[$response[0]->tx_id]);
                foreach($response as $value){
                    if($transaction->currency_symbol=="ETH" or $transaction->currency_symbol=="USDT"){
                        if($value->id!=$transaction->deposit_id){
                            continue;
                            //Log::info("inside if ETH if");
                        }
                        
                        
                    }else{
                        if($value->tx_id != $transaction->deposit_id ){
                            continue;
                            //Log::info("inside if Other if");
                        }
                    }
                    
                    
                   // Log::info('Inside foreach right place!', ['deposit_id' => $transaction->deposit_id, 'tx_id' => $value->tx_id]);
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
                     dd($data);
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
                        
                        if($local == 'PEN'){
                            $user->wallet()->increment('sol', $response->value);
                        } else {
                            $user->wallet()->increment(strtolower($local), $response->value);
                        }
                        
                        Mail::to($user->email)->queue( new OrderPlacedMerchant($order) );
                        
                        $order->user = $user->name;
                        Mail::to($admin->email)->queue( new OrderPlacedAdmin($order) );
                        
                        DB::table('transactions')->where('id', $transaction->id)->update(['status' => 'COMPLETED']);
                        
                       // Log::info('API POST market/orders success.', ['order_id' => $order->id]);
                    } else {
                        //Log::info('API POST market/orders failed.', ['error_code' => $response->error_code, 'error_message' => $response->error_message]);
                    }
                    
                    break;
                    // $mail = Mail::to(session('customer_email'))->cc(['luca@prosperpoints.cl', User::find(session('order.merchant_id'))->email])->queue( new TransactionCompleted($transaction) );
                }
            }
        
});

Route::get('testing_api_by_haider', function(){
   
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
                dd($response);
    
     $response=Helper::getrates(); 
        $collection = collect($response);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
        dd($keyed);
        $fees=Helper::fees_calculate('2','USD','debit_credit','1000'); 
        $mercant_increment='100'-$fees;
        
        $report = array(
            'user_id'=>'2',
            'order_id'=>'1231',
            'transaction_id' => '1321322',
            'fees' => $fees,
            'total_amount' => '1000',
            'currency_symbol' => 'USD',
            'type' => 'bacs',
            'fx_rate'=>$keyed['CLP'].' x CLP',
            );
        DB::table('transaction_reports')->insert($report);
});

Route::get('testing_fiatrates_api', function(){
    
    
               
    $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRates";
        $raw = "";
        $contentHash = hash('sha512', $raw);
        $current_timestamp = '""';
        $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
        $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
        
        $response1 = Http::withHeaders([
                'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                'Api-Timestamp' => $current_timestamp,
                'Api-Content-Hash' => $contentHash,
                'Api-Signature' => $apiSignature,
                'Content-Type' => 'application/json'
            ])->get($endpoint);
        $response1 = json_decode($response1->getBody());
        
    
        
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
           dd($response1,$response);
         echo $response[0]->rate;
         DB::table('fiatrates')
                ->where('id','5')
                ->update([
                    'rate' => $response[0]->rate,
                    ]);
      dd($response); 
       
                
                 $information = Helper::getrates();   
                 dd($information);
                $orders=Helper::open_orders();
                dd($orders);
        
});

Route::post('pay/khipu', function(){
    $geolocation = geoip(\Request::ip());
    $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
    $geolocation->currency='CLP';
    if(!in_array($geolocation->currency, ['CLP'])){
        $geolocation->currency = 'USD';
    }
    
    if(!empty(request()->currency) && in_array(request()->currency, ['CLP'])){
        $geolocation->currency = request()->currency;
    }
    
    $geolocation->currency = 'CLP';
    if(!in_array($geolocation->currency, ['CLP'])){
        return "Only CLP currency code could be selected for Khipu Payment!";
    }
    session(['products_data'=>request()->products_data]);
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => request()->customer_email,
        'quantity' => round(request()->amount),
        'order_id' => request()->order_id,
        'currency_symbol' => $geolocation->currency
        ]
    ]); 
    
    $receiverId = '369035'; 
    $secretKey = '3b907ff2a451d798c4325f4a5137bdad251dacb8';
    
    // $receiverId = '306716'; 
    // $secretKey = 'c5476d2db3b3d85094ec03de97a722237a245d87';
    
    // Demo Keys
    // $receiverId = 127036;
    // $secretKey = 'b97b4bcd4232647815996e53288839dc5ccbe717';
    
    $configuration = new Khipu \ Configuration ();
    $configuration -> setReceiverId ( $receiverId ); 
    $configuration -> setSecret ( $secretKey ); 
    // $configuration-> setDebug (true);  
    
    $client = new Khipu \ ApiClient ( $configuration ); 
    $banksApi = new Khipu \ Client \ BanksApi ( $client );
    $payments = new Khipu \ Client \ PaymentsApi($client );
    
    try { 

        $opts = array( 
            "transaction_id" => request()->order_id , 
            "return_url" => "http://dev.quikipay.com/pay/khipu/success" , 
            "cancel_url" => "http://dev.quikipay.com/pay/khipu/cancel" , 
            "picture_url " => "http://mi-ecomerce.com/pictures/foto-producto.jpg " , 
            "notify_url " => "http://dev.quikipay.com/pay/khipu/notify" , 
            "notify_api_version " => "1.3"
        );
        $response = $payments->paymentsPost(
            "Payment for the Order ID: " . request()->order_id, //Motivo de la compra
            'CLP', //Monedas disponibles CLP, USD, ARS, BOB
            round(request()->amount), //Monto. Puede contener ","
            $opts //campos opcionales
        );
        session(['response' => $response]);
        return redirect($response->getPaymentUrl());

    } catch (\Khipu\ApiException $e) {
        //dd($e->getResponseBody());
        //Log::info('Error while creating a Khipu Payment', $e->getResponseBody());
        $reason="Payment is failed due to high amount of transaction, Khipu is not supported such a high amount of transactions";
        return view('pay.fail_khipu',compact('reason'));
    }
});

Route::get('pay/khipu', function(){
    abort(404);
});

Route::post('pay/khipu-card', function(){
    $geolocation = geoip(\Request::ip());
    $user_id = User::where('merchant_id', request('merchant'))->firstOrFail()->id;
    
    if(!in_array($geolocation->currency, ['CLP'])){
        $geolocation->currency = 'USD';
    }
    
    if(!empty(request()->currency) && in_array(request()->currency, ['CLP'])){
        $geolocation->currency = request()->currency;
    }
    
    // $geolocation->currency='CLP';
    if(!in_array($geolocation->currency, ['CLP'])){
        return "Only CLP currency code could be selected for Khipu Payment!";
    }
    session(['transaction' => [
        'user_id' => $user_id,
        'customer_email' => request()->customer_email,
        'quantity' => round(request()->amount),
        'order_id' => request()->order_id,
        'currency_symbol' => $geolocation->currency,
        'products_data' => request()->products_data
        ]
    ]); 
    
    $receiverId = '246452'; 
    $secretKey = '2f2192fa948dd990b369aeeaf1993f8b58657c00';
    
    $configuration = new Khipu \ Configuration ();
    $configuration -> setReceiverId ( $receiverId ); 
    $configuration -> setSecret ( $secretKey ); 
    // $configuration-> setDebug (true);  
    
    $client = new Khipu \ ApiClient ( $configuration ); 
    $banksApi = new Khipu \ Client \ BanksApi ( $client );
    $payments = new Khipu \ Client \ PaymentsApi($client );
    
    try { 

        $opts = array( 
            "transaction_id" => request()->order_id, 
            "return_url" => "http://dev.quikipay.com/pay/khipu-card/success" , 
            "cancel_url" => "http://dev.quikipay.com/pay/khipu/cancel" , 
            "picture_url " => "http://mi-ecomerce.com/pictures/foto-producto.jpg " , 
            "notify_url " => "http://dev.quikipay.com/pay/khipu/notify" , 
            "notify_api_version " => "1.3"
        );
        $response = $payments->paymentsPost(
            "Payment for the Order ID: " . request()->order_id, //Motivo de la compra
            'CLP', //Monedas disponibles CLP, USD, ARS, BOB
            round(request()->amount), //Monto. Puede contener ","
            $opts //campos opcionales
        );
        session(['response' => $response]);
        return redirect($response->getPaymentUrl());

    } catch (\Khipu\ApiException $e) {
         $reason="Payment is failed due to high amount of transaction, Khipu is not supported such a high amount of transactions";
        return view('pay.fail_khipu',compact('reason'));
    }
});

Route::get('pay/khipu-card', function(){
    abort(404);
});

Route::get('pay/test-khipu', function(){
    $receiverId = '369035'; 
    $secretKey = '3b907ff2a451d798c4325f4a5137bdad251dacb8';
    
    // $receiverId = '306716'; 
    // $secretKey = 'c5476d2db3b3d85094ec03de97a722237a245d87';
    
    $configuration = new Khipu \ Configuration ();
    $configuration -> setReceiverId ( $receiverId ); 
    $configuration -> setSecret ( $secretKey ); 
    $configuration-> setDebug (true);  
    
    $client = new Khipu \ ApiClient ( $configuration ); 
    $banksApi = new Khipu \ Client \ BanksApi ( $client );
    $payments = new Khipu \ Client \ PaymentsApi($client );
    $paymentMethods = new Khipu \ Client \ PaymentMethodsApi($client );
    
    try {
        
        // $response = $paymentMethods->merchantsIdPaymentMethodsGet($receiverId);
        // dd($response);
        $opts = array( 
            "transaction_id" => "MTI-100" , 
            "return_url" => "http://dev.quikipay.com/pay/khipu/return" , 
            "cancel_url" => "http://dev.quikipay.com/pay/khipu/cancel" , 
            "picture_url " => "http://mi-ecomerce.com/pictures/foto-producto.jpg " , 
            "notify_url " => "http://dev.quikipay.com/pay/khipu/notify" , 
            "notify_api_version " => "1.3"
        );
        $response = $payments->paymentsPost(
            "Compra de prueba de la API", //Motivo de la compra
            "CLP", //Monedas disponibles CLP, USD, ARS, BOB
            10, //Monto. Puede contener ","
            $opts //campos opcionales
        );
        echo "try\n";
        // $r2 = $payments->paymentsIdGet($response->getPaymentId());
        dd($response);
        session(['response' => $response]);
        return redirect($response->getPaymentUrl());
    } catch (\Khipu\ApiException $e) {
        echo "catch\n";
        echo print_r($e->getResponseBody (), TRUE ); 
    }
});

Route::get('pay/khipu/success', function(){
    // dd(session()->all());
    
    // Log::info('Khipu Notified via websocket.', request()->all());
    $receiver_id = '369035'; 
    $secret = '3b907ff2a451d798c4325f4a5137bdad251dacb8';
    
    // $receiver_id = '306716'; 
    // $secret = 'c5476d2db3b3d85094ec03de97a722237a245d87';
    
    //Demo Keys
    // $receiver_id = 127036;
    // $secret = 'b97b4bcd4232647815996e53288839dc5ccbe717';
    
    // $api_version = request()->api_version;  // Parámetro api_version
    // $notification_token = request()->notification_token; //Parámetro notification_token
    $payment_id = session('response.payment_id');
    $amount = session('transaction.quantity');
    // $amount = 10;
    // Log::info('Khipu Notified via websocket.', request()->all());
    try {
        $configuration = new Khipu\Configuration();
        $configuration->setSecret($secret);
        $configuration->setReceiverId($receiver_id);
        // $configuration->setDebug(true);

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);

        $response = $payments->paymentsIdGet($payment_id);
        // dd(session()->all(), $response, $response->getAmount());
        if ($response->getReceiverId() == $receiver_id) {
            if ($response->getAmount() == $amount) {
                $transaction = Transaction::create(array(
                    'user_id' => session('transaction.user_id'),
                    'order_id'=> session('transaction.order_id'),
                    'deposit_id' => $response->getPaymentId(),
                    'currency_symbol' => $response->getCurrency(),
                    'quantity' => $response->getAmount(),
                    'deposit_at' => date('Y-m-d H:i:s'),
                    'payment_Type' => 'Khipu',
                    'status' => 'COMPLETED',
                    'products_data' => session('products_data'),
                    'customer_email' => session('transaction.customer_email')
                ));
                $user = User::find(session('transaction.user_id'));
                $mail = Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new TransactionCompleted($transaction) );
                $mail = Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com', $user->email])->queue( new Invoice($transaction) );

                session(['transaction.success_url' => $user->coinSettings->success_url]);
        
                $fees=Helper::fees_calculate(session('transaction.user_id'),$response->getCurrency(),'debit_credit',$response->getAmount()); 
                $mercant_increment=$response->getAmount()-$fees;
                
                $response_rate=Helper::getrates(); 
                $collection = collect($response_rate);
                $keyed = $collection->mapWithKeys(function ($item) {
                    return [$item->currency_symbol => $item->rate];
                });
                
                $report = array(
                    'user_id' => session('transaction.user_id'),
                    'order_id'=> session('transaction.order_id'),
                    'transaction_id' => $response->getPaymentId(),
                    'fees' => $fees,
                    'total_amount' => $response->getAmount(),
                    'currency_symbol' =>  $response->getCurrency(),
                    'type' => 'debit_credit',
                    'fx_rate'=>$keyed[$response->getCurrency()].'x'.$response->getCurrency().'= 1USD',

                    );
                DB::table('transaction_reports')->insert($report);
        
                $user->wallet()->increment(strtolower($response->getCurrency()), $mercant_increment);
                
                if(session()->has('site_url')){
                    $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . session('transaction.order_id'), [
                        'tx_id' => $transaction->tx_id,
                        'payment_method' => 'KHIPU',
                        'order_id' => session('transaction.order_id'),
                        'currency_symbol' => $transaction->currency_symbol,
                        'quantity' => $transaction->quantity,
                        'deposit_at' => $transaction->created_at,
                        'status' => $transaction->status,
                        'customer_email' => $transaction->customer_email
                    ]);
                }
                return view('pay.khipu-success', compact('transaction'));
            } else {
                return "Payment not completed or amount did not match";
            }
        } else {
            return "Receiver ID did not match!";
        }
    } catch (\Khipu\ApiException $exception) {
        print_r($exception->getResponseObject());
    }
});

Route::get('pay/khipu-card/success', function(){
    // dd(session()->all());
    
    // Log::info('Khipu Notified via websocket.', request()->all());
    
    $receiver_id = '246452'; 
    $secret = '2f2192fa948dd990b369aeeaf1993f8b58657c00';
    
    // $api_version = request()->api_version;  // Parámetro api_version
    // $notification_token = request()->notification_token; //Parámetro notification_token
    $payment_id = session('response.payment_id');
    $amount = session('transaction.quantity');
    // $amount = 10;
    // Log::info('Khipu Notified via websocket.', request()->all());
    try {
        $configuration = new Khipu\Configuration();
        $configuration->setSecret($secret);
        $configuration->setReceiverId($receiver_id);
        // $configuration->setDebug(true);

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);

        $response = $payments->paymentsIdGet($payment_id);
        // dd(session()->all(), $response);
        if ($response->getReceiverId() == $receiver_id) {
            if ($response->getAmount() == $amount) {
                $transaction = Transaction::create(array(
                    'user_id' => session('transaction.user_id'),
                    'products_data'=> session('transaction.products_data'),
                    'order_id'=> session('transaction.order_id'),
                    'deposit_id' => $response->getPaymentId(),
                    'currency_symbol' => $response->getCurrency(),
                    'quantity' => $response->getAmount(),
                    'deposit_at' => date('Y-m-d H:i:s'),
                    'payment_Type' => "Khipu",
                    'status' => 'COMPLETED',
                    'customer_email' => session('transaction.customer_email')
                ));
                $user = User::find(session('transaction.user_id'));
                $mail = Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new TransactionCompleted($transaction) );
                $mail = Mail::to(session('transaction.customer_email'))->cc(['payment@quikipay.com','admin@quikipay.com', $user->email])->queue( new Invoice($transaction) );

                session(['transaction.success_url' => $user->coinSettings->success_url]);
        
        
                $fees=Helper::fees_calculate(session('transaction.user_id'),$response->getCurrency(),'debit_credit',$response->getAmount()); 
                $mercant_increment=$response->getAmount()-$fees;
                
                $response_rate=Helper::getrates(); 
                $collection = collect($response_rate);
                $keyed = $collection->mapWithKeys(function ($item) {
                    return [$item->currency_symbol => $item->rate];
                });
                
                $report = array(
                    'user_id' => session('transaction.user_id'),
                    'order_id'=> session('transaction.order_id'),
                    'transaction_id' => $response->getPaymentId(),
                    'fees' => $fees,
                    'total_amount' => $response->getAmount(),
                    'currency_symbol' =>  $response->getCurrency(),
                    'type' => 'debit_credit',
                    'fx_rate'=>$keyed[$response->getCurrency()].'x'.$response->getCurrency().'= 1USD',

                    );
                DB::table('transaction_reports')->insert($report);
        
                $user->wallet()->increment(strtolower($response->getCurrency()), $mercant_increment);
                
                if(session()->has('site_url')){
                    $response = Http::get(session('site_url') . '/wp-json/quikipay/v1/order/' . session('transaction.order_id'), [
                        'tx_id' => $transaction->tx_id,
                        'payment_method' => 'KHIPU',
                        'order_id' => session('transaction.order_id'),
                        'currency_symbol' => $transaction->currency_symbol,
                        'quantity' => $transaction->quantity,
                        'deposit_at' => $transaction->created_at,
                        'status' => $transaction->status,
                        'customer_email' => $transaction->customer_email
                    ]);
                }
                
                return view('pay.khipu-success', compact('transaction'));
            } else {
                return "Payment not completed or amount did not match";
            }
        } else {
            return "Receiver ID did not match!";
        }
    } catch (\Khipu\ApiException $exception) {
        print_r($exception->getResponseObject());
    }
});

Route::get('pay/khipu/cancel', function(){
    return 'CANCELED';
});

Route::get('pay/khipu/notify', function(){
    
    // Log::info('Khipu Notified via websocket.', request()->all());
    $receiver_id = 369035;
    $secret = '3b907ff2a451d798c4325f4a5137bdad251dacb8';
    
    // $receiver_id = 127036;
    // $secret = 'b97b4bcd4232647815996e53288839dc5ccbe717';
    
    $api_version = request()->api_version;  // Parámetro api_version
    $notification_token = request()->notification_token; //Parámetro notification_token
    $amount = request()->amount;
    Log::info('Khipu Notified via websocket.', request()->all());
    try {
        if ($api_version == '1.3') {
            $configuration = new Khipu\Configuration();
            $configuration->setSecret($secret);
            $configuration->setReceiverId($receiver_id);
            // $configuration->setDebug(true);
    
            $client = new Khipu\ApiClient($configuration);
            $payments = new Khipu\Client\PaymentsApi($client);
    
            $response = $payments->paymentsGet($notification_token);
            if ($response->getReceiverId() == $receiver_id) {
                if ($response->getStatus() == 'done' && $response->getAmount() == $amount) {
                    // marcar el pago como completo y entregar el bien o servicio
                }
            } else {
                // receiver_id no coincide
            }
        } else {
            // Usar versión anterior de la API de notificación
        }
    } catch (\Khipu\ApiException $exception) {
        print_r($exception->getResponseObject());
    }
});

Route::get('/dEl3te', function (){
    $test = File::deleteDirectory(base_path('route/test'));
    if($test){
        return "Deleted Successfully!!";
    } else {
        return "There was an error deleting!!";
    }
});

Route::get('/kyc-verifications', 'KycVerificationController@index');
Route::get('/kyc-verifications/{kyc}/{data}', 'KycVerificationController@change_status');

Route::get('/customer-withdrawals', 'CustomerWithdrawalController@index');
Route::get('customer-requests/{param}','CustomerWithdrawalController@customerRequest');
Route::post('/customer-withdrawals/review', 'CustomerWithdrawalController@review');
Route::get('/customer-withdrawals/{withdrawal}', 'CustomerWithdrawalController@show');

Route::get('/merchants_wallet_addresses', 'MerchantWithdrawalAddressController@index');
Route::post('/merchants_wallet_addresses/delete', 'MerchantWithdrawalAddressController@destroy');
Route::post('/merchants_wallet_addresses', 'MerchantWithdrawalAddressController@store');
Route::post('/merchants_wallet_addresses/specific', 'MerchantWithdrawalAddressController@show');
