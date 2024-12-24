<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateGovtBonds extends Model
{
    protected $fillable = [
        'isin',
        'stateGovt',
        'nomenclature',
        'dateOfIssue',
        'dateOfMaturity',
        'outStandingStock',
    ];
}
