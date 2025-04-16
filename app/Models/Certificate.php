<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'expiresAt',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_certificates')
            ->withPivot('id', 'isRevoked', 'created_at')
            ->withTimestamps();
    }
}
