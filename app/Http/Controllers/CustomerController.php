<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $user->load('customerWallet');
        return $user;
    }

    public function payWithWallet(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'currency_symbol' => 'required',
            'amount' => 'required',
        ]);

        $user = $request->user();
        $currency = strtolower($request->currency_symbol);

        if ($user->customerWallet->$currency <= $request->amount) {
            return response()->json([
                'success' => false,
                'message' => "You don't have enough balance in your wallet.",
            ]);
        }

        DB::beginTransaction();

        try {
            $decrement = $user->customerWallet()->decrement($currency, $request->amount);
            if ($decrement) {
                $transaction = $user->customerTransactions()->create([
                    'deposit_id' => rand() . $request->order_id,
                    'order_id' => $request->order_id,
                    'currency_symbol' => strtoupper($currency),
                    'amount' => $request->amount,
                    'paid_at' => date('Y-m-d H:i:s'),
                    'status' => 'completed'
                ]);

                if (!$transaction) {
                    $user->customerWallet()->increment($currency, $request->amount);
                    return response()->json([
                        'success' => true,
                        'message' => $e->getMessage(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Payment successful",
                'data' => ['deposit_id' => $transaction->deposit_id]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            $user->customerWallet()->increment($currency, $request->amount);
            return response()->json([
                'success' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
