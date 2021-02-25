<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionReport;
use App\BacsTransaction;
use App\BacsDeposit;
use App\Wallet;
use App\CustomerWallet;
use App\User;
use App\Customer;
use App\Payment;
use Session;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\BacsTransactionCompleted;
use App\Mail\BacsCustomerCompleted;
use App\Mail\Invoice;
use App\Mail\SendBacsForReject;
use App\Mail\CustomerSendBacsForReject;
use App\Mail\SendFailForBacs;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Helper\Helper;
use DB;
class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    public function index(){
         $user_id=auth()->user()->id;
        if(auth()->user()->can('isAdmin')){
            //$transactions = Transaction::with("bacs_transactions")->latest()->get();
             $transactions = DB::table('transactions')
            ->leftJoin('bacs_transactions', ['transactions.user_id'=> 'bacs_transactions.user_id','transactions.order_id'=> 'bacs_transactions.order_id','transactions.deposit_id'=> 'bacs_transactions.tx_id' ])
             ->leftJoin('users', ['transactions.user_id'=>'users.id'])
            ->select('transactions.*', 'bacs_transactions.receipt', 'bacs_transactions.customer_id_image', 'bacs_transactions.customer_name','users.name', 'users.email')
            ->latest()
            ->get();
            $merchantEmail = User::select('email','id')->where('id','!=','1')->get()->toarray();
            $customer_emails = Transaction::select('customer_email')->distinct('customer_email')->get()->toarray();
            $deposit_id = Transaction::select('deposit_id')->distinct('deposit_id')->get()->toarray();
            $status = Transaction::select('status')->distinct('status')->get()->toarray();
            $currency = Transaction::select('currency_symbol')->distinct('currency_symbol')->get()->toarray();
       
            
        } else {
            //$transactions = auth()->user()->transactions;
             $transactions = DB::table('transactions')
            ->leftJoin('bacs_transactions', ['transactions.user_id'=> 'bacs_transactions.user_id','transactions.order_id'=> 'bacs_transactions.order_id','transactions.deposit_id'=> 'bacs_transactions.tx_id' ])
             ->leftJoin('users', ['transactions.user_id'=>'users.id'])
            ->where(['transactions.user_id'=>$user_id])
            ->select('transactions.*', 'bacs_transactions.receipt', 'bacs_transactions.customer_id_image', 'bacs_transactions.customer_name','users.name', 'users.email')
            ->latest()
            ->get();
            
            $merchantEmail = User::select('email','id')->where('id','=',$user_id)->get()->toarray();
            $customer_emails = Transaction::select('customer_email')->distinct('customer_email')->where('user_id','=',$user_id)->get()->toarray();
            $deposit_id = Transaction::select('deposit_id')->distinct('deposit_id')->where('user_id','=',$user_id)->get()->toarray();
            $status = Transaction::select('status')->distinct('status')->where('user_id','=',$user_id)->get()->toarray();
            $currency = Transaction::select('currency_symbol')->distinct('currency_symbol')->where('user_id','=',$user_id)->get()->toarray();
       
        }
        
           
        
       
        return view('transactions.index', compact('transactions','user_id','merchantEmail','customer_emails','deposit_id','status','currency'));
    }
    
    
    
    public function specificTransactions(Request $request){
        
        $filter=array();
        if(isset($request->range)){
            $range=explode(' - ',$request->range);
            $from= date_format(date_create($range[0]),"Y-m-d");
            $to= date_format(date_create($range[1]),"Y-m-d");
            $dateRange = $request->range;  
            Session::put('range', $dateRange);
        }
        if(auth()->user()->can('isAdmin'))
        {
            if($request->merchantId != "All"){
                $merchant_id = $request->merchantId;    
                $filter += ['transactions.user_id' => $merchant_id];
            }
        }
        if($request->customerEmail != "All"){
            $customerEmail = $request->customerEmail;    
            $filter += ['transactions.customer_email' => $customerEmail];
        }
        if($request->depositId != "All"){
            $deposit_id = $request->depositId;    
            $filter += ['transactions.deposit_id' => $deposit_id];
        }
        if($request->currencySymbol != "All"){
            $currency_symbol = $request->currencySymbol;    
            $filter += ['transactions.currency_symbol' => $currency_symbol];
        }
        
        if($request->status != "All"){
            $status = $request->status;    
            $filter += ['transactions.status' => $status];
            
        }
            Session::put('merchantId', $request->merchantId);
            Session::put('customerEmail', $request->customerEmail);
            Session::put('deposit_id', $request->depositId);
            Session::put('currency_symbol', $request->currencySymbol);
            Session::put('status', $request->status);
        
        
        $user_id=auth()->user()->id;
        if(auth()->user()->can('isAdmin')){
            if(isset($request->range)){
                $transactions = DB::table('transactions')
                ->leftJoin('bacs_transactions', ['transactions.user_id'=> 'bacs_transactions.user_id','transactions.order_id'=> 'bacs_transactions.order_id','transactions.deposit_id'=> 'bacs_transactions.tx_id' ])
                ->leftJoin('users', ['transactions.user_id'=>'users.id'])
                ->where($filter)
                ->whereBetween('transactions.created_at', array($from, $to))
                ->select('transactions.*', 'bacs_transactions.receipt', 'bacs_transactions.customer_id_image', 'bacs_transactions.customer_name','users.name','users.email')
                ->latest()
                ->get();
            }
            else{
                $transactions = DB::table('transactions')
                ->leftJoin('bacs_transactions', ['transactions.user_id'=> 'bacs_transactions.user_id','transactions.order_id'=> 'bacs_transactions.order_id','transactions.deposit_id'=> 'bacs_transactions.tx_id' ])
                ->leftJoin('users', ['transactions.user_id'=>'users.id'])
                ->where($filter)
                ->select('transactions.*', 'bacs_transactions.receipt', 'bacs_transactions.customer_id_image', 'bacs_transactions.customer_name','users.name','users.email')
                ->latest()
                ->get();
            }
            
        } else {
            if(isset($request->range)){
                $transactions = DB::table('transactions')
                ->leftJoin('bacs_transactions', ['transactions.user_id'=> 'bacs_transactions.user_id','transactions.order_id'=> 'bacs_transactions.order_id','transactions.deposit_id'=> 'bacs_transactions.tx_id' ])
                ->leftJoin('users', ['transactions.user_id'=>'users.id'])
                ->where('transactions.user_id',$user_id)
                ->where($filter)
                ->whereBetween('transactions.created_at', array($from, $to))
                ->select('transactions.*', 'bacs_transactions.receipt', 'bacs_transactions.customer_id_image', 'bacs_transactions.customer_name','users.name','users.email')
                ->latest()
                ->get();
            }else{
                $transactions = DB::table('transactions')
                ->leftJoin('bacs_transactions', ['transactions.user_id'=> 'bacs_transactions.user_id','transactions.order_id'=> 'bacs_transactions.order_id','transactions.deposit_id'=> 'bacs_transactions.tx_id' ])
                ->leftJoin('users', ['transactions.user_id'=>'users.id'])
                ->where('transactions.user_id',$user_id)
                ->where($filter)  
                ->select('transactions.*', 'bacs_transactions.receipt', 'bacs_transactions.customer_id_image', 'bacs_transactions.customer_name','users.name','users.email')
                ->latest()
                ->get();
            }
        }
        
        
            $merchantEmail = User::select('email','id')->where('id','!=','1')->get()->toarray();
            $customer_emails = Transaction::select('customer_email')->distinct('customer_email')->get()->toarray();
            $deposit_id = Transaction::select('deposit_id')->distinct('deposit_id')->get()->toarray();
            $status = Transaction::select('status')->distinct('status')->get()->toarray();
            $currency = Transaction::select('currency_symbol')->distinct('currency_symbol')->get()->toarray();
        
         return view('transactions.index', compact('transactions','user_id','merchantEmail','customer_emails','deposit_id','status','currency'));
       
         
    }
    
    
    public function reuploadImages(Request $request){
       
      if(request()->hasFile('pic1')){
         $path = request()->file('pic1')->store('receipts', 'public');
        }
        else{
            $path="";
        }
        
        if(request()->hasFile('pic2')){
            $path1 = request()->file('pic2')->store('receipts', 'public');
        }
        else{
            $path1="";
        }
        $flag=DB::table("bacs_transactions")
        ->where(['order_id'=>$request->order_id_m_m, 'tx_id'=>$request->deposit_id_m_m, 'customer_email'=>$request->customer_email_m_m])
        ->update(['receipt'=>$path, 'customer_id_image'=>$path1]);
        if($flag){
            session()->flash('message', 'Submitted successfully!'); 
        }else{
             session()->flash('error', 'Some Error Please Try Again'); 
        }
          return back();
        
    }
   
    public function bacsTransactions(){
        if(auth()->user()->can('isAdmin')){
            $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')->latest()->get();
            $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->latest()->get();
            $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->latest()->get();
            
            $merchantEmail = User::select('email','id')->where('id','!=','1')->get()->toarray();
            $customer_emails = BacsTransaction::select('customer_email')->distinct('customer_email')->get()->toarray();
            $tx_id = BacsTransaction::select('tx_id')->distinct('tx_id')->get()->toarray();
            $status = BacsTransaction::select('status')->distinct('status')->get()->toarray();
            $currency = BacsTransaction::select('currency_symbol')->distinct('currency_symbol')->get()->toarray();
            
             
        }
        return view('transactions.bacs_transactions', compact('transactions','customer_emails','tx_id','status','currency','merchantEmail'));
    }
    
    public function specificBacsTransactions(Request $request){
        
        $filter=array();
        if(isset($request->range)){
            $range=explode(' - ',$request->range);
            $from= date_format(date_create($range[0]),"Y-m-d");
            $to= date_format(date_create($range[1]),"Y-m-d");
            $dateRange = $request->range;  
            Session::put('range', $dateRange);
            
            
        }
        if($request->merchantId != "All"){
            $user_id = $request->merchantId;    
            $filter += ['user_id' => $user_id];
        }
        if($request->customerEmail != "All"){
            $customerEmail = $request->customerEmail;    
            $filter += ['customer_email' => $customerEmail];
        }
        if($request->txId != "All"){
            $tx_id = $request->txId;    
            $filter += ['tx_id' => $tx_id];
        }
        if($request->currencySymbol != "All"){
            $currency_symbol = $request->currencySymbol;    
            $filter += ['currency_symbol' => $currency_symbol];
        }
        if($request->status != "All"){
            $status = $request->status;    
            $filter += ['status' => $status];
            
        }
            Session::put('merchantId', $request->merchantId);
            Session::put('customerEmail', $request->customerEmail);
            Session::put('tx_id', $request->txId);
            Session::put('currency_symbol', $request->currencySymbol);
            Session::put('status', $request->status);

        if(isset($request->range)){
        $transactions =BacsTransaction::with('user')->where($filter)->whereBetween('created_at', array($from, $to))->latest()->get();
        }else{
        $transactions =BacsTransaction::with('user')->where($filter)->latest()->get();
        }
        $merchantEmail = User::select('email','id')->where('id','!=','1')->get()->toarray();
            $customer_emails = BacsTransaction::select('customer_email')->distinct('customer_email')->get()->toarray();
            $tx_id = BacsTransaction::select('tx_id')->distinct('tx_id')->get()->toarray();
            $status = BacsTransaction::select('status')->distinct('status')->get()->toarray();
            $currency = BacsTransaction::select('currency_symbol')->distinct('currency_symbol')->get()->toarray();
       
        // if($request->SendStatus == "confirmed"){
        //     $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')
        //     ->whereBetween('created_at', array($from, $to))
        //     ->latest()->get();
        //     $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->latest()->get();
        //     $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->latest()->get();
        //     $ActiveTab = "confirmed";
        // }else if($request->SendStatus == "pending"){
        //     $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->whereBetween('created_at', array($from, $to))->latest()->get();
        //     $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')->latest()->get();
        //     $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->latest()->get();
        //     $ActiveTab = "pending";
        // }else{
        //     $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->whereBetween('created_at', array($from, $to))->latest()->get();
        //     $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->latest()->get();
        //     $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')->latest()->get();
        //     $ActiveTab = "reject";
            
        // }      
       
        return view('transactions.specific_bacs_transactions', compact('transactions','customer_emails','tx_id','status','currency','merchantEmail'));   
        // return view('transactions.bacs_transactions', compact('transactions','ActiveTab'));   
    }
    
    public function confirmTransaction(){
        $transaction_id = request('transaction_id');
        $bacs_transaction = BacsTransaction::find($transaction_id);
        $bacs_transaction->update(['status' => 'completed']);
        
         DB::table('transactions')
        ->where('user_id',$bacs_transaction->user_id)
        ->where('deposit_id',$bacs_transaction->tx_id)
        ->where('order_id',$bacs_transaction->order_id)
        ->update(['status' => 'COMPLETED']);
        
        $transaction = Transaction::where('user_id',$bacs_transaction->user_id)
        ->where('deposit_id',$bacs_transaction->tx_id)
        ->where('order_id',$bacs_transaction->order_id)
        ->first();
        
        
        
        $user = User::find($bacs_transaction->user_id);
        
        $response_rate=Helper::getrates(); 
        $collection = collect($response_rate);
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item->currency_symbol => $item->rate];
        });
        $fees=Helper::fees_calculate($bacs_transaction->user_id,$bacs_transaction->currency_symbol,'bacs',$bacs_transaction->quantity); 
        $mercant_increment=$bacs_transaction->quantity-$fees;
        
        
        $report = array(
            'user_id'=>$bacs_transaction->user_id,
            'order_id'=>$bacs_transaction->order_id,
            'transaction_id' => $bacs_transaction->tx_id,
            'fees' => $fees,
            'total_amount' => $bacs_transaction->quantity,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'type' => 'bacs',
            'fx_rate'=>$keyed[$bacs_transaction->currency_symbol].'x'.$bacs_transaction->currency_symbol.'= 1USD',
            );
        DB::table('transaction_reports')->insert($report);
        Wallet::where('user_id', $bacs_transaction->user_id)->increment(strtolower($bacs_transaction->currency_symbol), $mercant_increment);
        
        $post = array(
            'tx_id' => $bacs_transaction->tx_id,
            'payment_method' => 'fiat',
            'order_id' => $bacs_transaction->order_id,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'deposit_at' => $bacs_transaction->created_at,
            'status' => $bacs_transaction->status,
            'customer_email' => $bacs_transaction->customer_email
            );
        $payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $bacs_transaction->order_id])->first();
        if($payment){
            $endpoint = $payment->site_url . '/wp-json/quikipay/v1/order/' . $bacs_transaction->order_id.'?status=completed';
            $webhook_endpoint = $payment->redirect;
             $response_webhook = Http::post($webhook_endpoint, $post);
        $response_webhook = json_decode($response_webhook->getBody());
       
        } else {
            $endpoint = $bacs_transaction->user->coinSettings->success_url_fiat;
            
        }
           Log::info('webhook is sent for confirm', ['data' => $post]);
        $response = Http::get($endpoint, $post);
        $response = json_decode($response->getBody());
        
           $email_flag= $user->coinSettings->email_flag;
           if($email_flag=="1")
           $user_email=$bacs_transaction->customer_email;
           else
           $user_email="haideralimughalers@gmail.com";
           
        $mail = Mail::to($user_email)->cc(['payment@quikipay.com', $user->email])->queue( new BacsTransactionCompleted($bacs_transaction) );
        $products=json_decode($bacs_transaction->products_data);
        if($products){
            $mail = Mail::to($user_email)->cc(['payment@quikipay.com', $user->email])->queue( new Invoice($transaction) );
        }
        
        return back();
    }
   

    public function rejectTransaction(){
        $transaction_id = request('transaction_id');
        $reason = request('reason');
        $bacs_transaction = BacsTransaction::find($transaction_id);

        $bacs_transaction->update(['status' => 'reject', 'rejected_reason'=>$reason]);
         Transaction::where('deposit_id', $bacs_transaction->tx_id)->update(['status'=>'REJECT']);
        $user = User::find($bacs_transaction->user_id);
      
        $payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $bacs_transaction->order_id])->first();
    
         $post = array(
            'tx_id' => $bacs_transaction->tx_id,
            'payment_method' => 'fiat',
            'order_id' => $bacs_transaction->order_id,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'deposit_at' => $bacs_transaction->created_at,
            'status' => $bacs_transaction->status,
            'customer_email' => $bacs_transaction->customer_email
            );
          Log::info('webhook is sent for reject', ['data' => $post]);

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
        
       
        
           $email_flag= $user->coinSettings->email_flag;
           if($email_flag=="1")
           {
                $raw = $bacs_transaction->user_id . '/' . $payment->customer_email . '/' . $payment->amount . '/' . $payment->order_id . '/' . $payment->currency;
                $hash = hash('sha512', $raw);
                $tokenized_link = url("/pay/bacs/" . $bacs_transaction->user_id  . '/' . $payment->customer_email . '/' . $payment->amount . '/' . $payment->order_id . '/' . $payment->currency . '/' . $hash);
                Mail::to($payment->customer_email)->send(new SendBacsForReject($bacs_transaction,$tokenized_link));
           }
        return back();
    }
   
    public function disapproveTransaction(){
         $transaction_id = request('transaction_id');
        
        $bacs_transaction = BacsTransaction::find($transaction_id);
        
        $bacs_transaction->update(['status' => 'pending']);
        $user = User::find($bacs_transaction->user_id);
        
      //  Transaction::where('deposit_id', $bacs_transaction->tx_id)->delete();
      Transaction::where('deposit_id', $bacs_transaction->tx_id)->update(['status'=>'PENDING']);
        
        Wallet::where('user_id', $bacs_transaction->user_id)->decrement(strtolower($bacs_transaction->currency_symbol), $bacs_transaction->quantity);
        
        $post = array(
            'tx_id' => $bacs_transaction->tx_id,
            'payment_method' => 'fiat',
            'order_id' => $bacs_transaction->order_id,
            'currency_symbol' => $bacs_transaction->currency_symbol,
            'quantity' => $bacs_transaction->quantity,
            'deposit_at' => $bacs_transaction->created_at,
            'status' => $bacs_transaction->status,
            'customer_email' => $bacs_transaction->customer_email
            );
        
        $payment = Payment::where(['merchant' => $user->merchant_id, 'order_id' => $bacs_transaction->order_id])->first();
        
        if($payment){
            $webhook_endpoint = $payment->redirect;
            $response_webhook = Http::post($webhook_endpoint, $post);
            $response_webhook = json_decode($response_webhook->getBody());
            $endpoint = $payment->site_url . '/wp-json/quikipay/v1/order/' . $bacs_transaction->order_id.'?status=pending';
        } else {
            $endpoint = $bacs_transaction->user->coinSettings->success_url_fiat;
        }
        $response = Http::get($endpoint, $post);
        $response = json_decode($response->getBody());
        
        return back();
    }
   
    public function transactionReports(){
        if(auth()->user()->can('isAdmin')){
            $reports = TransactionReport::latest()->get();
        } else {
            $user_id = auth()->user()->id;
           $reports = DB::table('transaction_reports')
            ->where('user_id',$user_id)
            ->latest()
           ->get();
        }
        
        return view('report',compact('reports'));   
    }
    
    public function specificTransactionReports(Request $request){
        
        $range=explode(' - ',$request->range);
        $from= date_format(date_create($range[0]),"Y-m-d");
        $to= date_format(date_create($range[1]),"Y-m-d");
        
        
        //$reports = TransactionReport::all();
        
       
           if(auth()->user()->can('isAdmin')){
           $reports = DB::table('transaction_reports')
           ->whereBetween('created_at', array($from, $to))
           ->latest()
           ->get();
        } else {
            $user_id = auth()->user()->id;
            $reports = DB::table('transaction_reports')
            ->where('user_id',$user_id)
           ->whereBetween('created_at', array($from, $to))
           ->latest()
           ->get();
        }
         
        return view('report',compact('reports'));   
    }
    
    /////////////////////Customers/////////////////////
    
    public function customerBacsTransactions(){
        if(auth()->user()->can('isAdmin')){
            $transactions['completed'] = DB::table('bacs_deposits')->join('customers', 'bacs_deposits.user_id', '=', 'customers.id')->select('bacs_deposits.*', 'customers.name','customers.email')->where('status', 'completed')->latest()->get();
            $transactions['pending'] = DB::table('bacs_deposits')->join('customers', 'bacs_deposits.user_id', '=', 'customers.id')->select('bacs_deposits.*', 'customers.name','customers.email')->where('status', 'pending')->latest()->get();
            $transactions['reject'] = DB::table('bacs_deposits')->join('customers', 'bacs_deposits.user_id', '=', 'customers.id')->select('bacs_deposits.*', 'customers.name','customers.email')->where('status', 'reject')->latest()->get();
        
            $customer_emails = DB::table('customers')->select('email','id')->distinct('email')->get()->toarray();
            $tx_id = DB::table('bacs_deposits')->select('tx_id')->distinct('tx_id')->get()->toarray();
            $status = DB::table('bacs_deposits')->select('status')->distinct('status')->get()->toarray();
            $currency = DB::table('bacs_deposits')->select('currency_symbol')->distinct('currency_symbol')->get()->toarray();
        
        
        
             return view('transactions.customer-bacs-transactions', compact('transactions','currency','customer_emails','tx_id','status'));
        }
       
    }
    
    
    public function specificCustomerBacsTransactions(Request $request){
        
        
        
        $filter=array();
        if(isset($request->range)){
            $range=explode(' - ',$request->range);
            $from= date_format(date_create($range[0]),"Y-m-d");
            $to= date_format(date_create($range[1]),"Y-m-d");
            $dateRange = $request->range;  
            Session::put('range', $dateRange);
        }
        
        if($request->userId != "All"){
            $userId = $request->userId;    
            $filter += ['user_id' => $userId];
        }
        if($request->txId != "All"){
            $tx_id = $request->txId;    
            $filter += ['tx_id' => $tx_id];
        }
        if($request->currencySymbol != "All"){
            $currency_symbol = $request->currencySymbol;    
            $filter += ['currency_symbol' => $currency_symbol];
        }
        if($request->status != "All"){
            $status = $request->status;    
            $filter += ['status' => $status];
            
        }
            Session::put('userId', $request->userId);
            Session::put('tx_id', $request->txId);
            Session::put('currency_symbol', $request->currencySymbol);
            Session::put('status', $request->status);

            if(isset($request->range)){
            $transactions = DB::table('bacs_deposits')->join('customers', 'bacs_deposits.user_id', '=', 'customers.id')
             ->select('bacs_deposits.*', 'customers.name','customers.email')
             ->where($filter)
             ->whereBetween('bacs_deposits.created_at', array($from, $to))
             ->latest()
             ->get();
            }else{
                
            $transactions = DB::table('bacs_deposits')->join('customers', 'bacs_deposits.user_id', '=', 'customers.id')
             ->select('bacs_deposits.*', 'customers.name','customers.email')
             ->where($filter)
             ->latest()
             ->get();
            }
            
       
       
         
         $customer_emails = DB::table('customers')->select('email','id')->distinct('email')->get()->toarray();
            $tx_id = DB::table('bacs_deposits')->select('tx_id')->distinct('tx_id')->get()->toarray();
            $status = DB::table('bacs_deposits')->select('status')->distinct('status')->get()->toarray();
            $currency = DB::table('bacs_deposits')->select('currency_symbol')->distinct('currency_symbol')->get()->toarray();
          
        // if($request->SendStatus == "confirmed"){
        //     $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')
        //     ->whereBetween('created_at', array($from, $to))
        //     ->latest()->get();
        //     $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->latest()->get();
        //     $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->latest()->get();
        //     $ActiveTab = "confirmed";
        // }else if($request->SendStatus == "pending"){
        //     $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->whereBetween('created_at', array($from, $to))->latest()->get();
        //     $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')->latest()->get();
        //     $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->latest()->get();
        //     $ActiveTab = "pending";
        // }else{
        //     $transactions['reject'] = BacsTransaction::with('user')->where('status', 'reject')->whereBetween('created_at', array($from, $to))->latest()->get();
        //     $transactions['pending'] = BacsTransaction::with('user')->where('status', 'pending')->latest()->get();
        //     $transactions['completed'] = BacsTransaction::with('user')->where('status', 'completed')->latest()->get();
        //     $ActiveTab = "reject";
            
        // }      
        return view('transactions.specific_customers_bacs_transactions', compact('transactions','customer_emails','tx_id','status','currency'));   
        // return view('transactions.bacs_transactions', compact('transactions','ActiveTab'));   
    }
    
    
    public function customerconfirmTransaction(){
        
        $transaction_id = request('transaction_id');
        $bacs_transaction = BacsDeposit::find($transaction_id);
        $bacs_transaction->update(['status' => 'completed']);
        
        $deposit = DB::table('deposits')
        ->where('customer_id',$bacs_transaction->user_id)
        ->where('deposit_id',$bacs_transaction->tx_id)
        ->update(['status' => 'COMPLETED']);
       
      
        $user = Customer::find($bacs_transaction->user_id);
        
      
       // $response_rate=Helper::getrates(); 
        // $collection = collect($response_rate);
        // $keyed = $collection->mapWithKeys(function ($item) {
        //     return [$item->currency_symbol => $item->rate];
        // });
        // $fees=Helper::fees_calculate($bacs_transaction->user_id,$bacs_transaction->currency_symbol,'bacs',$bacs_transaction->quantity); 
         $mercant_increment=$bacs_transaction->amount;
        
        
     
        $user->customerWallet()->increment(strtolower($bacs_transaction->currency_symbol), $mercant_increment);
        
        $mail = Mail::to($user->email)->cc(['payment@quikipay.com'])->queue( new BacsCustomerCompleted($bacs_transaction) );
     
        return back();
    }
    public function customerDisapproveTransaction(){
         $transaction_id = request('transaction_id');
        
        $bacs_transaction = BacsDeposit::find($transaction_id);
        $bacs_transaction->update(['status' => 'pending']);
        
         $deposit = DB::table('deposits')
        ->where('customer_id',$bacs_transaction->user_id)
        ->where('deposit_id',$bacs_transaction->tx_id)
        ->update(['status' => 'PENDING']);
       
        $user = Customer::find($bacs_transaction->user_id);
        
          $mercant_increment=$bacs_transaction->amount;
          
        $user->customerWallet()->decrement(strtolower($bacs_transaction->currency_symbol), $mercant_increment);
        
        return back();
    }
    public function customerRejectTransaction(){
        $transaction_id = request('transaction_id');
        $reason = request('reason');
        $bacs_transaction = BacsDeposit::find($transaction_id);
        $bacs_transaction->update(['status' => 'reject', 'rejected_reason'=>$reason]);
        $deposit = DB::table('deposits')
        ->where('customer_id',$bacs_transaction->user_id)
        ->where('deposit_id',$bacs_transaction->tx_id)
        ->update(['status' => 'REJECT']);
        $user = Customer::find($bacs_transaction->user_id);
        
        
        $raw = $user->id . '/' . $bacs_transaction->amount . '/' . $bacs_transaction->currency_symbol;

        $hash = hash('sha512', $raw);

        $tokenized_link = "https://user.quikipay.com/deposits/bacs/" . $raw . '/' . $hash;

        Mail::to($user->email)->send(new CustomerSendBacsForReject($bacs_transaction,$tokenized_link));
        return back();
    }
}
