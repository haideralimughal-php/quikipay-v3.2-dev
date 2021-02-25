<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kyc;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Helper\Helper;
use DB;
class KycVerificationController extends Controller
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

    public function index()
    {
        $verifications = null;
        if(auth()->user()->can('isAdmin')){
            $verifications = Kyc::latest()->get();
        }

        return view('kyc.index', compact('verifications'));
    }
    
    public function change_status(Kyc $kyc, $data){
        if(!empty($kyc) && !empty(@base64_decode($data))){
            $status = @base64_decode($data);
            $kyc->status = $status;
            $kyc->save();
            $success = 'Success! Status Updated Successfully!!';
            return Redirect()->back()->with('success' ,$success);
        }
        
        return Redirect()->back()->withErrors(['Error! Status not Update!!']);
    }
    
    
}
