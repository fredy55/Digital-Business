<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agentreg extends Model
{
    protected $table = 'agentregs';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'dob',
        'gender',
        'shop_address',
        'landmark',
        'lga',
        'state',
        'ref_chan',
        'indoor_img_location',    
        'outdoor_img_location'    
    ];

    protected $timestamp = false;
}
