<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
