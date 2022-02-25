<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutCategory extends Model
{
    protected $table = 'tut_categories';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'category_id',
        'category',
        'description'    
    ];

    protected $timestamp = true;

    //Model relationships
    public function tutorials()
    {
        return $this->belongsTo('App\Models\Tutorials', 'category_id', 'category_id');
    }
}
