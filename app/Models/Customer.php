<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens;
    protected $fillable=[
        'name',
        'phone_number',
        'password',
        'balance',
        'address',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function books()
    {
    return $this->belongsToMany(Book::class, 'borrowings')
        ->withPivot('borrowing_date', 'return_date', 'is_returned');
    }
    
}
