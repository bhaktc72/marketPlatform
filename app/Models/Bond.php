<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bond extends Model
{
    use HasFactory;

    // Add 'name' to the fillable property
    protected $fillable = [
        'isin',
        'issuer',
        'coupon_rate',
        'maturity_date',
        'rating',
        'segmentOfIssuer',
        'ModelYield',
        'modelPrice',
        'Y15DaysYield',
        'P15DaysPrice',
        'finalYield',
        'finalPrice',
        'remarks',
    ];
}
