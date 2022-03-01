<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleModules extends Model
{
    protected $table = 'admin_role_modules';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'role_id',
        'module_id'
    ];
    
    protected $timestamp = true;
}
