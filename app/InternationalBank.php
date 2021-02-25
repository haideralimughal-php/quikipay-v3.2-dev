<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternationalBank extends Model
{
    protected $fillable = ['withdrawal_id', 'bank_name', 'address', 'city', 'country', 'iban', 'swift_code', 'account_title', 'account_number'];
    
    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
