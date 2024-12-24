<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralGovtBonds extends Model
{
    protected $fillable = [
        'isin',
        'nomenclature',
        'dateOfIssue',
        'dateOfMaturity',
        'outStandingStock',
    ];
}
