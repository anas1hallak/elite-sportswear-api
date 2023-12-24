<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'category',
        'color',
        'sizes',
        'stock',
        'price',
        'priceAfterCode',
        'sizeGuide',
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'sizes' => 'json',
    ];


    public function image(){

        return $this->hasMany('App\Models\Image');
    }
}
