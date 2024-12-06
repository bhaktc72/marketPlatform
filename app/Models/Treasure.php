<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treasure extends Model
{
    protected $table = 'treasures';

    protected $fillable = [
        'tenure',
        'rate',
        'status',
    ];
}
