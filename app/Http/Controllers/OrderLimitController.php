<?php

namespace App\Http\Controllers;

use App\Fees;
use App\User;
use DB;
use Illuminate\Http\Request;

class OrderLimitController extends Controller
{
    public function order_limit_settings(){
        $limit_settings = auth()->user()->coinSettings;
            return view('order_limit_setting.index',compact('limit_settings'));
    }
    public function order_limit_settings_update(){
        $attributes = ['order_limit' => request()->order_limit];
        auth()->user()->coinSettings()->update($attributes);
        session()->flash('message', 'Submitted successfully!'); 
         return back();
    }
    
}
