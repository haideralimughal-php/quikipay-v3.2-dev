<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedBalance extends Model
{
    protected $guarded = [];
 
    public function from()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function to()
    {
        return $this->belongsTo(Customer::class, 'shared_to', 'id');
    }
}
