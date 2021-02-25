<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerWithdrawal extends Model
{
    protected $fillable = ['customer_id', 'bank', 'currency', 'amount', 'status'];

    public function getBank()
    {
        if ($this->bank == 'local_bank')
            return $this->hasOne(CustomerLocalBank::class);
        else if ($this->bank == 'international_bank')
            return $this->hasOne(CustomerInternationalBank::class);
        else if ($this->bank == 'paypal')
            return $this->hasOne(CustomerPaypalWithdrawal::class);
        else if ($this->bank == 'crypto')
            return $this->hasOne(CustomerCryptoWithdrawal::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function addWithdrawal($attribs)
    {
        $newWithdrawal = $this->create($attribs);
        $newWithdrawal->getBank()->create($attribs);

        return $newWithdrawal;
    }
}
