<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    protected $table = 'admin_offices';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'office_id',   
        'office_name',   
        'email',   
        'phone_no',   
        'address'   
    ];

    protected $timestamp = true;
}
