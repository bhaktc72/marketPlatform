<?php

namespace App\Imports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;

class BondImport implements ToModel
{
    public function model(array $row)
    {
        return new Bond([
            'isin'      => $row[0],
            'issuer'      => $row[1],
            'coupon_rate'    => $row[2],
            'maturity_date'  => $row[3],
            'rating'  => $row[4],
            'segmentOfIssuer' => $row[5],
            'ModelYield'    => $row[6],
            'modelPrice' => $row[7],
            'Y15DaysYield'  => $row[8],
            'P15DaysPrice'     => $row[9],
            'finalYield'    => $row[10],
            'finalPrice'    => $row[11],
            'remarks'    => $row[12],
        ]);
    }
}
