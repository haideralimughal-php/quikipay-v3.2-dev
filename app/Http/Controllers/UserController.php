<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
class UserController extends Controller
{
    public function index()
    {
        // $users = User::where('id', '!=', 1)->latest()->get();

            $users = DB::table('users')
            ->join('coin_settings', 'users.id', '=', 'coin_settings.user_id')
            ->select('users.*', 'coin_settings.order_limit','coin_settings.email_flag')
            ->where('users.id', '!=', 1)
            ->latest()
            ->get();
          //  dd($users);
        return view('admin.users.index', compact('users'));
    }
    
}
