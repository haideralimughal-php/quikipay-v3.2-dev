<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\BankInfo;

class AccountController extends Controller
{

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
        $this->user = auth()->user();
    }

    public function index()
    {
        $user = auth()->user();
        return view('show', compact('user'));
    }

    public function update()
    {
        $attributes = request()->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            // 'bank_name' => ['required'],
            // 'bank_account' => ['required'],
            // 'rut' => ['required'],
        ]);

        if(request()->hasFile('logo')){
            request()->validate([
                'logo' => 'file|image|max:5000'
            ]);

            $attributes = $attributes + ['logo' => request()->logo->store('uploads', 'public')];
        }

        $user = auth()->user();

        $user->fill($attributes);
        $user->save();

        return redirect('/settings/profile');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('edit', compact('user'));
    }

    public function security()
    {
        return view('security');
    }
    
    public function updateSecurity()
    {
        $user = auth()->user();
        if(!(Hash::check(request('currentPassword'), $user->password))){
            return back()->with('error', 'Your current password is incorrect!!');
        }

        if(strcmp(request('currentPassword'), request('newPassword')) == 0){
            return back()->with('error', "New password cannot be same as old password!!");
        }

        request()->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|string|min:8|same:confirmPassword'
        ]);

        $user->password = Hash::make(request('newPassword'));
        $user->save();

        return back()->with('success', 'Password changed successfully!!');
    }
    
    public function bankInfo()
    {
        return view('bank-info');
    }
    
    public function storeBankInfo()
    {
        $bank_info = auth()->user()->addBankInfo(request()->all());
        return back()->with(['bank_info' => $bank_info->toArray()]);
    }
    
    public function apikey()
    {
        $user = auth()->user();
        $apikey = $user->merchant_id;
        return view('apikey', compact('apikey'));
    }
}

