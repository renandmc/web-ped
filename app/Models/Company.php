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

    public function adresses()
    {
        return $this->hasMany(CompanyAddress::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function buyers()
    {
        return $this->belongsToMany(Company::class, 'partners', 'seller_id', 'buyer_id')
            ->withPivot('status');
    }

    public function buyersPending()
    {
        return $this->belongsToMany(Company::class, 'partners', 'seller_id', 'buyer_id')
            ->wherePivot('status', 'Pendente');
    }

    public function buyersActive()
    {
        return $this->belongsToMany(Company::class, 'partners', 'seller_id', 'buyer_id')
            ->wherePivot('status', 'Ativo');
    }

    public function sellers()
    {
        return $this->belongsToMany(Company::class, 'partners', 'buyer_id', 'seller_id')
            ->withPivot('status');
    }

    public function sellersPending()
    {
        return $this->belongsToMany(Company::class, 'partners', 'buyer_id', 'seller_id')
            ->wherePivot('status', 'Pendente');
    }

    public function sellersActive()
    {
        return $this->belongsToMany(Company::class, 'partners', 'buyer_id', 'seller_id')
            ->wherePivot('status', 'Ativo');
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
