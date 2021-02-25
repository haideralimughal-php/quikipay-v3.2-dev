<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\SharedBalance;

class SharedBalanceController extends Controller
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
        if(auth()->user()->can('isAdmin')){
            $transactions = SharedBalance::with('from', 'to')->get();
        } else {
            abort(403);
        }
       
        return view('shared-balances.index', compact('transactions','user_id'));
    }
}
