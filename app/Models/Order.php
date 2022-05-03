<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'size',
        'measure_unit',
        'price',
        'image_url',
        'description',
        'active'
    ];
}
