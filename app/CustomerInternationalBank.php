<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInternationalBank extends Model
{
    protected $fillable = ['customer_withdrawal_id', 'bank_name', 'address', 'city', 'country', 'iban', 'swift_code', 'account_title', 'account_number'];

    public function customerWithdrawal()
    {
        return $this->belongsTo(CustomerWithdrawal::class);
    }
}
