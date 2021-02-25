<?php

namespace App\Helper;
use Illuminate\Support\Facades\DB;
use App\CurrencyConversion;


class Helper
{
    public static function getrates()
      {
           $fiatrates = DB::table('fiatrates')->get();
             return $fiatrates;
      }
    public static function fees_calculate($user_id,$currency,$type,$amount){
        if($currency=="CLP"){
         $data = DB::table('fees_chile')->select($type)->where('user_id',$user_id)->get();
         if(is_numeric($data["0"]->$type)){
            $fees=$amount*$data[0]->$type/100;
         }else{
             $fees="0";
         }
        }
         elseif($currency=="ARS"){
         $data = DB::table('fees_ars')->select($type)->where('user_id',$user_id)->get();
         if(is_numeric($data["0"]->$type)){
            $fees=$amount*$data[0]->$type/100;
         }else{
             $fees="0";
         }
         }
         elseif($currency=="PEN" or $currency=="SOL"){
         $data = DB::table('fees_peru')->select($type)->where('user_id',$user_id)->get();
         if(is_numeric($data["0"]->$type)){
            $fees=$amount*$data[0]->$type/100;
         }else{
             $fees="0";
         }
         }
         elseif($currency=="USD"){
         $data = DB::table('fees_other')->select($type)->where('user_id',$user_id)->get();
          if(is_numeric($data["0"]->$type)){
            $fees=$amount*$data[0]->$type/100;
         }else{
             $fees="0";
         }
         }
        //  $data['panama'] = DB::table('fees_panama')->where('user_id',$user_id)->get();
        //  $data['venz'] = DB::table('fees_venz')->where('user_id',$user_id)->get();
         
         return $fees;
         
         
    }
      public static function save_order($currency,$rate,$amount){
         
            $fees=Helper::fees_calculate(auth()->user()->id,strtoupper($currency),'conversion',$amount); 
            $total_fiat=$amount-$fees;
            $currency_rate=$rate;
            $balance_quantity_received_USD=$amount/$currency_rate;
                auth()->user()->wallet()->increment($currency, $amount);
                $order = new CurrencyConversion;
                $order->user_id = auth()->user()->id;
                $order->conversion_id = rand();
                $order->from_currency = strtoupper($currency);
                $order->to_currency = 'USD';
                $order->received_usd = $balance_quantity_received_USD;
                $order->taken_fiat =$currency_rate;
                $order->rate = $currency_rate;
                $order->status = 'Completed';
                $order->completed_on = date('Y-m-d H:i:s', strtotime('now'));
                $order->save();
            
          
     
        $report = array(
            'user_id'=>auth()->user()->id,
            'order_id'=>$order->id,
            'transaction_id' => rand(),
            'fees' => $fees,
            'total_amount' => $amount,
            'currency_symbol' => strtoupper($currency),
            'type' => 'conversion',
            'fx_rate'=>$currency_rate.' x '.$currency.'= 1USD',
            );
        $report=DB::table('transaction_reports')->insert($report);
       return $report;     
      }


}
?>