<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\NewUser;
use Illuminate\Support\Facades\Mail;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'company_name' => $data['company_name'],
            'password' => Hash::make($data['password']),
        ]);
        
        
        
         $fees_chile = DB::table('fees_chile')->updateOrInsert(
              
              ['user_id' => $user->id],
              
              [
              'bacs' => '3.5',
              'pago' => '5',
              'debit_credit' => '4.5',
              'crypto' => '3',
              'hites' => '4.8',
              'conversion' => '1',
              ]
              
            );
              
        $fees_ars = DB::table('fees_ars')->updateOrInsert(
              
              ['user_id' => $user->id],
              
              [
              'bacs' => '3.5',
              'pago' => '5',
              'debit_credit' => '7.5',
              'crypto' => '3',
              'hites' => 'Soon',
              'conversion' => '1',
              ]
              
             );
             
        $fees_peru = DB::table('fees_peru')->updateOrInsert(
              
              ['user_id' => $user->id],
              
              [
              'bacs' => '3.5',
              'pago' => 'Soon',
              'debit_credit' => '7.5',
              'crypto' => '3',
              'hites' => 'Soon',
              'conversion' => '1',
              ]
              
             );
                
                
        $fees_panama = DB::table('fees_panama')->updateOrInsert(
              
              ['user_id' => $user->id],
              
              [
              'bacs' => 'Soon',
              'pago' => 'Soon',
              'debit_credit' => '7.5',
              'crypto' => '3',
              'hites' => 'Soon',
              'conversion' => '1',
              ]
              
             );
               
        $fees_venz = DB::table('fees_venz')->updateOrInsert(
              
               ['user_id' => $user->id],
              
              [
              'bacs' => '3.5',
              'pago' => 'Soon',
              'debit_credit' => '7.5',
              'crypto' => '3',
              'hites' => 'Soon',
              'conversion' => '1',
              ]
              
             );
             
        $fees_other = DB::table('fees_other')->updateOrInsert(
              
               ['user_id' => $user->id],
              
              [
              'bacs' => 'Soon',
              'pago' => 'Soon',
              'debit_credit' => '7.5',
              'crypto' => '3',
              'hites' => 'Soon',
              'conversion' => '1',
              ]
              
             );
             
             
             
        
        Mail::to($user->email)->queue( new NewUser() );
        
        return $user;
    }
}
