<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateBondBuyOrder extends Model
{
    public function stateBondBuy()
    {
        return $this->belongsTo(StateGovtBonds::class, 'bond_id', 'id');
    }
}
