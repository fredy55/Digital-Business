<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Offices;
use App\Models\Admins;
use App\Models\UserRoles;

class UsersController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //Set session to collapse Users tab
        session(['tab'=>'users']);

        //Fetch all admins
        $admins = Admins::whereIn('admins.IsActive', [0,1,2])
                        ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admins.office_id')
                        ->leftJoin('admin_roles', 'admin_roles.id', '=', 'admins.role_id')
                        ->select('admins.*','admin_offices.office_name', 'admin_roles.role_name')
                        ->get();
        
        //Fetch all Offices
        $offices = Offices::where('IsActive', 1)
                            ->select('office_name','office_id')
                            ->get();
        //Fetch all Roles
        $roles = UserRoles::where('IsActive', 1)
                            ->select('role_name','id')
                            ->get();

        //var_dump($roles); exit();

        return view('admin.users.index', ['admins'=>$admins, 'offices'=>$offices, 'roles'=>$roles ]);
    }

    public function show($user_id)
    {
        //Set session to collapse Users tab
        session(['tab'=>'users']);

        //Check page access
        if(!has_access_to( Auth::user()->role_id,5)){
            return redirect()->route('admin.restrict.denied');
        }

        //Fetch all admins
        $details = Admins::where('admins.user_id', $user_id)
                            ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admins.office_id')
                            ->leftJoin('admin_roles', 'admin_roles.id', '=', 'admins.role_id')
                            ->select('admins.*','admin_offices.office_name', 'admin_roles.role_name', 'admin_roles.id as roleId')
                            ->first();
        //Fetch all Offices
        $offices = Offices::where('IsActive', 1)
                            ->select('office_name','office_id')
                            ->get();
        //Fetch all Roles
        $roles = UserRoles::where('IsActive', 1)
                            ->select('role_name','id')
                            ->get();


        return view('admin.users.details', ['details'=>$details, 'offices'=>$offices, 'roles'=>$roles]);
    }

/*=============== STAFF PROFILE START ===============*/
    public function profile()
    {
        //Set session to collapse Users tab
        session(['tab'=>'users']);

        //Fetch all admins
        $details = Admins::where('admins.user_id', Auth::user()->user_id)
                            ->leftJoin('admin_offices', 'admin_offices.office_id', '=', 'admins.office_id')
                            ->leftJoin('admin_roles', 'admin_roles.id', '=', 'admins.role_id')
                            ->select('admins.*','admin_offices.office_name', 'admin_roles.role_name', 'admin_roles.id as roleId')
                            ->first();
        //Fetch all Offices
        $offices = Offices::where('IsActive', 1)
                            ->select('office_name','office_id')
                            ->get();
        //Fetch all Roles
        $roles = UserRoles::where('IsActive', 1)
                            ->select('role_name','id')
                            ->get();


        return view('admin.users.profile', ['details'=>$details, 'offices'=>$offices, 'roles'=>$roles]);
    }

    public function profileUpdate(Request $request)
    {
       //Validate form data
       $this->validate($request,[
            'fname'=>'required|string',
            'lname'=>'required|string',
            'phone'=>'required|numeric',
            'email'=>'nullable|email',
            'gender'=>'required|string',
            'caccount'=>'required|string',
            'address'=>'required|string'
        ]);

        //Get admins ID
        $userId = Auth::user()->user_id;

        //Check whether Office exist
        $exists=Admins::where('user_id', $userId)->exists();

        if($exists){
           //Save data
           $user = Admins::where('user_id', $userId)->first();
           $user->ftname = $request->post('fname');
           $user->ltname = $request->post('lname');
           $user->phone_no = $request->post('phone');
           $user->email = $request->post('email');
           $user->gender = $request->post('gender');
           $user->address = $request->post('address');
           $user->credit_account = $request->post('caccount');
           
           if($user->save()){
               return back()->with('info','Staff Profile updated successfully!');
           }else{
              return back()->with('warning','Staff Profile NOT updated!');
           } 
        }else{
            return back()->with('warning','Staff Profile does NOT exist!'); 
        }
    }
