<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class staff extends Authenticatable
{
    use hasapiTokens;

    protected $fillable=[
        'name',
        'email',
        'password',
        'role',
        'phone_number',
    ];
    
    protected $hidden = [
        'password',
        'remember_Token',
    ];

    protected $casts = [
        'password'=>'hashed',
    ];
}
