<?php

namespace App\Http\Controllers;

use App\MerchantWithdrawalAddress;
use Illuminate\Http\Request;
class MerchantWithdrawalAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $addresses = MerchantWithdrawalAddress::all();
        return view('merchants_wallet_addresses', compact('addresses'));
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
        $NewWallet = new MerchantWithdrawalAddress();
        
        $NewWallet->address = request()->address;
        $NewWallet->currency_symbol = request()->currency_symbol;
        $NewWallet->user_id = auth()->user()->id;
 
        
        
        $NewWallet->save();
        
            return redirect('merchants_wallet_addresses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MerchantWithdrawalAddress  $merchantWithdrawalAddress
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $crypto=$request->crypto;
         $addresses = MerchantWithdrawalAddress::where(["currency_symbol"=>$crypto])->get();
         $data="";
         if($addresses){
             foreach($addresses as $addressesarray)
             $data.="<option value='$addressesarray->address'>$addressesarray->address</option>";
         }else{
            $data.="<option disabled value='Not Found'>NotFound</option>";
         }
        echo $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MerchantWithdrawalAddress  $merchantWithdrawalAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(MerchantWithdrawalAddress $merchantWithdrawalAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MerchantWithdrawalAddress  $merchantWithdrawalAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MerchantWithdrawalAddress $merchantWithdrawalAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MerchantWithdrawalAddress  $merchantWithdrawalAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $address = MerchantWithdrawalAddress::find($request->id);
        $address->delete();
        //
        
         return redirect()->back();
    }
}
