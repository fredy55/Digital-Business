<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'msg_ticket',
        'name',
        'mgsubject',
        'mgemail',
        'mgphone',
        'mgbody',    
        'repbody'    
    ];
    
    protected $timestamp = true;
}
