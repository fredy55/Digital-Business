<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Messages;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Messages::all();

        return view('admin.messages.list', ['messages'=>$messages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details = Messages::find($id);

        return view('admin.messages.view', ['details'=>$details]);
    }

    public function getMessage(Request $request)
    {
        $msgid = $request->post('msgid');
        $message = Messages::where('id', $msgid)->first();

        if($message->id == $msgid){
             return response()->json([
                        'status'=>'success',
                        'formval'=> [
                            'name'=>$message->mgname,
                            'email'=>$message->mgemail,
                            'id'=>$message->id,
                            'subject'=>'Re: '.$message->mgsubject
                         ]
                    ]);
        }

        return response()->json(['status'=>'failed']);
    }

    public function updateMessage(Request $request)
    {
        //Validate form data
        $this->validate($request,[
            'sendto'=>'required|string|email',
            'sender'=>'required|string',
            'id'=>'required|numeric',
            'subject'=>'required|string',
            'msg'=>'required|string'
        ]);

        //Get form data
        $msgid=$request->post('id');
        
        //Check whether role exist
        $msgQuery=Messages::where('id', $msgid);
        
        if($msgQuery->exists()){
           //Save reply
           $msgSend=$msgQuery->first();
           $msgSend->repbody = $request->post('msg');
           $msgSend->updated_at = date('d-m-Y h:i:s a');
           $msgSend->IsActive = 2;
           
           if($msgSend->save()){

                //send mail
                $message = '
                        <p>Dear '.$request->input('sender').',</p>
                        <p>
                            '.$request->input('msg').'
                        </p>';
                
                $data = [
                    "to"=>$request->input('sendto'),
                    "subject"=> "Agent Support",
                    "message"=>$message
                ];

                $url = "https://www.betkingagent.com/emailapp/sendmail.php";

                emailAPI("POST", $url, $data, $headers = null);

               return redirect()->route('admin.messages.details', ['id'=>$msgid])->with('info','Messages Replied successfully!');
           }else{
              return redirect()->route('admin.messages.details', ['id'=>$msgid])->with('warning','Messages  NOT Replied!');
           } 
        }else{
            return redirect()->route('admin.messages.details', ['id'=>$msgid])->with('warning','Messages does NOT exist!'); 
        }
    }

    public function destroy($id)
    {
        //Record Exist
        $exist = DB::table('messages')->where(['id'=>$id])->exists();
        
        if($exist){
            //Find Messages
            $messages= Messages::find($id);

            if($messages->delete()){
                return redirect()->route('admin.messages')->with('success','Messages deleted successfully!');
            }else{
                return redirect()->route('admin.messages.details',['id'=>$id])->with('error','Messages NOT deleted!');
            }
        }else{
            return redirect()->route('admin.messages.details',['id'=>$id])->with('warning','Messages does NOT exist!');
        }
    }
}
