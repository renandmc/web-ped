<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

const GRAVATAR_URL = 'https://www.gravatar.com/avatar/';
const UIAVATARS_URL = 'https://ui-avatars.com/api/?background=0e21f0&color=fff&size=200&name=';

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminlte_image()
    {
        $email = strtolower(trim($this->email));
        return GRAVATAR_URL . md5($email) . '?s=200&r=g&d=' . urlencode(UIAVATARS_URL . $this->name);
    }

    public function adminlte_desc()
    {
        return $this->email;
    }

    public function adminlte_profile_url()
    {
        return 'admin/user/profile';
    }
}
