<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

const URL_PLACEHOLDER = 'https://via.placeholder.com/150';

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'cnpj',
        'corporate_name',
        'image_url',
        'active',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected function getCnpjAttribute($value)
    {
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' .
            substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' .
            substr($value, 12, 2);
    }

    protected function getImageUrlAttribute($value)
    {
        return $value ?? URL_PLACEHOLDER;
    }
}
