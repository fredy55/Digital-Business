<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admins;
use App\Models\Agentreg;

class AgentsController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $agents = Agentreg::where('status', 'active')->orderBy('id', 'asc')->get();

        //dd($agents[0]);

        return view('admin.agents.list',['agents'=>$agents]);
    }

    public function view($id)
    {
        $details = Agentreg::find($id);
        $dateCreated = Carbon::parse($details->created_at)->format('d-m-Y, h:i A');

        return view('admin.agents.details',['details'=>$details, 'created_at'=>$dateCreated]);
    }

    public function destroy($id)
    {
        $agentimg= Agentreg::find($id);
        $agentpic = json_decode($agentimg->image_url, true);

        if($agentimg->delete()){
            //Delete Images
            if(!empty($agentpic[0]['img_url']) && $agentpic[0]['img_url']!='myadmin/admin_img/agent-dumy1.jpg'){
                unlink($agentpic[0]['img_url']);
                unlink($agentpic[1]['img_url']);
            }

            return redirect()->route('admin.agents')->with('success','Agent deleted successfully!');
           
        }else{
            return back()->with('error','Agent NOT deleted!');
        }
    }
}
