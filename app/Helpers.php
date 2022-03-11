<?php
use App\Models\UserRoles;
use App\Models\UserModules;
use App\Models\UserRoleModules;
use App\Models\TotalTansact;
use App\Models\Transactions;
use App\Models\CreditTansact;
use App\Models\DebitTansact;
use Illuminate\Support\Facades\Auth;


function get_img($request, $filename, $userId){
    $imageArr = $request->file($filename);
    $data=[];
   
    if($request->hasFile($filename) && $imageArr->isValid()){
        $img_extension = $imageArr->getClientOriginalExtension();
        $data['img_size'] = $imageArr->getSize();
        //  $img_size= $imageArr->getClientSize();
        $img_name = 'img_'.$userId.'.'.$img_extension;
        
        $data['img_url']='storage/users/'.$img_name;

        //store image file
        $imageArr->storeAs('/users', $img_name, 'public'); 
    }else{
        return redirect()->route('admin.users.profile')->with('warning','Invalid Image!');
    } 

    return $data;
}

function getrans_img($request, $filename, $transId){
    $imageArr = $request->file($filename);
    $data=[];
   
    if($request->hasFile($filename) && $imageArr->isValid()){
        $img_extension = $imageArr->getClientOriginalExtension();
        $data['img_size'] = $imageArr->getSize();
        //  $img_size= $imageArr->getClientSize();
        $img_name = 'img_'.$transId.'.'.$img_extension;
        
        $data['img_url']='storage/transevid/'.$img_name;

        //store image file
        $imageArr->storeAs('/transevid', $img_name, 'public'); 
    }else{
        return back()->with('warning','Invalid transaction evidence!');
    } 

    return $data;
}


function has_access_to($role_id,$module_id){
     $findAccess = UserRoleModules::where(['role_id'=>$role_id, 'module_id'=>$module_id])->exists();
     return $findAccess;
}

function findRole(){
     $findRole = UserRoles::where('id', Auth::user()->role_id)->first();
     return $findRole->role_name;
}

function findOffice($officeId){
    $office = Offices::where('office_id', $officeId)->first();
    return $office->office_name;
}

function verifyCashierSales($officeId, $userId, $date){
    return CreditTansact::where(['user_id'=>$userId, 'office_id'=>$officeId, 'date_created'=>$date, 'type'=>'sales'])->exists();
}

function getStatus($isActive){
   $status = 'Inactive';
   if($isActive==1){
      $status = 'Active';
   }

   return $status;
}

function dateFormat($date, $format){
    return Carbon\Carbon::parse($date)->format($format);
}

function transactStatus($isActive){
   $status = 'Pending';

   if($isActive==1){
      $status = 'Completed';
   }

   return $status;
}


function fieldTypeFormat($typeField){
    $format = '';
    switch ($typeField) { 
        case 'Funding':
            $format = 'funded';
            break;
        case 'Drop Money':
            $format = 'drop_money';
            break;
        case 'Sales':
            $format = 'sales';
            break; 
        case 'Collected':
            $format = 'collected';
            break; 
        case 'Winning Paid':
            $format = 'winnings_paid';
            break;
        case 'POS':
            $format = 'pos';
            break;
        case 'Deposit':
            $format = 'deposit';
            break; 
        case 'Expenses':
            $format = 'expenses';
            break;     
        case 'Top Ups':
            $format = 'top_ups';
            break; 
        case 'Bank Tranfers':
            $format = 'bank_tranfers';
            break;     
        case 'Closing':
            $format = 'closing';
            break; 
    }

    return $format;
}

function reverseFieldTypeFormat($typeField){
    $format = '';
    switch ($typeField) { 
        case 'funded':
            $format = 'Funding';
            break;
        case 'drop_money':
            $format = 'Drop Money';
            break;
        case 'sales':
            $format = 'Sales';
            break; 
        case 'collected':
            $format = 'Collected';
            break; 
        case 'winnings_paid':
            $format = 'Winning Paid';
            break;
        case 'deposit':
            $format = 'Deposit';
            break;
        case 'pos':
            $format = 'POS';
            break; 
        case 'expenses':
            $format = 'Expenses';
            break;     
        case 'top_ups':
            $format = 'Top Ups';
            break; 
        case 'bank_tranfers':
            $format = 'Bank Tranfers';
            break;     
        case 'closing':
            $format = 'Closing';
            break; 
    }

    return $format;
}

function idGenerate(){
    // six (6) digit user ID
    $today = date("Gis");
    $rand = sprintf("%04d", rand(0,999));
    $user_id = $rand.$today;
    return $user_id;
}

function serialNum(){
    // six (6) digit user ID
    $today = date("Gsi");
    $rand = sprintf("%03d", rand(0,999));
    $sn = $today.$rand;
    return $sn;
}

//GENERATE CODE
function uniqCodeGen($length){      
    $chars = 'X3Bfhsed4bK29cJK65EGbv665VfKJ776ttg76HG6tr7090hgg9112gfTT43HH6hjgEW55TG78N9d6Zgh4j1ED73SGl8m54nKp123rsHt5E45W45GVes765GsCe43J0221K41abW43Emn79877kDR900ES46KS82zaeiou01U34TR2j345TRe56ds6789';
    $result = '';

    for ($p = 0; $p < $length; $p++){
        $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
    }
    return $result;
}

function emailAPI($method, $url, $data, $headers = null)
{

    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);

    if ($headers && !empty($headers)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // EXECUTE:
    $result = curl_exec($curl);
    
    if (!$result) {
        //die("Connection Failure");
        return false;
    }
    curl_close($curl);
    
    return $result;
}