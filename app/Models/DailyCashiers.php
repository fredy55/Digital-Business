<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyCashiers extends Model
{
    protected $table = 'daily_cashier';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'office_id',
        'user_id',
        'account',
        'date_created'
    ];

    protected $timestamp = false;
}
