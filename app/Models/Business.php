<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Business extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
