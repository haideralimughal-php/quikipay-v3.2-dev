<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerLocalBank extends Model
{
    protected $fillable = ['customer_withdrawal_id', 'bank_name', 'account_type', 'bank_account_number'];

    public function customerWithdrawal()
    {
        return $this->belongsTo(CustomerWithdrawal::class);
    }
}
