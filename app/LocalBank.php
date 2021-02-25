<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalBank extends Model
{
    protected $fillable = ['withdrawal_id', 'bank_name', 'account_type', 'bank_account_number','country'];
    
    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
