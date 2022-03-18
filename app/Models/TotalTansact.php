<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalTansact extends Model
{
    protected $table = 'admin_transctions_totals';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'office_id',
        'transaction_id',
        'sales',
        'cash_at_hand'
    ];

    protected $timestamp = true;
}
