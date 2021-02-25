<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\User;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
      public function index()
    {
        // auth()->user()->can('isAdmin') ? round(App\Wallet::sum('usd')) : round(auth()->user()->wallet->usd);
        if(auth()->user()->can('isAdmin'))
        $where='';
        else
        $where="where  user_id='".auth()->user()->id."'";
       
       $areachart = DB::select("select year(created_at) as year, month(created_at) as month, count(id) as total from users where id<>'1' group by year(created_at), month(created_at)");
       
        $linechart = DB::select("select year(created_at) as year, month(created_at) as month, day(created_at) as day, count(id) as total from payments group by year(created_at), month(created_at), day(created_at)");
        
        $barchart = DB::select("select year(created_at) as year, month(created_at) as month, day(created_at) as day, count(id) as total  from transactions $where group by year(created_at), month(created_at), day(created_at)");
        
          
        $lang = auth()->user()->lang;
       session(['applocale' => $lang]);
        App::setLocale($lang);
        App::getLocale();
        
        return view('home',compact('areachart','linechart','barchart'));
    }
    
}
