<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditTansact extends Model
{
    protected $table = 'admin_transctions_credit';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'transaction_id',
        'role_id',
        'benefitiary',
        'amount',
        'type',
        'description'
    ];

    protected $timestamp = true;
}
