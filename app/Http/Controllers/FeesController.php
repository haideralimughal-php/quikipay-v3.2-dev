<?php

namespace App\Http\Controllers;

use App\Fees;
use App\User;
use DB;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    
    public function get_fees(){
         $user_id = $_GET['user_id'];
         $data['chile'] = DB::table('fees_chile')->where('user_id',$user_id)->get();
         $data['ars'] = DB::table('fees_ars')->where('user_id',$user_id)->get();
         $data['peru'] = DB::table('fees_peru')->where('user_id',$user_id)->get();
         $data['panama'] = DB::table('fees_panama')->where('user_id',$user_id)->get();
         $data['venz'] = DB::table('fees_venz')->where('user_id',$user_id)->get();
         $data['other'] = DB::table('fees_other')->where('user_id',$user_id)->get();
         echo $data=json_encode($data);
         
    }
    
    
    public function get_fees_for_merchant_panel(){
         $user_id = auth()->user()->id;
         $data['chile'] = DB::table('fees_chile')->where('user_id',$user_id)->get();
         $data['ars'] = DB::table('fees_ars')->where('user_id',$user_id)->get();
         $data['peru'] = DB::table('fees_peru')->where('user_id',$user_id)->get();
         $data['panama'] = DB::table('fees_panama')->where('user_id',$user_id)->get();
         $data['venz'] = DB::table('fees_venz')->where('user_id',$user_id)->get();
         $data['other'] = DB::table('fees_other')->where('user_id',$user_id)->get();
         return view('fees.index',compact('data'));
    }
    public function fees_save(Request $request){
        
        $fees_chile = DB::table('fees_chile')->updateOrInsert(
              
              ['user_id' => $request->user_id],
              
              [
              'bacs' => $request->bacsChile,
              'pago' => $request->pagoChile,
              'debit_credit' => $request->cardChile,
              'crypto' => $request->cryptoChile,
              'hites' => $request->hitesChile,
              'conversion' => $request->usdChile,
              ]
              
            );
        $fees_ars = DB::table('fees_ars')->updateOrInsert(
              
              ['user_id' => $request->user_id],
              
              [
              'bacs' => $request->bacsArgentina,
              'pago' => $request->pagoArgentina,
              'debit_credit' => $request->cardArgentina,
              'crypto' => $request->cryptoArgentina,
              'hites' => $request->hitesArgentina,
              'conversion' => $request->usdArgentina,
              ]
              
             );
        $fees_peru = DB::table('fees_peru')->updateOrInsert(
              
              ['user_id' => $request->user_id],
              
              [
              'bacs' => $request->bacsPeru,
              'pago' => $request->pagoPeru,
              'debit_credit' => $request->cardPeru,
              'crypto' => $request->cryptoPeru,
              'hites' => $request->hitesPeru,
              'conversion' => $request->usdPeru,
              ]
              
             );
        $fees_panama = DB::table('fees_panama')->updateOrInsert(
              
              ['user_id' => $request->user_id],
              
              [
              'bacs' => $request->bacsPanama,
              'pago' => $request->pagoPanama,
              'debit_credit' => $request->cardPanama,
              'crypto' => $request->cryptoPanama,
              'hites' => $request->hitesPanama,
              'conversion' => $request->usdPanama,
              ]
              
             );
        $fees_venz = DB::table('fees_venz')->updateOrInsert(
              
               ['user_id' => $request->user_id],
              
              [
              'bacs' => $request->bacsVenezuela,
              'pago' => $request->pagoVenezuela,
              'debit_credit' => $request->cardVenezuela,
              'crypto' => $request->cryptoVenezuela,
              'hites' => $request->hitesVenezuela,
              'conversion' => $request->usdVenezuela,
              ]
              
             );
        $fees_other = DB::table('fees_other')->updateOrInsert(
              
               ['user_id' => $request->user_id],
              
              [
              'bacs' => $request->bacsOthers,
              'pago' => $request->pagoOthers,
              'debit_credit' => $request->cardOthers,
              'crypto' => $request->cryptoOthers,
              'hites' => $request->hitesOthers,
              'conversion' => $request->usdOthers,
              ]
              
             );
        session()->flash('message', 'Submitted successfully!'); 
        return back();
    }
    
}
