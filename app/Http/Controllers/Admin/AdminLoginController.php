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
            // if successful, then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));
        }else{
            // if unsuccessful, then redirect back to the login with the form data
            return redirect()->back()->withInput($request->only('email'));
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