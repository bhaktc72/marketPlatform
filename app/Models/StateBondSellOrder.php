<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateBondSellOrder extends Model
{
    public function stateBondSell()
    {
        return $this->belongsTo(StateGovtBonds::class, 'bond_id', 'id');
    }
}

