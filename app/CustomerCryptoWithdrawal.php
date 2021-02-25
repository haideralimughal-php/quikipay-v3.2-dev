<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCryptoWithdrawal extends Model
{
    protected $fillable = ['customer_withdrawal_id', 'crypto_currency', 'crypto_address'];

    public function customerWithdrawal()
    {
        return $this->belongsTo(CustomerWithdrawal::class);
    }
}
