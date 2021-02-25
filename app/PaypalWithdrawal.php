<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalWithdrawal extends Model
{
    protected $fillable = ['withdrawal_id', 'email'];

    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
