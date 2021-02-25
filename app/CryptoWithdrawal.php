<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoWithdrawal extends Model
{
    protected $fillable = ['withdrawal_id', 'crypto_currency', 'crypto_address'];

    public function Withdrawal()
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
