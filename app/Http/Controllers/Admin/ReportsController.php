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
        $details = Transactions::where([
                                    'admin_transctions_main.office_id'=>$officeId,
                                    'admin_transctions_main.date_created'=>$date
                                ])->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                ->select(
                                    'admin_transctions_main.*',
                                    'admin_offices.office_name',
                                )->first();
        $data['details'] = $details;

         //dd($details);
        if($data['details']==null){
            return back()->with('warning','No Transaction Found!'); 
        }

        $findCashier = Admins::where(['office_id'=>$officeId, 'level'=>3])->get();
        
        $data['transToday'] = [];
        $data['salesTot'] = 0;
        
        for($i = 0; $i<count($findCashier); ++$i){
            $credQuery = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'benefitiary'=>$findCashier[$i]->credit_account, 'date_created'=>$date]);
            $data['transToday'][$i]['funding'] = $credQuery->where('type','funded')->sum('amount');
            $data['transToday'][$i]['drop_money'] = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'type'=>'drop_money', 'date_created'=>$date])->sum('amount');
            $data['transToday'][$i]['top_ups'] = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'type'=>'top_ups', 'date_created'=>$date])->sum('amount');
            $data['transToday'][$i]['sales'] = CreditTansact::where(['user_id'=>$findCashier[$i]->user_id, 'type'=>'sales', 'date_created'=> $date])->sum('amount');
            $data['salesTot'] += $data['transToday'][$i]['sales']; 
            $data['transToday'][$i]['hasSalesSubmit'] = verifyCashierSales($officeId, $findCashier[$i]->user_id, $date);
            $data['transToday'][$i]['collected'] = DebitTansact::where(['benefitiary'=>$findCashier[$i]->credit_account, 'type'=>'collected', 'date_created'=>$date])->sum('amount');
            $data['transToday'][$i]['closing'] = DebitTansact::where(['user_id'=>$findCashier[$i]->user_id, 'benefitiary'=>$findCashier[$i]->credit_account, 'type'=>'closing', 'date_created'=>$date])->sum('amount');
            $data['transToday'][$i]['fullname'] = $findCashier[$i]->ftname.' '.$findCashier[$i]->ltname;
            $data['transToday'][$i]['account'] = $findCashier[$i]->credit_account;
            $data['transToday'][$i]['role'] = UserRoles::where('id', $findCashier[$i]->role_id)->first()->role_name;
        }

        //Get cash at hand
        $data['oldSales'] = TotalTansact::where(['office_id'=> $officeId])->first('cash_at_hand');
        
        //Total sales for today
        $creditTot = $data['oldSales']->cash_at_hand+$details->funded+$details->drop_money+$details->top_ups+$details->pos_commission+$details->btransfer_commission+$details->deposit_commission+$details->deposit;
        $debitTot = $details->collected+$details->expenses+$details->winnings_paid+$details->bank_transfers+$details->pos;
        $data['cashAtHand'] = $creditTot - $debitTot;
        $data['totSales'] = $data['cashAtHand'] - $data['oldSales']->cash_at_hand;

       //dd($data['transToday']);
        
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
            return back()->with('warning','No Transaction Report Found!'); 
        }

        if(Auth::user()->level == 3){
            $findCashier = Admins::where(['office_id'=>$officeId, 'level'=>3, 'user_id'=>Auth::user()->user_id])->first();
        }else{
            return back()->with('warning','No Transaction Report Found!'); 
        }

        
        $data['transToday'] = [];
        //dd(verifyCashierSales($officeId, $findCashier->user_id, $date));

        $data['transToday']['funding'] = CreditTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date,'type'=>'funded'])->sum('amount');
        $data['transToday']['drop_money'] = CreditTansact::where(['user_id'=>$findCashier->user_id, 'type'=>'drop_money', 'date_created'=>$date])->sum('amount');
        $data['transToday']['top_ups'] = CreditTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date, 'type'=>'top_ups'])->sum('amount');
        $data['transToday']['collected'] = DebitTansact::where(['benefitiary'=>$findCashier->credit_account, 'date_created'=>$date,'type'=>'collected', 'date_created'=>$date])->sum('amount');
        $data['transToday']['closing'] = DebitTansact::where(['user_id'=>$findCashier->user_id, 'benefitiary'=>$findCashier->credit_account, 'date_created'=>$date, 'type'=>'closing'])->sum('amount');
        $data['transToday']['sales'] = ($data['transToday']['funding']+$data['transToday']['drop_money']+$data['transToday']['top_ups']) - ($data['transToday']['closing']+$data['transToday']['collected']);
        $data['transToday']['fullname'] = $findCashier->ftname.' '.$findCashier->ltname;
        $data['transToday']['account'] = $findCashier->credit_account;
        $data['transToday']['role'] = UserRoles::where('id', $findCashier->role_id)->first()->role_name;
        
        //Verify Cashier daily sales submission
        $data['transToday']['reportSubmit'] = verifyCashierSales($officeId, $findCashier->user_id, $date);


        

        return view('admin.reports.creportdetails', $data);
    }

    public function reportHistoryForm(){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);

        $data['offices'] = Offices::where('IsActive', 1)->get(['office_id','office_name']);
        $data['office'] = Offices::where(['office_id'=>Auth::user()->office_id, 'IsActive'=>1])->first(['office_id','office_name']);
        $data['userLevel'] = Admins::where('user_id', Auth::user()->user_id)->first();
        
        return view('admin.reports.hreportform', $data);
    }

    public function reportHistoryDetails(Request $request){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);
        
        $officeId = $request->post('toffice');
        $fdate = Carbon::parse($request->post('from-date'))->format('d/m/Y');
        $tdate = Carbon::parse($request->post('to-date'))->format('d/m/Y');

        //Daily Transaction
        $data['details'] = Transactions::where('admin_transctions_main.office_id', $officeId)
                                    ->whereBetween('admin_transctions_main.date_created', [$fdate, $tdate])
                                    ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                    ->select(
                                        'admin_transctions_main.*',
                                        'admin_offices.office_name',
                                    )->get();
         //dd($data['details']);

        if($data['details']==null){
            return back()->with('warning','No Transaction Report Found!'); 
        }

        return view('admin.reports.hreportdetails', $data);
    }
    
    public function submitCReport(Request $request){
        //Validate form data
        $this->validate($request,[
            'sales'=>'required|numeric'
        ]);

        //Save transaction details
        $transactionId = serialNum();
        $officeId = Auth::user()->office_id;
        $userId = Auth::user()->user_id;
        $date =  date('d/m/Y');
        

        $transaction = new CreditTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = $officeId;
        $transaction->user_id = $userId;
        $transaction->amount = $request->post('sales');
        $transaction->type = 'sales';
        $transaction->description = 'Cashier daily sales report';
        $transaction->IsActive = 1;
        $transaction->date_created = $date;
        $transaction->timestamps = false;

        //Check transaction for today
        if(!verifyCashierSales($officeId, $userId, $date)){
            if($transaction->save()){
                return redirect()->route('admin.creports.find')->with('info','Transaction report submitted successfully!');
            }else{
                return redirect()->route('admin.creports.find')->with('warning','Transaction report NOT submitted!');
            }
        }else{
            return back()->with('warning','Report already submitted for today!');
        }  
    }

    public function submitCMeport(Request $request){

    }
}
