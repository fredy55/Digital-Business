<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UserModules;

class AdminModulesController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //Fetch all usermodules
        $modules = UserModules::all();

        return view('admin.modules.index', ['modules'=>$modules]);
    }

    public function show($modules_id)
    {
        //Fetch all user modules
        $details = UserModules::where('id', $modules_id)->first();
        //var_dump($details); exit();

        return view('admin.modules.details', ['details'=>$details]);
    }

    public function store(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'mgroup'=>'required|string',
            'mname'=>'required|string',
            'mdescribe'=>'required|string'
        ]);

        //Check whether Modules exist
        $exists=UserModules::where('module_name', $request->post('mname'))->doesntExist();

        if($exists){
           //Save data
           $modules = new UserModules;
           $modules->module_group = $request->post('mgroup');
           $modules->module_name = $request->post('mname');
           $modules->module_description = $request->post('mdescribe');
           
           if($modules->save()){
               return redirect()->route('admin.modules')->with('info','Module created successfully!');
           }else{
              return back()->with('warning','Module NOT created!');
           } 
        }else{
            return back()->with('warning','Module already exist!'); 
        }
    }

    
    public function update(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'mgroup'=>'required|string',
            'mname'=>'required|string',
            'mdescribe'=>'required|string'
        ]);
        
        //Get usermodules ID
        $modulesId = $request->post('moduleId');

        //Check whether Modules exist
        $exists=UserModules::where('id', $modulesId)->exists();

        if($exists){
           //Save data
           $modules = UserModules::where('id', $modulesId)->first();
           $modules->module_group = $request->post('mgroup');
           $modules->module_name = $request->post('mname');
           $modules->module_description = $request->post('mdescribe');
           
           if($modules->save()){
               return back()->with('info','Module updated successfully!');
           }else{
              return back()->with('warning','Module NOT updated!');
           } 
        }else{
            return back()->with('warning','Module does NOT exist!'); 
        }
    }

    
    public function destroy($modulesId)
    {
        //Check whether Modules exist
        $exists=UserModules::where('id', $modulesId)->exists();

        if($exists){
           //Save usermodules
           $modules = UserModules::where('id', $modulesId)->first();
           
           if($modules->delete()){
               return redirect()->route('admin.modules')->with('info','Module deleted successfully!');
           }else{
            return back()->with('warning','Module NOT deleted!');
           } 
        }else{
            return back()->with('warning','Module does NOT exist!'); 
        }
    }
}
