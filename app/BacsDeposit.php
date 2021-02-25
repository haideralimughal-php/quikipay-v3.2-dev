<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BacsDeposit extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
