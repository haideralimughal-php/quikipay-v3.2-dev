<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
// use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable implements MustVerifyEmail
{
    // use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customerWithdrawals()
    {
        return $this->hasMany(CustomerWithdrawal::class)->latest();
    }

    public function customerWallet()
    {
        return $this->hasOne(CustomerWallet::class);
    }

    public function addCustomerWallet($data)
    {
        return $this->customerWallet()->create($data);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function customerTransactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $wallet = array(
                'usd' => 0,
                'ars' => 0,
                'clp' => 0,
                'sol' => 0
            );

            $user->addCustomerWallet($wallet);
        });
    }

    public function kycVerification()
    {
        return $this->hasOne(Kyc::class);
    }
}
