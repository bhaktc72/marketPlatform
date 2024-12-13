<?php

namespace App\Imports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;

class BondImport implements ToModel
{
    public function model(array $row)
    {
        return new Bond([
            'name'      => $row[0],
            'code'      => $row[1],
            'issuer'    => $row[2],
            'currency'  => $row[3],
            'maturity'  => $row[4],
            'face_value' => $row[5],
            'coupon'    => $row[6],
            'frequency' => $row[7],
            'day_count'  => $row[8],
            'price'     => $row[9],
            'status'    => $row[10],
        ]);
    }
}
