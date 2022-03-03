<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Offices;
use App\Models\TotalTansact;

class OfficesController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    private function checkPageAccesss($pagemodule){
        if(!has_access_to( Auth::user()->role_id, $pagemodule)){
            return redirect()->route('admin.restrict.denied');
        }
    }

    public function index()
    {
        //Check page access
        if(!has_access_to( Auth::user()->role_id,4)){
            return redirect()->route('admin.restrict.denied');
        }

        //Fetch all offices
        $offices = Offices::all();

        return view('admin.offices.index', ['offices'=>$offices]);
    }

    public function show($office_id)
    {
        //Check page access
        if(!has_access_to( Auth::user()->role_id,14)){
            return redirect()->route('admin.restrict.denied');
        }
        
        //Fetch all offices
        $details = Offices::where('admin_offices.office_id', $office_id)
                            ->leftJoin('admins', 'admins.office_id', '=', 'admin_offices.office_id')
                            ->select('admin_offices.*', 'admins.ftname', 'admins.ltname')
                            ->first();
        //var_dump($details); exit();

        return view('admin.offices.details', ['details'=>$details]);
    }

    public function store(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'ofname'=>'required|string',
            'ofphone'=>'required|numeric',
            'ofemail'=>'nullable|email',
            'ofaddress'=>'required|string'
        ]);

        //Check whether Office exist
        $exists=Offices::where('email', $request->post('ofphone'))->doesntExist();

        if($exists){
           //Save data
           $officeId = idGenerate();
           $accountId = serialNum();

           $office = new Offices;
           $office->office_id = $officeId;
           $office->account_id = $accountId;
           $office->office_name = $request->post('ofname');
           $office->phone_no = $request->post('ofphone');
           $office->email = $request->post('ofemail');
           $office->address = $request->post('ofaddress');

           //Create office transaction Account
           $accounts = new TotalTansact;
           $accounts->office_id = $officeId;
           $accounts->account_id = $accountId;
           $accounts->funded = 0.0;
           $accounts->top_ups = 0.0;
           $accounts->drop_money =0.0;
           $accounts->sales =0.0;
           $accounts->closing = 0.0;
           $accounts->cash_at_hand = 0.0; 
           
           if($office->save() && $accounts->save()){
               
               return redirect()->route('admin.offices')->with('info','Office created successfully!');
           }else{
              return back()->with('warning','Office NOT created!');
           } 
        }else{
            return back()->with('warning','Office already exist!'); 
        }
    }

    
    public function update(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'ofname'=>'required|string',
            'ofphone'=>'required|numeric',
            'ofemail'=>'nullable|email',
            'ofaddress'=>'required|string'
        ]);
        
        //Get offices ID
        $officeId = $request->post('officeId');

        //Check whether Office exist
        $exists=Offices::where('office_id', $officeId)->exists();

        if($exists){
           //Save data
           $office = Offices::where('office_id', $officeId)->first();
           $office->office_id = $officeId;
           $office->office_name = $request->post('ofname');
           $office->phone_no = $request->post('ofphone');
           $office->email = $request->post('ofemail');
           $office->address = $request->post('ofaddress');
           
           if($office->save()){
               return back()->with('info','Office updated successfully!');
           }else{
              return back()->with('warning','Office NOT updated!');
           } 
        }else{
            return back()->with('warning','Office does NOT exist!'); 
        }
    }

    
    public function destroy($officeId)
    {
        //Check page access
        if(!has_access_to( Auth::user()->role_id,15)){
            return redirect()->route('admin.restrict.denied');
        }

        //Check whether Office exist
        $exists=Offices::where('office_id', $officeId)->exists();

        if($exists){
           //Save offices
           $office = Offices::where('office_id', $officeId)->first();
           
           if($office->delete()){
               return redirect()->route('admin.offices')->with('info','Office deleted successfully!');
           }else{
            return back()->with('warning','Office NOT deleted!');
           } 
        }else{
            return back()->with('warning','Office does NOT exist!'); 
        }
    }
}
