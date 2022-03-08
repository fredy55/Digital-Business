<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Offices;
use App\Models\Admins;
use App\Models\UserRoles;
use App\Models\TotalTansact;
use App\Models\Transactions;
use App\Models\CreditTansact;
use App\Models\DebitTansact;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function reportList(){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);

        $userLevel = Admins::where('user_id', Auth::user()->user_id)->first();
        
        $transactQuery = Transactions::leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                    ->select(
                                        'admin_transctions_main.*',
                                        'admin_offices.office_name',
                                    );

        if($userLevel->level != 1){
            $transacts = $transactQuery->where('admin_transctions_main.office_id', Auth::user()->office_id)->get();
        }

        $transacts = $transactQuery->get();

        return view('admin.reports.reportlist',['transacts'=>$transacts]);
    }

    public function reportForm(){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);

        $data['offices'] = Offices::where('IsActive', 1)->get(['office_id','office_name']);
        $data['office'] = Offices::where(['office_id'=>Auth::user()->office_id, 'IsActive'=>1])->first(['office_id','office_name']);
        $data['userLevel'] = Admins::where('user_id', Auth::user()->user_id)->first();
        
        return view('admin.reports.reportform', $data);
    }

    public function dailyReport(Request $request){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);
        
        $officeId = $request->post('toffice');
        $date = Carbon::parse($request->post('tdate'))->format('d/m/Y');

        //Daily Transaction
        $data['details'] = Transactions::where([
                                    'admin_transctions_main.office_id'=>$officeId,
                                    'admin_transctions_main.date_created'=>$date
                                ])->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                ->select(
                                    'admin_transctions_main.*',
                                    'admin_offices.office_name',
                                )->first();
         //dd($details);
        if($data['details']==null){
            return back()->with('warning','No Transaction Found!'); 
        }

        $findCashier = Admins::where(['office_id'=>$officeId, 'level'=>3])->get();
        
        $data['transToday'] = [];
        
        for($i = 0; $i<count($findCashier); ++$i){
            $credQuery = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'benefitiary'=>$findCashier[$i]->credit_account, 'date_created'=>$date]);
            $data['transToday'][$i]['funding'] = $credQuery->where('type','funded')->sum('amount');
            $data['transToday'][$i]['drop_money'] = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'benefitiary'=>$findCashier[$i]->credit_account, 'type'=>'drop_money'])->sum('amount');
            $data['transToday'][$i]['top_ups'] = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'benefitiary'=>$findCashier[$i]->credit_account, 'type'=>'top_ups'])->sum('amount');
            $data['transToday'][$i]['closing'] = DebitTansact::where(['user_id'=>$findCashier[$i]->user_id, 'benefitiary'=>$findCashier[$i]->credit_account, 'type'=>'closing'])->sum('amount');
            $data['transToday'][$i]['sales'] = ($data['transToday'][$i]['funding']+$data['transToday'][$i]['drop_money']+$data['transToday'][$i]['top_ups']) - $data['transToday'][$i]['closing'];
            $data['transToday'][$i]['fullname'] = $findCashier[$i]->ftname.' '.$findCashier[$i]->ltname;
            $data['transToday'][$i]['account'] = $findCashier[$i]->credit_account;
            $data['transToday'][$i]['role'] = UserRoles::where('id', $findCashier[$i]->role_id)->first()->role_name;
        }

       //dd($transdate);
        
        return view('admin.reports.reportdetails', $data);
    }

    public function creportForm(){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);

        $data['offices'] = Offices::where('IsActive', 1)->get(['office_id','office_name']);
        $data['office'] = Offices::where(['office_id'=>Auth::user()->office_id, 'IsActive'=>1])->first(['office_id','office_name']);
        $data['userLevel'] = Admins::where('user_id', Auth::user()->user_id)->first();
        
        return view('admin.reports.creportform', $data);
    }

    public function cdailyReport(Request $request){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);
        
        $officeId = $request->post('toffice');
        $date = Carbon::parse($request->post('tdate'))->format('d/m/Y');

        //Daily Transaction
        $data['details'] = Transactions::where([
                                    'admin_transctions_main.office_id'=>$officeId,
                                    'admin_transctions_main.date_created'=>$date
                                ])->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                ->select(
                                    'admin_transctions_main.*',
                                    'admin_offices.office_name',
                                )->first();
         //dd($details);
        if($data['details']==null){
            return back()->with('warning','No Transaction Found!'); 
        }

        $findCashier = Admins::where(['office_id'=>$officeId, 'level'=>3, 'user_id'=>Auth::user()->user_id])->first();
        
        $data['transToday'] = [];
        //dd($date);

        $data['transToday']['funding'] = CreditTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date,'type'=>'funded'])->sum('amount');
        $data['transToday']['drop_money'] = CreditTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date, 'type'=>'drop_money'])->sum('amount');
        $data['transToday']['top_ups'] = CreditTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date, 'type'=>'top_ups'])->sum('amount');
        $data['transToday']['collected'] = DebitTansact::where(['benefitiary'=>$findCashier->credit_account, 'date_created'=>$date,'type'=>'collected'])->sum('amount');
        $data['transToday']['closing'] = DebitTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date, 'type'=>'closing'])->sum('amount');
        $data['transToday']['sales'] = ($data['transToday']['funding']+$data['transToday']['drop_money']+$data['transToday']['top_ups']) - ($data['transToday']['closing']+$data['transToday']['collected']);
        $data['transToday']['fullname'] = $findCashier->ftname.' '.$findCashier->ltname;
        $data['transToday']['account'] = $findCashier->credit_account;
        $data['transToday']['role'] = UserRoles::where('id', $findCashier->role_id)->first()->role_name;
        

       
        
        return view('admin.reports.creportdetails', $data);
    }

}
