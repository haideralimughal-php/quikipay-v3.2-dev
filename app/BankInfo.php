<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    protected $fillable = ['user_id', 'currency', 'account_name', 'account_type', 'account_number', 'iban', 'swift_code', 'rut', 'bank_name', 'minimum_payment', 'bank_address','DNI','email','CBU_CUV','CUIT','RUC','CCI'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
