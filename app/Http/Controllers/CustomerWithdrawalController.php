<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerWithdrawal;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Helper\Helper;
use DB;
use App\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawCompleted;
use App\Mail\WithdrawRejected;
use App\Mail\WithdrawFailed;


class CustomerWithdrawalController extends Controller
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

    public function index()
    {
        $withdrawals = CustomerWithdrawal::with('customer')->get();
        
        return view('customer-withdrawals.index', compact('withdrawals'));
    }
  
    public function customerRequest($param){
        if($param == 'wr'){
            $withdrawals = CustomerWithdrawal::with('customer')->where('status','pending')->get();
        }else if($param == 'wh'){
            $withdrawals = CustomerWithdrawal::with('customer')->where('status','!=','pending')->get();
        }
        
        return view('customer-withdrawals.customer-requests', compact('withdrawals','param'));
    }
    
    
    public function show(Request $request, CustomerWithdrawal $withdrawal)
    {
        return view('customer-withdrawals.show', compact('withdrawal'));
    }
    
    public function review(Request $request){
        $data = $request->validate([
            'withdrawal_id' => ['required'],
            'status' => ['required', 'in:accepted,rejected']
        ]);
        
        $withdrawal = CustomerWithdrawal::findOrFail($data['withdrawal_id']);
        $withdrawal->update(['status' => $data['status']]);
        
        if($data['status'] == 'rejected'){
            $withdrawal->customer->customerWallet()->increment(strtolower($withdrawal->currency), $withdrawal->amount);
            
             Mail::to($withdrawal->customer->email)->cc([ User::first()->email])->send( new WithdrawRejected($withdrawal) );
        }else{
            Mail::to($withdrawal->customer->email)->cc([User::first()->email])->send( new WithdrawCompleted($withdrawal) );
        }
        return redirect()->back()->with('success', 'Withdrawal ' . $data['status'] . ' successfully!');
    }
    
    
}
