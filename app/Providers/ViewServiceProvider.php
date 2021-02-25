<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;
use App\Fiatrate;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $fiatRates = Fiatrate::all()->pluck('rate', 'currency_symbol')->toArray();
            
            $endpoint = "https://api.ibitt.co/v2/account/balances/FiatRates";
            $raw = "";
            $contentHash = hash('sha512', $raw);
            $current_timestamp = '""';
            $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
            $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
            
                $response = Http::withHeaders([
                        'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                        'Api-Timestamp' => $current_timestamp,
                        'Api-Content-Hash' => $contentHash,
                        'Api-Signature' => $apiSignature,
                        'Content-Type' => 'application/json'
                    ])->get($endpoint);
                $response = json_decode($response->getBody());
                
                if($fiatRates){
                   
                
                    // $collection = collect($response);
                
                    // $keyed = $collection->mapWithKeys(function ($item) {
                    //     return [$item->currency_symbol => $item->rate];
                    // });
                    
                    $view->with([
                        'pen' => $fiatRates['PEN'],
                        'ars' => $fiatRates['ARS'],
                        'clp' => $fiatRates['CLP']
                        ]);
                        
                } else {
                    $view->with([
                        'pen' => 3.6,
                        'ars' => 146,
                        'clp' => 791
                        ]);
                   
                   
                }
        });
    }
}
