<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

class TransactionsController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function credits($typeField)
    {
        //Set session to collapse Transactions tab
        session(['tab'=>'transactions']);
        
        $data['transType'] = fieldTypeFormat($typeField);
        $data['typeField'] = $typeField;

        $userQuery = Admins::where('user_id', Auth::user()->user_id);
        $userLevel = $userQuery->first();

        //Fetch all admins
        $creditQuery = CreditTansact::whereIn('admin_transctions_credit.IsActive', [0,1])
                                ->where('admin_transctions_credit.type', $data['transType'])
                                ->orderBy('admin_transctions_credit.date_created', 'desc')
                                ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_credit.office_id')
                                ->select('admin_transctions_credit.*','admin_offices.office_name');

        if($userLevel->level == 1){
            $data['credits'] = $creditQuery->get();
        }else{
            $data['credits'] = $creditQuery->where('admin_transctions_credit.user_id', Auth::user()->user_id)->get();
        }

        //Find the current user credit account
        $data['uesrAccount'] = $userQuery->value('credit_account');
        $data['uesrLevel'] = $userLevel->level;
       
        
        return view('admin.transactions.credits', $data);
    }

    public function debits($typeField)
    {
        //Set session to collapse Transactions tab
        session(['tab'=>'transactions']);

        $data['transType'] = fieldTypeFormat($typeField);
        $data['typeField'] = $typeField;

        $userQuery = Admins::where('user_id', Auth::user()->user_id);
        $userLevel = $userQuery->first();
        
        //Fetch all admins
        $debitQuery = DebitTansact::whereIn('admin_transctions_debit.IsActive', [0,1])
                                ->where('admin_transctions_debit.type', $data['transType'])
                                ->orderBy('admin_transctions_debit.date_created', 'desc')
                                ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_debit.office_id')
                                ->select('admin_transctions_debit.*','admin_offices.office_name');

        if($userLevel->level == 1){
            $data['debits'] = $debitQuery->get();
        }else{
            $data['debits'] = $debitQuery->where('admin_transctions_debit.user_id', Auth::user()->user_id)->get();
        }

        //Find the current single cashier account
        $data['uesrAccount'] = $userQuery->value('credit_account');

        //Find the current Multiple cashier accounts
        $data['uesrAccOptions'] = Admins::where(['office_id'=>Auth::user()->office_id, 'level'=>3])->get('credit_account');

        $data['uesrLevel'] = $userLevel->level;
        
        return view('admin.transactions.debits', $data);
    }

    public function show($type, $transaction_id)
    {
        //Set session to collapse Transactions tab
        session(['tab'=>'transactions']);

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
        
        //dd($details->type);
       
        return view('admin.transactions.details', ['details'=>$details, 'type'=>$type]);
    }

    //Save Transactions
    public function saveCredit(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

        //Save transaction details
        $transactionId = serialNum();
        $officeId = Auth::user()->office_id;
        $userId = Auth::user()->user_id;
        $typeField = $request->post('type');
        $transAmt = $request->post('amount');
        $txDate = $request->post('transdate');
        $transdate = !empty($txDate) ? Carbon::parse($txDate)->format('d/m/Y') : date('d/m/Y');
        //dd($transdate);
        
        /*Check whether report has been summitted 
        for this transaction*/
        if(isSubmittedReport($officeId, $transdate)){
            return back()->with('warning','Transaction report is already submitted!'); 
        }

        $transaction = new CreditTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = $officeId;
        $transaction->user_id = $userId;
        if($typeField == 'top_ups' || $typeField == 'funded' || ($typeField == 'drop_money' && Auth::user()->level == 3)){
            $transaction->benefitiary = $request->post('account');

            //save the cashier uniquely for daily reporting
            saveCashier($officeId, $userId, $request->post('account'));
        }
        $transaction->amount = $transAmt;
        if($typeField == 'deposit'){
            $transaction->commission = $request->post('commission');
        }
        $transaction->type = $typeField;
        $transaction->description = $request->post('description');
        $transaction->IsActive = 1;
        $transaction->date_created = $transdate;
        $transaction->timestamps = false;

        //Check transaction totals for today
        $existQuery = Transactions::where(['date_created'=>$transdate, 'office_id'=>$officeId]);
        $totalsExist = $existQuery->exists();
        
        
        //Save transaction totals
        if(Auth::user()->level != 3 && $typeField != 'funded' && $typeField != 'top_ups'){
            if($totalsExist){
            //update the daily transaction
            $transactot = $existQuery->first();
            $transactot->timestamps = false;
            $this->getFieldType($transactot, $typeField, $transAmt);
            if($typeField == 'deposit'){
                    $this->getFieldType($transactot, 'deposit_commission', $request->post('commission'));
                }
                $transactot->save();
            }else{
                $transactId = idGenerate();
                $transactot = new Transactions;
                $transactot->office_id  = $officeId;
                $transactot->transaction_id = $transactId;
                $transactot->date_created = $transdate;
                $transactot->timestamps = false;
                if($typeField == 'deposit'){
                    $this->getFieldType($transactot, 'deposit_commission', $request->post('commission'));
                }
                $this->getFieldType($transactot, $typeField, $transAmt);

                $transactot->save();
            }
        }

        if($transaction->save()){
            return back()->with('info','Transaction saved successfully!');
        }else{
            return back()->with('warning','Transaction NOT saved!');
        } 
        
    }

    public function saveDebit(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            // 'account'=>'required|string',
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

       //Save transaction details
       $transactionId = serialNum();
       $officeId = Auth::user()->office_id;
       $userId = Auth::user()->user_id;
       $typeField = $request->post('type');
       $transAmt = $request->post('amount');
       $txDate = $request->post('transdate');
       $transdate = !empty($txDate) ? Carbon::parse($txDate)->format('d/m/Y') : date('d/m/Y');
       //dd($transdate);
       
       /*Check whether report has been summitted 
        for this transaction*/
        if(isSubmittedReport($officeId, $transdate)){
            return back()->with('warning','Transaction report is already submitted!'); 
        }

        $transaction = new DebitTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = Auth::user()->office_id;
        $transaction->user_id = $userId;

        if($typeField == 'sales' || $typeField == 'collected' || $typeField == 'closing'){
            $transaction->benefitiary = $request->post('account');
            
            //save the cashier uniquely for daily reporting
            saveCashier($officeId, $userId, $request->post('account'));
        }

        $transaction->amount = $transAmt;
        if($typeField == 'pos' || $typeField == 'bank_transfers'){
            $transaction->commission = $request->post('commission');
        }
        $transaction->type = $request->post('type');
        $transaction->description = $request->post('description');

        if($typeField == 'pos' || $typeField == 'winnings_paid'){
            //Get  file
            $evImage = getrans_img($request, 'evimage', $transactionId);
            $evidence = $evImage['img_url'];

            $evImage = getrans_img($request, 'evimage', $transactionId);
            
            if($evImage['img_size']>2097152){
                return back()->with('warning','Invalid transaction evidence!');
            }
            $evidence = $evImage['img_url'];
            $transaction->evidence_url = $evidence;
        }
        $transaction->IsActive = 1;
        $transaction->date_created = $transdate;
        $transaction->timestamps = false;

        //Check transaction totals for today
        $existQuery = Transactions::where(['date_created'=>$transdate, 'office_id'=>$officeId]);
        $totalsExist = $existQuery->exists();
        
        
        //Save transaction totals
        if(Auth::user()->level != 3 && $typeField != 'collected' && $typeField != 'closing'){
            if($totalsExist){
                //update the daily transaction
                $transactot = $existQuery->first();
                $transactot->timestamps = false;
                $this->getFieldType($transactot, $typeField, $transAmt);

                if($typeField == 'pos'){
                    $this->getFieldType($transactot, 'pos_commission', $request->post('commission'));
                }

                if($typeField == 'bank_transfers'){
                    $this->getFieldType($transactot, 'btransfer_commission', $request->post('commission'));
                }

                $transactot->save();
            }else{
                $transactId = idGenerate();
                $transactot = new Transactions;
                $transactot->office_id  = $officeId;
                $transactot->transaction_id = $transactId;
                $transactot->date_created = $transdate;
                $transactot->timestamps = false;
                $this->getFieldType($transactot, $typeField, $transAmt);

                if($typeField == 'pos'){
                    $this->getFieldType($transactot, 'pos_commission', $request->post('commission'));
                }

                if($typeField == 'bank_transfers'){
                    $this->getFieldType($transactot, 'btransfer_commission', $request->post('commission'));
                }

                $transactot->save();
            }
        }
        
        
        if($transaction->save()){
            return back()->with('info','Transaction saved successfully!');
        }else{
            return back()->with('warning','Transaction NOT saved!');
        } 
        
    }

    public function update(Request $request)
    {
       //Validate form data
       $this->validate($request,[
            // 'from'=>'required|string',
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

        //Get admins ID
        $transactId = $request->post('transactId');
        $transtype = $request->post('transtype');
        $type = $request->post('type');
        $newAmt = $request->post('amount');

        if($transtype=='credit'){
            $transactQuery = CreditTansact::where('transaction_id', $transactId);
        }elseif($transtype=='debit'){
            $transactQuery = DebitTansact::where('transaction_id', $transactId);
        }

        //Check whether Office exist
        $exists=$transactQuery->exists();

        if($exists){
            //Find the single transaction to be updated
            $transact = $transactQuery->first();

            /*Check whether report has been summitted 
            for this transaction*/
            if(isSubmittedReport($transact->office_id, $transact->date_created)){
                return back()->with('warning','Transaction report is already submitted!'); 
            }

            if($type!='collected' && $type!='top_ups' && $type!='funded' && $type!='closing'){
                $transactot = Transactions::where(['date_created'=>$transact->date_created, 'office_id'=>$transact->office_id])->first();
    
                $this->getUpdateFieldType($transactot, $transact->type, $transact->amount, $newAmt);
                
                switch($transact->type){
                    case 'pos':
                        $this->getUpdateFieldType($transactot, 'pos_commission', $transact->commission, $newAmt);
                        break;
                    case 'deposit':
                        $this->getUpdateFieldType($transactot, 'deposit_commission', $transact->commission, $newAmt);
                        break;
                    case 'bank_transfers':
                        $this->getUpdateFieldType($transactot, 'btransfer_commission', $transact->commission, $newAmt);
                        break;
                }
    
                $transactot->timestamps = false;
                $transactot->save();
            }

           //Update main single transaction
           $transact->amount = $newAmt;
           if($type == 'deposit' || $type == 'pos' || $type == 'bank_transfers'){
                $transact->commission = $request->post('commission');
           }
           $transact->description = $request->post('description');
           $transact->timestamps = false;
           
           if($transact->save()){
               return redirect()->route('admin.transacts.details',['type'=>$transtype,'id'=>$transactId])->with('info','Transaction successfully!');
           }else{
            return redirect()->route('admin.transacts.details',['type'=>$transtype,'id'=>$transactId])->with('warning','Transaction NOT updated!');
           } 
        }else{
            return redirect()->route('admin.transacts.details',['type'=>$transtype,'id'=>$transactId])->with('warning','Transaction does NOT exist!'); 
        }
    }

    public function destroy($type, $transactId)
    {
        $troute = 'admin.transacts.credits';

        if($type=='credit'){
            $transactQuery = CreditTansact::where('transaction_id', $transactId);
            $troute = 'admin.transacts.credits';
        }elseif('debit'){
            $transactQuery = DebitTansact::where('transaction_id', $transactId);
            $troute = 'admin.transacts.debits';
        }

        //Find the single transaction to be deleted
        $transact = $transactQuery->first();

        /*Check whether report has been summitted 
        for this transaction*/
        if(isSubmittedReport($transact->office_id, $transact->date_created)){
            return back()->with('warning','Transaction report is already submitted!'); 
        }

        if($transact->type!='collected' && $transact->type!='top_ups' && $transact->type!='funded' && $transact->type!='closing'){
            $transactot = Transactions::where(['date_created'=>$transact->date_created, 'office_id'=>$transact->office_id])->first();

            $this->getDelFieldType($transactot, $transact->type, $transact->amount);
            
            switch($transact->type){
                case 'pos':
                    $this->getDelFieldType($transactot, 'pos_commission', $transact->commission);
                    //Delete transaction evidence
                    if($transact->evidence_url!=null){
                        unlink($transact->evidence_url);
                    }
                    break;
                case 'deposit':
                    $this->getDelFieldType($transactot, 'deposit_commission', $transact->commission);
                    break;
                case 'bank_transfers':
                    $this->getDelFieldType($transactot, 'btransfer_commission', $transact->commission);
                    break;
                case 'winnings_paid':
                    //Delete transaction evidence
                    if($transact->evidence_url!=null){
                        unlink($transact->evidence_url);
                    }
                    break;
            }

            $transactot->timestamps = false;
            $transactot->save();
        }
        
        
        //Check whether User exist
        $exists = $transactQuery->exists();

        if($exists){
           if($transact->delete()){
               return redirect()->route($troute, ['type'=>reverseFieldTypeFormat($transact->type)])->with('info','Transaction deleted successfully!');
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
            case 'deposit':
                $transactot->deposit = $transactot->deposit+$transAmt;
                break;
            case 'deposit_commission':
                $transactot->deposit_commission = $transactot->deposit_commission+$transAmt;
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
            case 'pos_commission':
                $transactot->pos_commission = $transactot->pos_commission+$transAmt;
                break;
            case 'expenses':
                $transactot->expenses = $transactot->expenses+$transAmt;
                break;     
            case 'top_ups':
                $transactot->top_ups = $transactot->top_ups+$transAmt;
                break; 
            case 'bank_transfers':
                $transactot->bank_transfers = $transactot->bank_transfers+$transAmt;
                break;
            case 'btransfer_commission':
                $transactot->btransfer_commission = $transactot->btransfer_commission+$transAmt;
                break;      
            case 'closing':
                $transactot->closing =$transactot->closing+$transAmt;
                break; 
            case 'cash_at_hand':
                $transactot->cash_at_hand = $transactot->cash_at_hand+$transAmt;
                break; 
        }

        return $transactot;
    }
    
    public function getDelFieldType($transactot, $typeField, $transAmt){
        switch ($typeField) { 
            case 'funded':
                $transactot->funded = $transactot->funded-$transAmt;
                break;
            case 'drop_money':
                $transactot->drop_money = $transactot->drop_money-$transAmt;
                break;
            case 'deposit':
                $transactot->deposit = $transactot->deposit-$transAmt;
                break;
            case 'deposit_commission':
                $transactot->deposit_commission = $transactot->deposit_commission-$transAmt;
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
            case 'pos_commission':
                $transactot->pos_commission = $transactot->pos_commission-$transAmt;
                break;
            case 'expenses':
                $transactot->expenses = $transactot->expenses-$transAmt;
                break;     
            case 'top_ups':
                $transactot->top_ups = $transactot->top_ups-$transAmt;
                break; 
            case 'bank_transfers':
                $transactot->bank_transfers = $transactot->bank_transfers-$transAmt;
                break;
            case 'btransfer_commission':
                $transactot->btransfer_commission = $transactot->btransfer_commission-$transAmt;
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

    public function getUpdateFieldType($transactot, $typeField, $transAmt, $newAmt){
        switch ($typeField) { 
            case 'funded':
                $transactot->funded = $transactot->funded-$transAmt+$newAmt;
                break;
            case 'drop_money':
                $transactot->drop_money = $transactot->drop_money-$transAmt+$newAmt;
                break;
            case 'deposit':
                $transactot->deposit = $transactot->deposit-$transAmt+$newAmt;
                break;
            case 'deposit_commission':
                $transactot->deposit_commission = $transactot->deposit_commission-$transAmt+$newAmt;
                break;
            case 'sales':
                $transactot->sales = $transactot->sales-$transAmt+$newAmt;
                break; 
            case 'collected':
                $transactot->collected = $transactot->collected-$transAmt+$newAmt;
                break; 
            case 'winnings_paid':
                $transactot->winnings_paid = $transactot->winnings_paid-$transAmt+$newAmt;
                break;
            case 'pos':
                $transactot->pos = $transactot->pos-$transAmt+$newAmt;
                break; 
            case 'pos_commission':
                $transactot->pos_commission = $transactot->pos_commission-$transAmt+$newAmt;
                break;
            case 'expenses':
                $transactot->expenses = $transactot->expenses-$transAmt+$newAmt;
                break;     
            case 'top_ups':
                $transactot->top_ups = $transactot->top_ups-$transAmt+$newAmt;
                break; 
            case 'bank_transfers':
                $transactot->bank_transfers = $transactot->bank_transfers-$transAmt+$newAmt;
                break;
            case 'btransfer_commission':
                $transactot->btransfer_commission = $transactot->btransfer_commission-$transAmt+$newAmt;
                break;      
            case 'closing':
                $transactot->closing =$transactot->closing-$transAmt+$newAmt;
                break; 
            case 'cash_at_hand':
                $transactot->cash_at_hand = $transactot->cash_at_hand-$transAmt+$newAmt;
                break; 
        }

        return $transactot;
    }
}
