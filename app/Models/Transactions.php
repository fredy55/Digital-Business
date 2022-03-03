<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'admin_transctions_main';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'transaction_id',
        'role_id',
        'funded',
        'top_ups',
        'drop_money',
        'collected',
        'expenses',
        'winnings_paid',
        'pos',
        'bank_transfers',
        'sales',
        'closing',
        'cash_at_hand',
        'date_created'  
    ];

    protected $timestamp = false;
}
