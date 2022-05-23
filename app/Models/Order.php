<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'address_id',
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

    public function address()
    {
        return $this->belongsTo(CompanyAddress::class, 'address_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
