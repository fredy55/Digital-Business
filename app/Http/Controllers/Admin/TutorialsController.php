<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tutorials;
use App\Models\TutCategory;
use App\Traits\Imgupload;

class TutorialsController extends Controller
{
    //Call the image upload trait
   use Imgupload;

   public $data = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutorials = Tutorials::whereIn('category_id', [45385548,45084546,40384955])->where('IsActive', 1)->orderBy('created_at', 'desc')->get();

        return view('admin.tutorials.list', ['tutorials'=>$tutorials]);
    }

    public function faqList()
    {
        $tutorials = Tutorials::where(['IsActive'=>1, 'category_id'=>45384634])->orderBy('created_at', 'desc')->get();

        return view('admin.tutorials.faqlist', ['tutorials'=>$tutorials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = TutCategory::all();

        return view('admin.tutorials.add', ['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $validated=$this->validate($request, [
            'title'=>'required|string',
            'category'=>'required|numeric',
            'description'=>'required',
        ]);

        //Record Exist
        $exist = DB::table('tutorials')->where(['artic_title'=>$request->input('title')])->doesntExist();
        
        if($exist){
            //Save Tutorials
            $tutorials= new Tutorials;
            $tutorials->category_id = $request->input('category');
            $tutorials->artic_title= $request->input('title');
            $tutorials->description  = $request->input('description');
            
            if($tutorials->save()){
                return back()->with('success','Tutorials saved successfully!');
            }else{
                return back()->with('error','Tutorials NOT saved!');
            }
        }else{
            return back()->with('warning','Tutorials already exist!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details = Tutorials::find($id);

        return view('admin.tutorials.view', ['details'=>$details]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutorials = Tutorials::find($id);
        $category = TutCategory::all();

        return view('admin.tutorials.edit', ['tutorials'=>$tutorials, 'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated=$this->validate($request, [
            'title'=>'required|string',
            'category'=>'required|numeric',
            'description'=>'required',
        ]);

        //Record Exist
        $exist = DB::table('tutorials')->where(['id'=>$request->input('id')])->exists();
        
        if($exist){
            //Save Tutorials
            $tutorials= Tutorials::find($request->input('id'));
            $tutorials->category_id = $request->input('category');
            $tutorials->artic_title= $request->input('title');
            $tutorials->description  = $request->input('description');
            
            if($tutorials->save()){
                return redirect()->route('admin.tutorials.details',['id'=>$request->input('id')])->with('success','Tutorials updated successfully!');
            }else{
                return back()->with('error','Tutorials NOT updated!');
            }
        }else{
            return back()->with('warning','Tutorials does NOT exist!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Record Exist
        $exist = DB::table('Tutorials')->where(['id'=>$id])->exists();
        
        if($exist){
            //Find Tutorials
            $tutorials= Tutorials::find($id);

            if($tutorials->delete()){
                return redirect()->route('admin.tutorials')->with('success','Tutorials deleted successfully!');
            }else{
                return redirect()->route('admin.tutorials.details',['id'=>$id])->with('error','Tutorials NOT deleted!');
            }
        }else{
            return redirect()->route('admin.tutorials.details',['id'=>$id])->with('warning','Tutorials does NOT exist!');
        }
    }
}
