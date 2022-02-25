<?php

namespace App\Traits;

trait Imgupload{

    public function get_imgarr($request, $filename){
        $imageArr = $request->file($filename);
        $data=[];
        if(!empty($imageArr)){
            for($i=0;$i<count($imageArr); ++$i){
                if($request->hasFile($filename) && $imageArr[$i]->isValid()){

                    //$img_name = $imageArr[$i]->getClientOriginalName();
                    $img_extension = $imageArr[$i]->getClientOriginalExtension();
                    $img_name = 'img_'.date('Gis').''.$i.'.'.$img_extension;
                    $data[$i]['img_name'] = $img_name;
                    $data[$i]['img_url']='user_upload/'.$img_name;

                    //store image file
                    $imageArr[$i]->storeAs('/user_upload', $img_name, 'public'); 
                }else{
                    $data[0]['img_url']='myadmin/admin_img/agent-dumy1.jpg';
                    $data[1]['img_url']='myadmin/admin_img/agent-dumy1.jpg';
                } 
            }
        }else{
            $data[0]['img_url']='myadmin/admin_img/agent-dumy1.jpg';
            $data[1]['img_url']='myadmin/admin_img/agent-dumy1.jpg';
        }

        return $data;
    }

    public function get_img($request, $filename){
        $imageArr = $request->file($filename);
        $data=[];
       
        if($request->hasFile($filename) && $imageArr->isValid()){
            //$img_name = $imageArr->getClientOriginalName();
            
            $img_extension = $imageArr->getClientOriginalExtension();
            $img_name = 'img_'.date('Gis').'.'.$img_extension;
            //$data['img_name'] = $img_name;
            $data['img_url']='storage/agents/'.$img_name;

            //store image file
            $imageArr->storeAs('/agents', $img_name, 'public'); 
        }else{
            return back()->with('warning','Invalid form data!');
        } 

        $jsn = json_encode($data);
        //var_dump($jsn); exit();

        return $jsn;
    }

    public function getSingleImg($request, $filename){
        $imageArr = $request->file($filename);
        
        $img_url = 'nil';

        if($request->hasFile($filename) && $imageArr->isValid()){
            
            $img_extension = $imageArr->getClientOriginalExtension();
            $img_name = 'img_'.date('Gis').'.'.$img_extension;
             $img_url='storage/equipment/'.$img_name;

            //store image file
            $imageArr->storeAs('/equipment', $img_name, 'public'); 
        }else{
            $img_url = 'nil';
        } 

        return $img_url;
    }
}