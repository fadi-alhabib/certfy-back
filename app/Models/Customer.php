<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'fullNameAr',
        'fullNameEn',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class, 'customer_certificates')
            ->withPivot('id', 'isRevoked', 'created_at')
            ->withTimestamps();
    }
}
