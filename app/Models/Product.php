<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'measure_unit',
        'price',
        'image_url',
        'description',
        'active'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image_url ?? 'https://via.placeholder.com/100';
    }
}
