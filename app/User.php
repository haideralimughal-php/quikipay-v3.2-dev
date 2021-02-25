<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address','contact','company_name', 'bank_name', 'bank_account', 'wallet', 'rut', 'logo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    public function coinSettings()
    {
        return $this->hasOne(CoinSetting::class);
    }

    public function addCoinSettings($data)
    {
        $this->coinSettings()->create($data);
    }
    
    public function withdrawals(){
        return $this->hasMany(Withdrawal::class)->latest();
    }
    
    public function localBank(){
        return $this->hasOne(LocalBank::class);
    }
    
    public function internationalBank(){
        return $this->hasOne(InternationalBank::class);
    }
    
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    
    public function addWallet($data)
    {
        return $this->wallet()->create($data);
    }
    
    public function bankInfo(){
        return $this->hasMany(BankInfo::class);
    }
    
    public function addBankInfo($data)
    {
        return $this->bankInfo()->updateOrCreate(
            ['currency' => $data['currency']],
            $data
        );
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            do {
                $merchant_id = Str::random(40);
            } while (!is_null(User::where('merchant_id', $merchant_id)->first()));
            $user->merchant_id = $merchant_id;
        });

        static::created(function ($user) {
            $endpoint = "https://api.ibitt.co/v2/account/addresses";
            
            $raw = "";
            $contentHash = hash('sha512', $raw);
            $current_timestamp = '""';
            $preSign = "GET|" . $endpoint . '|' . $current_timestamp . '|' . $contentHash;
            
            $apiSignature = hash_hmac('sha512', $preSign, '32610C1AB3E64C306F2DEF7D644C2D45');
    
            $response = Http::withHeaders([
                'Api-Key' => '597BEBB155EA765B3C1FCBD260005EF1',
                'Api-Timestamp' => $current_timestamp,
                'Api-Content-Hash' => $contentHash,
                'Api-Signature' => $apiSignature
            ])->get($endpoint);
            
            $addresses = json_decode($response->getBody());
            
            $data = [];
            
            foreach ($addresses as $address){
                if(!in_array($address->currency_symbol, ['ETH', 'XRP', 'BTC', 'LTC','USDT'])){
                    continue;
                }
                $data[strtolower($address->currency_symbol) . "_wallet"] = $address->crypto_address;
                if($address->currency_symbol == 'XRP'){
                    $data['xrp_tag'] = $address->crypto_address_tag;
                }
            }
            $user->addCoinSettings($data);
            
            $wallet = array(
                'usd' => 0,
                'ars' => 0,
                'clp' => 0,
                'sol' => 0
                );
                
            $user->addWallet($wallet);
        });
    }
}
