<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'admin_roles';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'role_name',
        'role_description'  
    ];

    protected $timestamp = true;
}
