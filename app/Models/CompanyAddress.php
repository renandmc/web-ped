<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_adresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cep',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'notes',
        'active'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected function getCepAttribute($value)
    {
        return substr($value, 0, 5) . '-' . substr($value, 4, 3);
    }
}