/*=============== STAFF PROFILE END ===============*/

    public function store(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'fname'=>'required|string',
            'lname'=>'required|string',
            'phone'=>'required|numeric',
            'email'=>'nullable|email',
            'gender'=>'required|string',
            'office'=>'required|numeric',
            'lgrade'=>'required|numeric',
            'role'=>'required|numeric',
            'caccount'=>'required|string',
            'address'=>'required|string'
        ]);

        //Check whether Office exist
        $exists=Admins::where('email', $request->post('email'))->doesntExist();

        if($exists){
           //Save data
           $userId = serialNum();

           $user = new Admins;
           $user->user_id = $userId;
           $user->role_id = $request->post('role');
           $user->office_id = $request->post('office');
           $user->ftname = $request->post('fname');
           $user->ltname = $request->post('lname');
           $user->phone_no = $request->post('phone');
           $user->email = $request->post('email');
           $user->level = $request->post('lgrade');
           $user->password = Hash::make($userId);
           $user->address = $request->post('address');
           $user->credit_account = $request->post('caccount');
           
           if($user->save()){
               return redirect()->route('admin.users')->with('info','Staff Account created successfully!');
           }else{
              return back()->with('warning','Staff Account NOT created!');
           } 
        }else{
            return back()->with('warning','Staff Account already exist!'); 
        }
    }

    public function update(Request $request)
    {
       //Validate form data
       $this->validate($request,[
            'fname'=>'required|string',
            'lname'=>'required|string',
            'phone'=>'required|numeric',
            'email'=>'nullable|email',
            'gender'=>'required|string',
            'office'=>'required|numeric',
            'lgrade'=>'required|numeric',
            'role'=>'required|numeric',
            'caccount'=>'required|string',
            'address'=>'required|string'
        ]);

        //Get admins ID
        $userId = $request->post('userId');

        //Check whether Office exist
        $exists=Admins::where('user_id', $userId)->exists();

        if($exists){
           //Save data
           $user = Admins::where('user_id', $userId)->first();
           $user->role_id = $request->post('role');
           $user->office_id = $request->post('office');
           $user->ftname = $request->post('fname');
           $user->ltname = $request->post('lname');
           $user->phone_no = $request->post('phone');
           $user->email = $request->post('email');
           $user->gender = $request->post('gender');
           $user->level = $request->post('lgrade');
           $user->address = $request->post('address');
           $user->credit_account = $request->post('caccount');
           
           if($user->save()){
               return back()->with('info','Staff Account updated successfully!');
           }else{
              return back()->with('warning','Staff Account NOT updated!');
           } 
        }else{
            return back()->with('warning','Staff Account does NOT exist!'); 
        }
    }
 
    public function deactivate($userId)
    {
        //Check whether User exist
        $exists = Admins::where('user_id', $userId)->exists();

        if($exists){
           //Save admins
           $user = Admins::where('user_id', $userId)->first();
           $user->IsActive = 0;
           
           if($user->save()){
               return back()->with('info','Staff Account deactivated successfully!');
           }else{
            return back()->with('warning','Staff Account NOT deactivated!');
           } 
        }else{
            return back()->with('warning','Staff Account does NOT exist!'); 
        }
    }

    public function activate($userId)
    {
        //Check whether User exist
        $exists = Admins::where('user_id', $userId)->exists();

        if($exists){
           //Save admins
           $user = Admins::where('user_id', $userId)->first();
           $user->IsActive = 1;
           
           if($user->save()){
               return back()->with('info','Staff Account activated successfully!');
           }else{
            return back()->with('warning','Staff Account NOT activated!');
           } 
        }else{
            return back()->with('warning','Staff Account does NOT exist!'); 
        }
    }
    
    public function destroy($userId)
    {
        //Check whether User exist
        $exists = Admins::where('user_id', $userId)->exists();

        if($exists){
           //Save admins
           $user = Admins::where('user_id', $userId)->first();
           
           if($user->delete()){
               return redirect()->route('admin.users')->with('info','Staff Account deleted successfully!');
           }else{
            return back()->with('warning','Staff Account NOT deleted!');
           } 
        }else{
            return back()->with('warning','Staff Account does NOT exist!'); 
        }
    }
}
