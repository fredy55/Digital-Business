<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Offices;
use App\Models\Admins;
use App\Models\TotalTansact;
use App\Models\Transactions;
use App\Models\CreditTansact;
use App\Models\DebitTansact;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function credits()
    {
        //Fetch all admins
        $credits = CreditTansact::whereIn('admin_transctions_credit.IsActive', [0,1])
                                ->where('admin_transctions_credit.user_id', Auth::user()->user_id)
                                ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_credit.office_id')
                                ->select('admin_transctions_credit.*','admin_offices.office_name')
                                ->get();

        //Find the current user credit account
        $uesrAccount = Admins::where('user_id', Auth::user()->user_id)->value('credit_account');
       
        
        return view('admin.transactions.credits', ['credits'=>$credits, 'uesrAccount'=>$uesrAccount ]);
    }

    public function debits()
    {
        //Fetch all admins
        $debits = DebitTansact::whereIn('admin_transctions_debit.IsActive', [0,1])
                                ->where('admin_transctions_debit.user_id', Auth::user()->user_id)
                                ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_debit.office_id')
                                ->select('admin_transctions_debit.*','admin_offices.office_name')
                                ->get();

        //Find the current user credit account
        $uesrAccount = Admins::where('user_id', Auth::user()->user_id)->value('credit_account');
       
        
        return view('admin.transactions.debits', ['debits'=>$debits, 'uesrAccount'=>$uesrAccount ]);
    }

    public function show($type, $transaction_id)
    {
        //var_dump($type.' - '.$transaction_id); exit();
        //Fetch tansactions
        $details=[];

        if($type=='credit'){
            $details = CreditTansact::where('admin_transctions_credit.transaction_id', $transaction_id)
                                    ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_credit.office_id')
                                    ->leftJoin('admins', 'admins.user_id', '=', 'admin_transctions_credit.user_id')
                                    ->leftJoin('admin_roles', 'admin_roles.id', '=', 'admins.role_id')
                                    ->select(
                                        'admin_transctions_credit.*',
                                        'admin_offices.office_name',
                                        'admins.ftname',
                                        'admins.ltname',
                                        'admin_roles.role_name',
                                        'admin_roles.id as roleId'
                                        )
                                    ->first();
        }elseif($type=='debit'){
            $details = DebitTansact::where('admin_transctions_debit.transaction_id', $transaction_id)
                                    ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_debit.office_id')
                                    ->leftJoin('admins', 'admins.user_id', '=', 'admin_transctions_debit.user_id')
                                    ->leftJoin('admin_roles', 'admin_roles.id', '=', 'admins.role_id')
                                    ->select(
                                        'admin_transctions_debit.*',
                                        'admin_offices.office_name',
                                        'admins.ftname',
                                        'admins.ltname',
                                        'admin_roles.role_name',
                                        'admin_roles.id as roleId'
                                        )
                                    ->first();
        }
        
        //var_dump($details); exit();
       
        return view('admin.transactions.details', ['details'=>$details, 'type'=>$type]);
    }

    //Save Transactions
    public function saveCredit(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'account'=>'required|string',
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

        //Save transaction details
        $transactionId = serialNum();
        $officeId = Auth::user()->office_id;
        $typeField = $request->post('type');
        $transAmt = $request->post('amount');

        $transaction = new CreditTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = $officeId;
        $transaction->user_id = Auth::user()->user_id;
        $transaction->benefitiary = $request->post('account');
        $transaction->amount = $transAmt;
        $transaction->type = $typeField;
        $transaction->description = $request->post('description');
        $transaction->IsActive = 1;

        //Check transaction totals for today
        $existQuery = Transactions::where(['date_created'=>date('d/m/Y'), 'office_id'=>$officeId]);
        $totalsExist = $existQuery->exists();
        
        
        //Save transaction totals
        
        if($totalsExist){
           //update the daily transaction
           $transactot = $existQuery->first();
           $transactot->timestamps = false;
           $this->getFieldType($transactot, $typeField, $transAmt);

            //dd($totalsExist);
            $transactot->save();
        }else{
            $transactId = idGenerate();
            $transactot = new Transactions;
            $transactot->office_id  = $officeId;
            $transactot->transaction_id = $transactId;
            $transactot->date_created = date('d/m/Y');
            $transactot->timestamps = false;
            $this->getFieldType($transactot, $typeField, $transAmt);

            //dd($totalsExist);
            $transactot->save();
        }

        if($transaction->save()){
            return redirect()->route('admin.transacts.credits')->with('info','Transaction saved successfully!');
        }else{
            return back()->with('warning','Transaction NOT saved!');
        } 
        
    }

    public function saveDebit(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'account'=>'required|string',
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

       //Save transaction details
       $transactionId = serialNum();
       $officeId = Auth::user()->office_id;
       $typeField = $request->post('type');
       $transAmt = $request->post('amount');

        $transaction = new DebitTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = Auth::user()->office_id;
        $transaction->user_id = Auth::user()->user_id;
        $transaction->benefitiary = $request->post('account');
        $transaction->amount = $request->post('amount');
        $transaction->type = $request->post('type');
        $transaction->description = $request->post('description');
        $transaction->IsActive = 1;

        //Check transaction totals for today
        $existQuery = Transactions::where(['date_created'=>date('d/m/Y'), 'office_id'=>$officeId]);
        $totalsExist = $existQuery->exists();
        
        
        //Save transaction totals
        
        if($totalsExist){
           //update the daily transaction
           $transactot = $existQuery->first();
           $transactot->timestamps = false;
           $this->getFieldType($transactot, $typeField, $transAmt);

            //dd($totalsExist);
            $transactot->save();
        }else{
            $transactId = idGenerate();
            $transactot = new Transactions;
            $transactot->office_id  = $officeId;
            $transactot->transaction_id = $transactId;
            $transactot->date_created = date('d/m/Y');
            $transactot->timestamps = false;
            $this->getFieldType($transactot, $typeField, $transAmt);
            $transactot->save();
        }
        
        if($transaction->save()){
            return redirect()->route('admin.transacts.debits')->with('info','Transaction saved successfully!');
        }else{
            return back()->with('warning','Transaction NOT saved!');
        } 
        
    }
    
    public function summaryForm(){
        $data['offices'] = Offices::where('IsActive', 1)->get(['office_id','office_name']);
        $data['office'] = Offices::where(['office_id'=>Auth::user()->office_id, 'IsActive'=>1])->first(['office_id','office_name']);

        
        return view('admin.reports.reportform', $data);
    }

    public function dailySummary(Request $request){
        $officeId = $request->post('toffice');
        $date = Carbon::parse($request->post('tdate'))->format('d/m/Y');

        $details = Transactions::where([
                                    'admin_transctions_main.office_id'=>$officeId,
                                    'admin_transctions_main.date_created'=>$date
                                ])->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                ->select(
                                    'admin_transctions_main.*',
                                    'admin_offices.office_name',
                                )->first();
         //dd($details);
        if($details==null){
            return back()->with('warning','No Transaction Found!'); 
        }
        return view('admin.reports.reportdetails', ['details'=>$details]);
    }

    public function dailyList(){
        $transacts = Transactions::where('admin_transctions_main.office_id', Auth::user()->office_id)
                                ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_main.office_id')
                                ->select(
                                    'admin_transctions_main.*',
                                    'admin_offices.office_name',
                                )->get();

        return view('admin.reports.reportlist',['transacts'=>$transacts]);
    }


    public function update(Request $request)
    {
       //Validate form data
       $this->validate($request,[
            'from'=>'required|string',
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

        //Get admins ID
        $transactId = $request->post('transactId');

        //Check whether Office exist
        $exists=CreditTansact::where('transaction_id', $transactId)->exists();

        if($exists){
           //Save data
           $transaction = CreditTansact::where('transaction_id', $transactId)->first();
            $transaction->benefitiary = $request->post('from');
            $transaction->amount = $request->post('amount');
            $transaction->type = $request->post('type');
            $transaction->description = $request->post('description');
           
           if($transaction->save()){
               return back()->with('info','Transaction updated successfully!');
           }else{
              return back()->with('warning','Transaction Account NOT updated!');
           } 
        }else{
            return back()->with('warning','Transaction Account does NOT exist!'); 
        }
    }

    public function destroy($type, $transactId)
    {
        if($type=='credit'){
            $transactQuery = CreditTansact::where('transaction_id', $transactId);
        }elseif('debit'){
            $transactQuery = DebitTansact::where('transaction_id', $transactId);
        }

        //Find the single transaction to be deleted
        $transact = $transactQuery->first();
        $date_created = Carbon::parse($transact->created_at)->format('d/m/Y');

        $transactot = Transactions::where('date_created', $date_created)->first();

        //dd($transactot);
        $this->getFieldTypeDebit($transactot, $transact->type, $transact->amount);
        $transactot->timestamps = false;

        
        
        //Check whether User exist
        $exists = $transactQuery->exists();

        if($exists){
           if($transact->delete() && $transactot->save()){
               return redirect()->route('admin.transacts.credits')->with('info','Transaction deleted successfully!');
           }else{
            return back()->with('warning','Transaction Account NOT deleted!');
           } 
        }else{
            return back()->with('warning','Transaction does NOT exist!'); 
        }
    }

    public function getFieldType($transactot, $typeField, $transAmt){
        switch ($typeField) { 
            case 'funded':
                $transactot->funded = $transactot->funded+$transAmt;
                break;
            case 'drop_money':
                $transactot->drop_money = $transactot->drop_money+$transAmt;
                break;
            case 'sales':
                $transactot->sales = $transactot->sales+$transAmt;
                break; 
            case 'collected':
                $transactot->collected = $transactot->collected+$transAmt;
                break; 
            case 'winnings_paid':
                $transactot->winnings_paid = $transactot->winnings_paid+$transAmt;
                break;
            case 'pos':
                $transactot->pos = $transactot->pos+$transAmt;
                break; 
            case 'expenses':
                $transactot->expenses = $transactot->expenses+$transAmt;
                break;     
            case 'top_ups':
                $transactot->top_ups = $transactot->top_ups +$transAmt;
                break; 
            case 'bank_tranfers':
                $transactot->bank_tranfers = $transactot->bank_tranfers+$transAmt;
                break;     
            case 'closing':
                $transactot->closing =$transactot->closing +$transAmt;
                break; 
            case 'cash_at_hand':
                $transactot->cash_at_hand = $transactot->cash_at_hand+$transAmt;
                break; 
        }

        return $transactot;
    }

    public function getFieldTypeDebit($transactot, $typeField, $transAmt){
        switch ($typeField) { 
            case 'funded':
                $transactot->funded = $transactot->funded-$transAmt;
                break;
            case 'drop_money':
                $transactot->drop_money = $transactot->drop_money-$transAmt;
                break;
            case 'sales':
                $transactot->sales = $transactot->sales-$transAmt;
                break; 
            case 'collected':
                $transactot->collected = $transactot->collected-$transAmt;
                break; 
            case 'winnings_paid':
                $transactot->winnings_paid = $transactot->winnings_paid-$transAmt;
                break;
            case 'pos':
                $transactot->pos = $transactot->pos-$transAmt;
                break; 
            case 'expenses':
                $transactot->expenses = $transactot->expenses-$transAmt;
                break;     
            case 'top_ups':
                $transactot->top_ups = $transactot->top_ups-$transAmt;
                break; 
            case 'bank_tranfers':
                $transactot->bank_tranfers = $transactot->bank_tranfers-$transAmt;
                break;     
            case 'closing':
                $transactot->closing =$transactot->closing-$transAmt;
                break; 
            case 'cash_at_hand':
                $transactot->cash_at_hand = $transactot->cash_at_hand-$transAmt;
                break; 
        }

        return $transactot;
    }
}
