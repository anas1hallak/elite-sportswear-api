<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    
    protected $fillable = [
        'title',
        'path',
    ];

    protected $hidden = ['created_at','updated_at'];
}
