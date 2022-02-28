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
                                ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admin_transctions_credit.office_id')
                                ->select('admin_transctions_credit.*','admin_offices.office_name')
                                ->get();

        return view('admin.transactions.credits', ['credits'=>$credits ]);
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
            
        }
        
        //var_dump($details); exit();
       
        return view('admin.transactions.details', ['details'=>$details, 'type'=>$type]);
    }

    public function store(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'from'=>'required|string',
            'amount'=>'required|numeric',
            'type'=>'required|string',
            'description'=>'required|string'
        ]);

        //Save data
        $transactionId = serialNum();

        $transaction = new CreditTansact;
        $transaction->transaction_id = $transactionId;
        $transaction->office_id = Auth::user()->office_id;
        $transaction->user_id = Auth::user()->user_id;
        $transaction->benefitiary = $request->post('from');
        $transaction->amount = $request->post('amount');
        $transaction->type = $request->post('type');
        $transaction->description = $request->post('description');
        
        if($transaction->save()){
            return redirect()->route('admin.users')->with('info','Transaction saved successfully!');
        }else{
            return back()->with('warning','Transaction NOT saved!');
        } 
        
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
        //Check whether User exist
        $exists = CreditTansact::where('transaction_id', $transactId)->exists();

        if($exists){
           //Save admins
           $user = CreditTansact::where('transaction_id', $transactId)->first();
           
           if($user->delete()){
               return redirect()->route('admin.transacts.credits')->with('info','Transaction deleted successfully!');
           }else{
            return back()->with('warning','Transaction Account NOT deleted!');
           } 
        }else{
            return back()->with('warning','Transaction does NOT exist!'); 
        }
    }
}
