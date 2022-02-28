<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Offices;

class OfficesController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //Fetch all offices
        $offices = Offices::all();

        return view('admin.offices.index', ['offices'=>$offices]);
    }

    public function show($office_id)
    {
        //Fetch all offices
        $details = Offices::where('office_id', $office_id)->first();
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
           $office = new Offices;
           $office->office_id = idGenerate();
           $office->office_name = $request->post('ofname');
           $office->phone_no = $request->post('ofphone');
           $office->email = $request->post('ofemail');
           $office->address = $request->post('ofaddress');
           
           if($office->save()){
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
