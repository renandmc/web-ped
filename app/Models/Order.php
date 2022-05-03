<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'datetime',
        'discount',
        'extra',
        'total',
        'status',
        'notes'
    ];

    public function buyer()
    {
        return $this->belongsTo(Company::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Company::class, 'seller_id');
    }
}
