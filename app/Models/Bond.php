<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    use HasFactory;

    // Add 'name' to the fillable property
    protected $fillable = [
        'name',
        'code',
        'issuer',
        'currency',
        'maturity',
        'face_value',
        'coupon',
        'frequency',
        'day_count',
        'price',
        'status',
    ];
}
