<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UserRoles;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //Fetch all userroles
        $roles = UserRoles::all();

        return view('admin.roles.index', ['roles'=>$roles]);
    }

    public function show($roles_id)
    {
        //Fetch all user roles
        $details = UserRoles::where('id', $roles_id)->first();
        //var_dump($details); exit();

        return view('admin.roles.details', ['details'=>$details]);
    }

    public function store(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'rname'=>'required|string',
            'rdescribe'=>'required|string'
        ]);

        //Check whether Roles exist
        $exists=UserRoles::where('role_name', $request->post('rname'))->doesntExist();

        if($exists){
           //Save data
           $roles = new UserRoles;
           $roles->role_name = $request->post('rname');
           $roles->role_description = $request->post('rdescribe');
           
           if($roles->save()){
               return redirect()->route('admin.roles')->with('info','Roles created successfully!');
           }else{
              return back()->with('warning','Roles NOT created!');
           } 
        }else{
            return back()->with('warning','Roles already exist!'); 
        }
    }

    
    public function update(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'rname'=>'required|string',
            'rdescribe'=>'required|string'
        ]);
        
        //Get userroles ID
        $rolesId = $request->post('roleId');

        //Check whether Roles exist
        $exists=UserRoles::where('id', $rolesId)->exists();

        if($exists){
           //Save data
           $roles = UserRoles::where('id', $rolesId)->first();
           $roles->role_name = $request->post('rname');
           $roles->role_description = $request->post('rdescribe');
           
           if($roles->save()){
               return back()->with('info','Role updated successfully!');
           }else{
              return back()->with('warning','Role NOT updated!');
           } 
        }else{
            return back()->with('warning','Role does NOT exist!'); 
        }
    }

    public function destroy($rolesId)
    {
        //Check whether Roles exist
        $exists=UserRoles::where('id', $rolesId)->exists();

        if($exists){
           //Save userroles
           $roles = UserRoles::where('id', $rolesId)->first();
           
           if($roles->delete()){
               return redirect()->route('admin.roles')->with('info','Role deleted successfully!');
           }else{
            return back()->with('warning','Role NOT deleted!');
           } 
        }else{
            return back()->with('warning','Role does NOT exist!'); 
        }
    }

    
}
