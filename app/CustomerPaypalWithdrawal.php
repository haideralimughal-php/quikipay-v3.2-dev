<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPaypalWithdrawal extends Model
{
    protected $fillable = ['customer_withdrawal_id', 'email'];

    public function customerWithdrawal()
    {
        return $this->belongsTo(CustomerWithdrawal::class);
    }
}
