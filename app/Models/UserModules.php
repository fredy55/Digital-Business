<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModules extends Model
{
    protected $table = 'admin_modules';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'module_group',
        'module_name',
        'module_description'   
    ];
    
    protected $timestamp = true;
}
