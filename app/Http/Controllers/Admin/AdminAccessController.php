<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UserRoles;
use Illuminate\Support\Facades\DB;
use App\Models\UserModules;
use App\Models\UserRoleModules;

class AdminAccessController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    //Access restriction
    public function index($rolesId)
    {
         //Fetch all modules
         $modules = [];
         $modul = UserModules::distinct()->orderBy('module_group', 'asc')->get(['module_group']);
         $role = UserRoles::where('id', $rolesId)->first();

         //dd($modul); 

         for($i=0; $i<count($modul); ++$i){
             $modules[$i]['modulegroup']=$modul[$i]->module_group;
             $modules[$i]['modulname']=UserModules::where('module_group', $modul[$i]->module_group)->get();
          }
         
         $data['modules']=$modules;
         $data['UserRole']=$role->role_name;
         $data['roleId']=$role->id;
        
        return view('admin.permissions.index', $data);
    }

    public function save(Request $request)
    {
        $roleID = $request->post('roleId');
        $moduleID = $request->post('moduleId'); //This is an array
        
        //Delete existing permission
        DB::table('admin_role_modules')->where('role_id', $roleID)->delete();

        //var_dump($moduleID); exit();

        if($moduleID!=NULL){
            //Insert new permission
            $savecount=0;
            for($i=0; $i<count($moduleID); ++$i){
                $permit = new UserRoleModules;
                $permit->role_id = $roleID;
                $permit->module_id = $moduleID[$i];
                $permit->save();
                
                ++$savecount;
            }

            if($savecount>0){
                return redirect()->route('admin.restrict',['id'=>$roleID])->with('info','Permission saved!');
            }else{
                return redirect()->route('admin.restrict',['id'=>$roleID])->with('warning','Permission NOT saved!');
            } 
        }else{
            return redirect()->route('admin.restrict',['id'=>$roleID])->with('warning','Permission NOT saved!');
        } 
    }
    
    public function accessDenied(){
        
        return view('admin.permissions.denied');
    }
}
