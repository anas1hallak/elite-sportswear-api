<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'coachName',
        'code',
        'discount',
    ];

    protected $hidden = ['created_at','updated_at'];
}
