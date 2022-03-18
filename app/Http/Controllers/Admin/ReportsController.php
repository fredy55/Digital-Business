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
use App\Models\DailyCashiers;
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
        $nowDate = Carbon::parse($request->post('tdate'))->format('d/m/Y');

        //Fetch report
        $repdata = $this->viewReport($officeId, $nowDate);
        if($repdata!=null){
            $data = $repdata;
            return view('admin.reports.reportdetails', $data);
        }else{
            return redirect()->route('admin.reports.find')->with('warning','No Transaction Found!'); 
        }
    }

    public function dailyReport2($officeId, $nowDate){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);
        
        
        //Fetch report
        $date = str_replace('-', '/', $nowDate);
        $repdata = $this->viewReport($officeId, $date);
        if($repdata!=null){
            $data = $repdata;
            return view('admin.reports.reportdetails', $data);
        }else{
            return redirect()->route('admin.reports.find')->with('warning','No Transaction Found!'); 
        }
    }

    public function viewReport($officeId, $nowDate){
        $date = $nowDate;
        $data['linkDate'] = str_replace('/', '-', $nowDate);
        
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
            return null;
        }

        //Find daily cashiers
        $cashierIds = findCashierIDs($officeId, $date);

        if(count($cashierIds)==0 || $cashierIds == null){
            return null; 
        }

        $data['transToday'] = [];
        $data['salesTot'] = 0;

        for($i = 0; $i<count($cashierIds); ++$i){
            $findCashier = Admins::where(['office_id'=>$cashierIds[$i]->office_id, 'level'=>3, 'user_id'=>$cashierIds[$i]->user_id])->first();
            
            if($findCashier != null){
                $data['transToday'][$i]['funding'] = CreditTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account,'type'=>'funded', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['drop_money'] = CreditTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account, 'type'=>'drop_money', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['top_ups'] = CreditTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account, 'type'=>'top_ups', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['collected'] = DebitTansact::where(['benefitiary'=>$cashierIds[$i]->account,'type'=>'collected', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['closing'] = DebitTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account, 'type'=>'closing', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['sales'] = ($data['transToday'][$i]['funding']+$data['transToday'][$i]['drop_money']+$data['transToday'][$i]['top_ups']) - ($data['transToday'][$i]['closing']+$data['transToday'][$i]['collected']);
                $data['salesTot'] += $data['transToday'][$i]['sales'];
                $data['transToday'][$i]['fullname'] = $findCashier->ftname.' '.$findCashier->ltname;
                $data['transToday'][$i]['account'] = $cashierIds[$i]->account;
                $data['transToday'][$i]['role'] = UserRoles::where('id', $findCashier->role_id)->first()->role_name;
                $data['transToday'][$i]['reportStatus'] = verifyCashierSales($officeId, $cashierIds[$i]->user_id, $cashierIds[$i]->account, $date);
            }else{
                return null; 
            }
        } 

        //dd($data['salesTot']);

        //Get cash at hand
        if($details->old_sales==null){
            $data['oldSales'] = TotalTansact::where(['office_id'=> $officeId])->first('cash_at_hand')->cash_at_hand;
        }else{
            $data['oldSales'] = $details->old_sales;
        }
        
        //dd($data['oldSales']);
        
        //Total sales for today
        $creditTot = $data['salesTot']+$details->funded+$details->drop_money+$details->top_ups+$details->pos_commission+$details->btransfer_commission+$details->deposit_commission+$details->deposit;
        $debitTot = $details->collected+$details->expenses+$details->winnings_paid+$details->bank_transfers+$details->pos;
        $data['totSales'] = $creditTot - $debitTot;
        $data['cashAtHand'] = $data['totSales'] + $data['oldSales'];

         //dd($data['totSales']);
        
        return $data;
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
        $nowDate = Carbon::parse($request->post('tdate'))->format('d/m/Y');
        
        $repdata = $this->viewCReport($officeId, $nowDate);
        if($repdata!=null){
            $data = $repdata;
            return view('admin.reports.creportdetails', $data);
        }else{
            return redirect()->route('admin.creports.find')->with('warning','No Transaction Found!'); 
        }
    }

    public function cdailyReport2($officeId, $nowDate){
        //Set session to collapse Reports tab
        session(['tab'=>'reports']);
        
        $date = str_replace('-', '/', $nowDate);

        $repdata = $this->viewCReport($officeId, $date);
        if($repdata!=null){
            $data = $repdata;
            return view('admin.reports.creportdetails', $data);
        }else{
            return redirect()->route('admin.creports.find')->with('warning','No Transaction Found!'); 
        }
    }

    public function viewCReport($officeId, $nowDate){
        
        $userId = Auth::user()->user_id;
        $date = $nowDate;
        $data['linkDate'] = str_replace('/', '-', $nowDate);
        $data['reportDate'] = $date;
        $data['reportOffice'] = findOffice($officeId);
        
        //Find daily cashiers
        $cashierIds = findSingleCashierID($officeId, $userId, $date);
        
        if(count($cashierIds)==0 || $cashierIds == null){
             return null;
        }
        
        //Daily Transaction
        $data['transToday'] = [];
        
        for($i = 0; $i<count($cashierIds); ++$i){
            $findCashier = Admins::where(['office_id'=>$cashierIds[$i]->office_id, 'level'=>3, 'user_id'=>$cashierIds[$i]->user_id])->first();
            
            
            if($findCashier != null){
                $data['transToday'][$i]['funding'] = CreditTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account,'type'=>'funded', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['drop_money'] = CreditTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account, 'type'=>'drop_money', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['top_ups'] = CreditTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account, 'type'=>'top_ups', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['collected'] = DebitTansact::where(['benefitiary'=>$cashierIds[$i]->account,'type'=>'collected', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['closing'] = DebitTansact::where(['user_id'=>$cashierIds[$i]->user_id, 'benefitiary'=>$cashierIds[$i]->account, 'type'=>'closing', 'date_created'=>$date])->sum('amount');
                $data['transToday'][$i]['sales'] = ($data['transToday'][$i]['funding']+$data['transToday'][$i]['drop_money']+$data['transToday'][$i]['top_ups']) - ($data['transToday'][$i]['closing']+$data['transToday'][$i]['collected']);
                $data['transToday'][$i]['fullname'] = $findCashier->ftname.' '.$findCashier->ltname;
                $data['transToday'][$i]['account'] = $cashierIds[$i]->account;
                $data['transToday'][$i]['role'] = UserRoles::where('id', $findCashier->role_id)->first()->role_name;
                $data['transToday'][$i]['reportStatus'] = verifyCashierSales($officeId, $cashierIds[$i]->user_id, $cashierIds[$i]->account, $date);
            }else{
                return null; 
            }
        }   

        //dd($data['transToday']);
        return $data;
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
        // $data['details'] = Transactions::where(['admin_transctions_main.IsActive'=>1, 'admin_transctions_main.office_id'=>$officeId])
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

        //Find report office
        $data['reptoffice'] = findOffice($officeId);

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
        $date = $request->post('dated');
        $linkDate = str_replace('/', '-', $date);

        //dd($linkDate);
        

        $transaction = new CreditTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = $officeId;
        $transaction->user_id = $userId;
        $transaction->amount = $request->post('sales');
        $transaction->benefitiary = $request->post('account');
        $transaction->type = 'sales';
        $transaction->description = 'Cashier daily sales report';
        $transaction->IsActive = 0;
        $transaction->date_created = $date;
        $transaction->timestamps = false;

        //Check transaction for today
        $salExist = CreditTansact::where([
                                    'user_id'=>$userId, 
                                    'office_id'=>$officeId, 
                                    'benefitiary'=>$request->post('account'), 
                                    'date_created'=>$date, 
                                    'type'=>'sales'])->doesntExist();
        
        if($salExist){
            if($transaction->save()){
                return redirect()->route('admin.creports.details2', ['officeid'=>$officeId, 'date'=>$linkDate])->with('info','Transaction report submitted successfully!');
            }else{
                return redirect()->route('admin.creports.details2', ['officeid'=>$officeId, 'date'=>$linkDate])->with('warning','Transaction report NOT submitted!');
            }
        }else{
            return redirect()->route('admin.creports.details2', ['officeid'=>$officeId, 'date'=>$linkDate])->with('warning','Report already submitted for today!');
        }  
    }

    public function withdrawCReport($account, $date){
        //Withdraw transaction details
        $transactionId = serialNum();
        $officeId = Auth::user()->office_id;
        $userId = Auth::user()->user_id;
        $realDate = Carbon::parse($date)->format('d/m/Y');

        //dd($realDate);

        //Check transaction for today
        $reportQuery = CreditTansact::where([
                                        'user_id'=>$userId, 
                                        'office_id'=>$officeId, 
                                        'benefitiary'=>$account, 
                                        'date_created'=>$realDate, 
                                        'type'=>'sales'
                                        ]);
        
        if($reportQuery->exists()){
            $report = $reportQuery->first();

            if($report->delete()){
                return redirect()->route('admin.creports.details2', ['officeid'=>$officeId, 'date'=>$date])->with('info','Transaction report withdrawn successfully!');
            }else{
                return redirect()->route('admin.creports.details2', ['officeid'=>$officeId, 'date'=>$date])->with('warning','Transaction report NOT withdrawn!');
            }
        }else{
            return redirect()->route('admin.creports.details2', ['officeid'=>$officeId, 'date'=>$date])->with('warning','Report does NOT exist!');
        }  
    }

    public function actionMCReport($account, $date, $action){
        //Withdraw transaction details
        $transactionId = serialNum();
        $officeId = Auth::user()->office_id;
        $realDate = Carbon::parse($date)->format('d/m/Y');

        //dd($realDate);

        //Check transaction for today
        $reportQuery = CreditTansact::where([
                                        'office_id'=>$officeId, 
                                        'benefitiary'=>$account, 
                                        'date_created'=>$realDate, 
                                        'type'=>'sales'
                                        ]);
        
        if($reportQuery->exists()){
            $report = $reportQuery->first();

            if($action=='Approve'){
               $report->IsActive = 1;
               $report->timestamps = false;
            }

            $procesReport = $action=='Approve'? $report->save() : $report->delete();

            if($procesReport){
                return redirect()->route('admin.reports.details2', ['officeid'=>$officeId, 'date'=>$date])->with('info','Transaction report '.strtolower($action).' successfully!');
            }else{
                return redirect()->route('admin.reports.details2', ['officeid'=>$officeId, 'date'=>$date])->with('warning','Transaction report NOT '.strtolower($action).'!');
            }
        }else{
            return redirect()->route('admin.reports.details2', ['officeid'=>$officeId, 'date'=>$date])->with('warning','Report does NOT exist!');
        }  
    }

    public function submitMReport(Request $request){
         //Validate form data
         $this->validate($request,[
            'salesdate'=>'required|string',
            'handcash'=>'required|string',
            'salestot'=>'required|string',
            'oldsales'=>'required|string'
        ]);

        //Save transaction details
        $officeId = Auth::user()->office_id;
        $linkDate = str_replace('/', '-', $request->post('salesdate'));

        //Update main office account
        $transacTot = TotalTansact::where('office_id', $officeId)->first();
        $transacTot->sales = $request->post('salestot');
        $transacTot->cash_at_hand = $request->post('handcash');
        $transacTot->timestamps = false;

        //Update office daily transaction account
        $transaction = Transactions::where(['office_id'=>$officeId, 'date_created'=>$request->post('salesdate')])->first();
        //dd($transaction);
        $transaction->sales = $request->post('salestot');
        $transaction->old_sales = $request->post('oldsales');
        $transaction->IsActive = 1;
        $transaction->timestamps = false;
        
        if($transaction->save() && $transacTot->save()){
            return redirect()->route('admin.reports.details2', ['officeid'=>$officeId, 'date'=>$linkDate])->with('info','Transaction report submitted successfully!');
        }else{
            return redirect()->route('admin.reports.details2', ['officeid'=>$officeId, 'date'=>$linkDate])->with('warning','Transaction report NOT submitted!');
        }
        
    }
}
