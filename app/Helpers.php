<?php
use App\Models\UserRoles;
use App\Models\UserModules;
use App\Models\UserRoleModules;
use Illuminate\Support\Facades\Auth;


function has_access_to($role_id,$module_id){
     $findAccess = UserRoleModules::where(['role_id'=>$role_id, 'module_id'=>$module_id])->exists();
     return $findAccess;
}

function findRole(){
     $findRole = UserRoles::where('id', Auth::user()->role_id)->first();
     return $findRole->role_name;
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

function transactTypeField($model, $formField){
    if ($formField =='funded') {
        return $model->funded;
    } elseif ($formField =='drop_money') {
        return $model->drop_money;
    }elseif ($formField =='sales') {
        return $model->sales;
    }elseif ($formField =='collected') {
        return $model->collected;
    }elseif ($formField =='winnings_paid') {
        return $model->winnings_paid;
    }elseif ($formField =='pos') {
        return $model->pos;
    }elseif ($formField =='expenses') {
        return $model->expenses;
    }elseif ($formField =='top_ups') {
        return $model->top_ups;
    }elseif ($formField =='bank_tranfers') {
        return $model->bank_tranfers;
    }elseif ($formField =='closing') {
        return $model->closing;
    }elseif ($formField =='cash_at_hand') {
        return $model->cash_at_hand;
    }
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