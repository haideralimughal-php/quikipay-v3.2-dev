<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Payment;
use Illuminate\Support\Str;
use App\User;
use App\Transaction;
use App\BacsTransaction;
use App\Helper\Helper;
use App\Fees;
use App\CurrencyConversion;
use App\Mail\TransactionCompleted;
use App\Mail\BacsTransactionCompleted;
use App\Mail\TransactionPending;
use App\Mail\BacsTransactionPending;
use App\Mail\SendTokenizedLink;
use App\Mail\SendFailForBacs;
use App\Mail\SendBankInfo;
use App\Mail\Invoice;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/payment', function(Request $request){
    // return Str::random(10);
    $validator = $request->validate([
        'amount' => 'required',
        'currency' => 'required',
        'customer_email' => 'required',
        'order_id' => 'required',
        'merchant' => 'required',
        'site_url' => 'required',
        'redirect' => 'required',
        'products_data'=>'required'
    ]);
    
    do 
    {
        $token = Str::random(10);
        $payment = Payment::where('payment_id', $token)->first();
    } while ($payment);
    
    $validator += ['payment_id' => $token];
    
    $payment = Payment::create($validator);
    
    if($payment) {
        return response()->json([
            'payment_url' => url("/pay/$payment->payment_id")
        ], 200);
    } else {
        return response()->json([
            'message' => 'Error with your request!!'
        ], 403);
    }
});
Route::post('/payment_pago', function(Request $request){
    // return Str::random(10);
    $validator = $request->validate([
        'amount' => 'required',
        'currency' => 'required',
        'customer_email' => 'required',
        'order_id' => 'required',
        'merchant' => 'required',
        'site_url' => 'required',
        'redirect' => 'required',
        'products_data'=>'required'
    ]);
    
    do 
    {
        $token = Str::random(10);
        $payment = Payment::where('payment_id', $token)->first();
    } while ($payment);
    
    $validator += ['payment_id' => $token];
    
    $payment = Payment::create($validator);
    
    if($payment) {
        return response()->json([
            'payment_url' => url("/pay/pago_plugin/$payment->payment_id")
        ], 200);
    } else {
        return response()->json([
            'message' => 'Error with your request!!'
        ], 403);
    }
});
Route::post('get-orders', function(){
    $response =array();
    if(isset($_POST['merchant_id'])){
        $merchant_id=$_POST['merchant_id'];
    $user=User::where('merchant_id',$merchant_id)->first();
    if($user){
        $filter=array(
            'user_id'=> $user->id,
            );
        if(isset($_POST['status'])){
            $status=$_POST['status'];
            if($status=="1"){
                $filter += ['status' => "COMPLETED"];
            }
            elseif($status=="0"){
                $filter += ['status' => "PENDING"];
            }
            elseif($status=="2"){
                $filter += ['status' => "REJECT"];
            }
            else{
                $filter += ['status' => "COMPLETED"];
            }
        }
        if(isset($_POST['order_id'])){
            $order_id=$_POST['order_id'];
            $filter += ['order_id' => $order_id];
        }
        
     
     $transactions1 = DB::table('bacs_transactions')->select('id','user_id','tx_id','order_id','currency_symbol','status','customer_email','customer_name','created_at','quantity','rejected_reason')->where($filter);
     $transactions1_rows=$transactions1->count();
     if($transactions1_rows){
         $transactions = DB::table('bacs_transactions_deleted_orders')->select('id','user_id','tx_id','order_id','currency_symbol','status','customer_email','customer_name','created_at','quantity','rejected_reason')
                ->where(['status'=>'reject'])
                ->where(['user_id'=> $user->id])
                ->union($transactions1)
                ->latest()
                ->get();
         if(!empty($transactions) and !empty($transactions1)){
          $response = json_encode($transactions);
           print_r($response);
         }else{
            $response += ['code' => "404","message"=>"Transactions are not found"];
            $response= json_encode($response);
             print_r($response);
         }
     }else{
         $response += ['code' => "404","message"=>"Transactions are not found"];
            $response= json_encode($response);
             print_r($response);
     }
    }else{
         $response += ['code' => "404","message"=>"Merchant id is invalid"];
         $response= json_encode($response);
         print_r($response);
    }
    }else{
        $response += ['code' => "422","message"=>"Merchant id is empty"];
        $response= json_encode($response);
         print_r($response);
    }
    
});
Route::post('fiat-order', function(Request $request){
    
    $validator =  Validator::make($request->all(),[
    'tx_id' => 'required',
    'currency_symbol' => 'required',
    'order_id' => 'required',
    'merchant_id' => 'required',
    'quantity' => 'required',
    'site_url' => 'required',
    'redirect' => 'required',
    ]);
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "message" => $validator->errors(),
        ], 422);
    }
    if(!in_array($request->currency_symbol, ['CLP', 'ARS','USD','SOL'])){
        $request->currency_symbol='USD';
    }
    $key=rand();
    $token = $key.Str::random(10); 
    $paymentdata =array(
        'amount' => $request->quantity,
        'currency' => $request->currency_symbol,
        'customer_email' => $request->customer_email,
        'order_id' => $request->order_id,
        'merchant' => $request->merchant_id,
        'site_url' => $request->site_url,
        'products_data'=>$request->products_data,
        'payment_id' => $token,
        "redirect"=>$request->redirect
    );

    
    $payment = Payment::create($paymentdata);
    $response=array();
     $user_id = User::where('merchant_id', $request->merchant_id)->get();
    $user_data=$user_id->count();
    if($user_data){
        if($request->receipt_upload){
            $file = $request->receipt_upload;
            if(in_array($file->extension(), ['png', 'jpeg','jpg'])){
            $path = base_path() . '/storage/app/public/receipts/';
            $file->move($path, "receipts/".$key.$file->getClientOriginalName());
            $path2 = "receipts/".$key.$file->getClientOriginalName();
            }
        }
        else{
            $path2="";
    }
        if($request->customer_id_upload){
            $file = $request->customer_id_upload;
            if(in_array($file->extension(), ['png', 'jpeg','jpg'])){
            $path = base_path() . '/storage/app/public/receipts/';
            $file->move($path, "receipts/".$key.$file->getClientOriginalName());
            $path1 = "receipts/".$key.$file->getClientOriginalName();
            }
        }
        else{
            $path1="";
    }
        $data = array (
            'user_id' => $user_id[0]->id,
            'tx_id'=>$request->tx_id,
            'customer_email' => $request->customer_email,
            'quantity' => $request->quantity,
            'order_id' => $request->order_id,
            'currency_symbol' => $request->currency_symbol,
            'customer_id_image' => $path1,
            'receipt' => $path2,
            'products_data'=>$request->products_data,
            'customer_name'=>$request->customer_name,
            'status' => 'pending'
            
            );
        $bacs_transaction = BacsTransaction::create($data);
        if($bacs_transaction){
            $data = array(
            'order_id'=>$bacs_transaction->order_id,
            'user_id' => $bacs_transaction->user_id,
            'deposit_id' => $bacs_transaction->tx_id,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'customer_email' => $bacs_transaction->customer_email,
            'payment_Type' =>'BACS',
            'products_data' => $bacs_transaction->products_data,
            'deposit_at' => $bacs_transaction->created_at,
            'status' => strtoupper($bacs_transaction->status),
            );
            $transaction=Transaction::create($data);
            
            $user=User::find($bacs_transaction->user_id);
           $email_flag= $user->coinSettings->email_flag;
           if($email_flag=="1")
           $user_email=$bacs_transaction->customer_email;
           else
           $user_email="haideralimughalers@gmail.com";
           
            Mail::to($user_email)->cc(['luca@prosperpoints.cl','admin@quikipay.com', User::find($bacs_transaction->user_id)->email])->queue( new BacsTransactionPending($bacs_transaction) );
            
            $response += ['code' => "200","message"=>"Successfully Uploaded"];
            $response= json_encode($response);
        }else{
            $response += ['code' => "500","message"=>"Error in Data Uploading Please Try Again"];
            $response= json_encode($response);
        }
    }else{
        $response += ['code' => "404","message"=>"Merchant Id is invalid"];
        $response= json_encode($response);
    }
    print_r($response);
    
});
Route::post('dumy-fiat-order', function(Request $request){
    
    $validator =  Validator::make($request->all(),[
    'tx_id' => 'required',
    'currency_symbol' => 'required',
    'order_id' => 'required',
    'merchant_id' => 'required',
    'quantity' => 'required',
    'site_url' => 'required',
    'redirect' => 'required',
    ]);
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "message" => $validator->errors(),
        ], 422);
    }
    if(!in_array($request->currency_symbol, ['CLP', 'ARS','USD','SOL'])){
        $request->currency_symbol='USD';
    }
    $key=rand();
    $token = $key.Str::random(10); 
    $paymentdata =array(
        'amount' => $request->quantity,
        'currency' => $request->currency_symbol,
        'customer_email' => $request->customer_email,
        'order_id' => $request->order_id,
        'merchant' => $request->merchant_id,
        'site_url' => $request->site_url,
        'products_data'=>$request->products_data,
        'payment_id' => $token,
        "redirect"=>$request->redirect,
        "customer_name"=>$request->customer_name
    );

    
    $payment = Payment::create($paymentdata);
    $response=array();
     $user_id = User::where('merchant_id', $request->merchant_id)->get();
    $user_data=$user_id->count();
    if($user_data){
        if($request->receipt_upload){
            $file = $request->receipt_upload;
            if(in_array($file->extension(), ['png', 'jpeg','jpg'])){
            $path = base_path() . '/storage/app/public/receipts/';
            $file->move($path, "receipts/".$key.$file->getClientOriginalName());
            $path2 = "receipts/".$key.$file->getClientOriginalName();
            }
        }
        else{
            $path2="";
    }
        if($request->customer_id_upload){
            $file = $request->customer_id_upload;
            if(in_array($file->extension(), ['png', 'jpeg','jpg'])){
            $path = base_path() . '/storage/app/public/receipts/';
            $file->move($path, "receipts/".$key.$file->getClientOriginalName());
            $path1 = "receipts/".$key.$file->getClientOriginalName();
            }
        }
        else{
            $path1="";
    }
        $data = array (
            'user_id' => $user_id[0]->id,
            'tx_id'=>$request->tx_id,
            'customer_email' => $request->customer_email,
            'quantity' => $request->quantity,
            'order_id' => $request->order_id,
            'currency_symbol' => $request->currency_symbol,
            'customer_id_image' => $path1,
            'receipt' => $path2,
            'products_data'=>$request->products_data,
            'customer_name'=>$request->customer_name,
            'status' => 'pending'
            
            );
        $bacs_transaction = BacsTransaction::create($data);
        if($bacs_transaction){
            $data = array(
            'order_id'=>$bacs_transaction->order_id,
            'user_id' => $bacs_transaction->user_id,
            'deposit_id' => $bacs_transaction->tx_id,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'customer_email' => $bacs_transaction->customer_email,
            'payment_Type' =>'BACS',
            'products_data' => $bacs_transaction->products_data,
            'deposit_at' => $bacs_transaction->created_at,
            'status' => strtoupper($bacs_transaction->status),
            );
            $transaction=Transaction::create($data);
            
            $user=User::find($bacs_transaction->user_id);
           $email_flag= $user->coinSettings->email_flag;
           if($email_flag=="1")
           $user_email=$bacs_transaction->customer_email;
           else
           $user_email="haideralimughalers@gmail.com";
           
            Mail::to($user_email)->cc(['luca@prosperpoints.cl','admin@quikipay.com', User::find($bacs_transaction->user_id)->email])->queue( new BacsTransactionPending($bacs_transaction) );
            
            $response += ['code' => "200","message"=>"Successfully Uploaded"];
            $response= json_encode($response);
        }else{
            $response += ['code' => "500","message"=>"Error in Data Uploading Please Try Again"];
            $response= json_encode($response);
        }
    }else{
        $response += ['code' => "404","message"=>"Merchant Id is invalid"];
        $response= json_encode($response);
    }
    print_r($response);
    
});
Route::post('document-re-upload', function(Request $request){
    $key=rand();
    $validator =  Validator::make($request->all(),[
    'order_id' => 'required',
    'merchant_id'=>'required'
    ]);
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "message" => $validator->errors(),
        ], 422);
    }
    $user_id = User::where('merchant_id', $request->merchant_id)->firstOrFail()->id;
    
    $response=array();
   
    if($request->receipt_upload){
            $file = $request->receipt_upload;
             if(in_array($file->extension(), ['png', 'jpeg','jpg'])){
                $path = base_path() . '/storage/app/public/receipts/';
                $file->move($path, "receipts/".$key.$file->getClientOriginalName());
                $path2 = "receipts/".$key.$file->getClientOriginalName();
             }
        }
        else{
            $path2="";
    }
        if($request->customer_id_upload){
            $file = $request->customer_id_upload;
            if(in_array($file->extension(), ['png', 'jpeg','jpg'])){
                $path = base_path() . '/storage/app/public/receipts/';
                $file->move($path, "receipts/".$key.$file->getClientOriginalName());
                $path1 = "receipts/".$key.$file->getClientOriginalName();
            }
        }
        else{
            $path1="";
    }
        $data = array (
            'customer_id_image' => $path1,
            'receipt' => $path2,
            );
        $bacs_transaction = BacsTransaction::where(['user_id'=>$user_id,'order_id'=>$request->order_id])->update($data);
        if($bacs_transaction){
           // Mail::to($request->customer_email)->cc(['luca@prosperpoints.cl','admin@quikipay.com', User::find($transaction->user_id)->email])->queue( new BacsTransactionPending($bacs_transaction) );
            $response += ['code' => "200","message"=>"Successfully Uploaded"];
            $response= json_encode($response);
        }else{
            $response += ['code' => "400","message"=>"Error in Data Uploading or order id is not found"];
            $response= json_encode($response);
        }
    
    print_r($response);
    
});
Route::post('file-stream-upload', function(Request $request){
    $key=rand();
      $response=array();
    $validator =  Validator::make($request->all(),[
    'order_id' => 'required',
    'merchant_id'=>'required'
    ]);
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "message" => $validator->errors(),
        ], 422);
    }
   
    $user=User::where('merchant_id',$request->merchant_id)->first();
    if($user){
  
   $user_id=$user->id;
    if($request->receipt_upload){
            $path2 = $request->receipt_upload;
        }
        else{
            $path2="";
    }
    if($request->customer_id_upload){
            $path1 = $request->customer_id_upload;
        }
        else{
            $path1="";
    }
        $data = array (
            'customer_id_image_fintech' => $path1,
            'receipt_fintech' => $path2,
            );
        $bacs_transaction = BacsTransaction::where(['user_id'=>$user_id,'order_id'=>$request->order_id,'customer_email'=>$request->customer_email])->update($data);
        if($bacs_transaction){
            $response += ['code' => "200","message"=>"Successfully Uploaded"];
            $response= json_encode($response);
        }else{
            $response += ['code' => "404","message"=>"Error in Data Uploading or order id is not found"];
            $response= json_encode($response);
        }
    }else{
             $response += ['code' => "404","message"=>"Merchant id is empty or incorrect"];
        $response= json_encode($response);
     
    }
    print_r($response);
    
});
Route::post('change-min-order-limit', function(Request $request){
    $key=rand();
    $validator =  Validator::make($request->all(),[
    'merchant_id' => 'required',
    'limit'=>'required'
    ]);
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "message" => $validator->errors(),
        ], 422);
    }
    $user_id = User::where('merchant_id', $request->merchant_id)->firstOrFail()->id;
    if($user_id){
    $coin_settings=DB::table('coin_settings')->where(['user_id'=>$user_id])->update(['order_limit'=>$request->limit]);
    $response=array();
        if($coin_settings){
            $response += ['code' => "200","message"=>"Successfully Updated"];
            $response= json_encode($response);
        }else{
            $response += ['code' => "400","message"=>"Error in Data Updating or wrong User Id"];
            $response= json_encode($response);
        }
        }else{
             $response += ['code' => "400","message"=>"Error in Data Updating or wrong User Id"];
             $response= json_encode($response);
        }
    print_r($response);
    
});
Route::post('webhook', function(Request $request){
    $validator =  Validator::make($request->all(),[
    'redirect' => 'required',
    ]);
    if($validator->fails()){
        return response()->json([
            "error" => 'validation_error',
            "code" => '422',
            "message" => $validator->errors(),
        ], 422);
    }
    $transaction_id = '280';
    $bacs_transaction = BacsTransaction::find($transaction_id);
     $post = array(
            'tx_id' => $bacs_transaction->tx_id,
            'payment_method' => 'fiat',
            'order_id' => $bacs_transaction->order_id,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'deposit_at' => date('Y-m-d h:i:s',strtotime($bacs_transaction->created_at)),
            'status' => $bacs_transaction->status,
            'customer_email' => $bacs_transaction->customer_email,
            'customer_name' => $bacs_transaction->customer_name
            );
        $webhook_endpoint=$request->redirect;
        $response_webhook = Http::post($webhook_endpoint, $post);
        $response_webhook = json_decode($response_webhook->getBody());
        
    echo json_encode($post);
});
Route::post('webhook-received', function(Request $request){

     $tx_id=$request->all();

    Log::info("webhook Received Data",['data' => $tx_id]);
});
Route::get('fx-rates', function(Request $request){

        $response=Helper::getrates(); 
        $collection = collect($response);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
        if($keyed){
            echo json_encode($keyed->toArray());
        }else{
              return response()->json([
            "error" => 'Server Issue',
            "code" => '500',
            "message" => $validator->errors(),
        ], 500);
        }
});


        
