<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoinsController extends Controller
{
    public function index()
    {
        $coin_settings = auth()->user()->coinSettings;
        $geolocation = geoip(\Request::ip());
        return view('coin-settings.index', compact('coin_settings','geolocation'));
    }

    public function update()
    {
      // dd(request());
        $attributes = request()->validate([
           
            // 'bacs' => ['required_if:bacs,on'],
            // 'khypo' => ['required_if:khypo,on'],
            // 'khypo_credit' => ['required_if:khypo_credit,on'],
            // // 'crypto' => ['required_if:crypto,on'],
            // 'blockfort' => ['required_if:blockfort,on'],
        ]);

        if(!isset(request()->bacs)){
            $attributes += ['bacs' => 0];
        } else {
            $attributes += ['bacs' => 1];
        }
        if(!isset(request()->khypo)){
            $attributes += ['khypo' => 0];
        } else {
            $attributes += ['khypo' => 1];
        }
        if(!isset(request()->khypo_credit)){
            $attributes += ['khypo_credit' => 0];
        } else {
            $attributes += ['khypo_credit' => 1];
        }
        if(!isset(request()->crypto)){
            $attributes += ['crypto' => 0];
        } else {
            $attributes += ['crypto' => 1];
        }
        if(!isset(request()->blockfort)){
            $attributes += ['blockfort' => 0];
        } else {
            $attributes += ['blockfort' => 1];
        }
         if(!isset(request()->hites)){
            $attributes += ['hites' => 0];
        } else {
            $attributes += ['hites' => 1];
        }
         if(!isset(request()->pago)){
            $attributes += ['pago' => 0];
        } else {
            $attributes += ['pago' => 1];
        }
        if(!isset(request()->btc)){
            $attributes += ['btc' => false];
        } else {
            $attributes += ['btc' => true];
        }
        if(!isset(request()->eth)){
            $attributes += ['eth' => false];
        } else {
            $attributes += ['eth' => true];
        }
        if(!isset(request()->ltc)){
            $attributes += ['ltc' => false];
        } else {
            $attributes += ['ltc' => true];
        }
        if(!isset(request()->xrp)){
            $attributes += ['xrp' => false];
        } else {
            $attributes += ['xrp' => true];
        }
        if(!isset(request()->usdt)){
            $attributes += ['usdt' => false];
        } else {
            $attributes += ['usdt' => true];
        }
        
        if(!empty(request('success_url'))){
            $attributes += ['success_url' => request('success_url')];
        }
        
        if(!empty(request('success_url_fiat'))){
            $attributes += ['success_url_fiat' => request('success_url_fiat')];
        }

        auth()->user()->coinSettings()->update($attributes);

        return redirect('/coin-settings');
    }
}
