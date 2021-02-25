<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['user_id', 'bank', 'currency', 'amount', 'status','type','fx_rate'];
    
    public function getBank()
    {
        if($this->bank == 'local_bank')
            return $this->hasOne(LocalBank::class);
        else if($this->bank == 'international_bank')
            return $this->hasOne(InternationalBank::class);
        else if ($this->bank == 'paypal')
            return $this->hasOne(PaypalWithdrawal::class);
        else if ($this->bank == 'crypto')
            return $this->hasOne(CryptoWithdrawal::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function addWithdrawal($attribs){
        $newWithdrawal = $this->create($attribs);
        $newWithdrawal->getBank()->create($attribs);
        
        return $newWithdrawal;
    }
}
