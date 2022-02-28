<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admins;
use App\Models\Agentreg;
use App\Models\Messages;
use App\Models\Tutorials;

class AdminController extends Controller
{
    public $data = [];

    public function __construct()
    {
        // $this->middleware('auth:admin', ['except' => ['logout']]);
        $this->middleware('auth:admin');
    }
    
    public function dashboard()
    {   $data = [];
        // $data['agents'] = Agentreg::where('status', 'Active')->count();
        $data['messages'] = Messages::where('IsActive', 1)->orWhere('IsActive', 0)->count();
        // $data['tutorials'] = Tutorials::where('IsActive', 1)->count();
        // $data['faq'] = Tutorials::where(['IsActive'=>1, 'category_id' => 45384634])->count();

        return view('admin.dashboard',$data);
    }

}
