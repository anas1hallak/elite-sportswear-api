<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [

        'customerName',
        'phoneNumber',
        'state',
        'address',
        'qadmousName',
        'qadmousNumber',
        'qadmousBranch',

        'totalPrice',
        'coachName',
        'code',

        'status',

    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
        ->withPivot(['quantity','size', 'subtotal', 'subtotalAfterDiscount']);
    }

}
