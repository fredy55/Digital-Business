<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Offices;
use App\Models\Admins;
use App\Models\UserRoles;
use App\Models\TotalTansact;
use App\Models\Transactions;
use App\Models\CreditTansact;
use App\Models\DebitTansact;

class AdminController extends Controller
{
    public $data = [];

    public function __construct()
    {
        // $this->middleware('auth:admin', ['except' => ['logout']]);
        $this->middleware('auth:admin');
    }
    
    public function dashboard()
    {   $data = [];
        $officeId = Auth::user()->office_id;
        
        //Activity count and latest transactions
        if(Auth::user()->level == 1){
            $data['transactions'] = Transactions::where('IsActive', 1)->count();
            $data['users'] = Admins::where('IsActive', 1)->count();
            $data['offices'] = Offices::where('IsActive', 1)->count();

            $data['latestTransact'] = DebitTansact::where('admin_transctions_debit.IsActive', 1)
                                                    ->orderBy('admin_transctions_debit.date_created', 'desc')
                                                    ->limit(5)
                                                    ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_debit.office_id')
                                                    ->select('admin_transctions_debit.*','admin_offices.office_name')
                                                    ->get();
        }elseif(Auth::user()->level == 3){
            $data['transactions'] = Transactions::where(['office_id'=>$officeId, 'IsActive'=>1])->count(); 
            $data['users'] = Admins::where(['office_id'=>$officeId, 'IsActive'=>1])->count(); 
            $data['offices'] = Offices::where(['office_id'=>$officeId, 'IsActive'=>1])->count();
            $data['latestTransact'] = DebitTansact::where(['admin_transctions_debit.office_id'=>$officeId, 'admin_transctions_debit.user_id'=>Auth::user()->user_id, 'admin_transctions_debit.IsActive'=>1])
                                                    ->orderBy('admin_transctions_debit.date_created', 'desc')
                                                    ->limit(5)
                                                    ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_debit.office_id')
                                                    ->select('admin_transctions_debit.*','admin_offices.office_name')
                                                    ->get();
        }else{
           $data['transactions'] = Transactions::where(['office_id'=>$officeId, 'IsActive'=>1])->count(); 
           $data['users'] = Admins::where(['office_id'=>$officeId, 'IsActive'=>1])->count(); 
           $data['offices'] = Offices::where(['office_id'=>$officeId, 'IsActive'=>1])->count(); 

           $data['latestTransact'] = DebitTansact::where(['admin_transctions_debit.office_id'=>$officeId, 'admin_transctions_debit.IsActive'=>1])
                                                   ->orderBy('admin_transctions_debit.date_created', 'desc')
                                                   ->limit(5)
                                                   ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_debit.office_id')
                                                   ->select('admin_transctions_debit.*','admin_offices.office_name')
                                                   ->get();
        }

        
        

        return view('admin.dashboard',$data);
    }

}
