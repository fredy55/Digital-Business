<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admins;

class AdminLoginController extends Controller
{
    
    public function index(){
        return view('admin.index');
    }
    
    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'mail_admin' => 'required|email',
            'pass_admin' => 'required|min:6'
        ]);

        

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->mail_admin, 'password' => $request->pass_admin])) {
            //Chech user account status
            $accQuery = Admins::where('email',$request->mail_admin);
            $accstate = $accQuery->first(); 
                
            if($accstate->IsActive==1){
                //Update last login
                $accQuery->update(['last_login'=>date('M d, Y h:i a')]);
                
                // if successful, then redirect to their intended location
                return redirect()->intended(route('admin.dashboard'));
            }else{
                if(Auth::guard('admin')->logout()){
                    session()->flush();
                    return redirect()->route('admin.login.form')->with('warning','Your account is inactive!');;
                }else{
                    return redirect()->route('admin.dashboard');
                }
            }
        }else{
            // if unsuccessful, then redirect back to the login with the form data
            // return redirect()->back()->withInput($request->only('email'));
            return redirect()->back()->with('warning','Wrong username or password!');
        }  
         
    }

    public function dashboard()
    {
        
        return view('admin.dashboard');
    }

    public function logout()
    {
        if(Auth::guard('admin')->logout()){
            session()->flush();
            return redirect()->route('admin.login.form');
        }else{
            return redirect()->route('admin.dashboard');
        }  
    }
}
