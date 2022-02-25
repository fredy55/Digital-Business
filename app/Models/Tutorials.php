<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorials extends Model
{
    protected $table = 'tutorials';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'category_id',
        'artic_title',
        'description'   
    ];

    protected $timestamp = true;

    //Model relationships
    public function tutcategory()
    {
        return $this->hasMany('App\Models\TutCategory', 'category_id', 'category_id');
    }

}
