<?php

namespace App\Exports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BondExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Bond::select(
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
            'remarks'
        )->get();
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ISIN',
            'Issuer',
            'Coupon Rate',
            'Maturity Date',
            'Rating',
            'Segment of Issuer',
            'Model Yield',
            'Model Price',
            '15 Days Yield',
            '15 Days Price',
            'Final Yield',
            'Final Price',
            'Remarks'
        ];
    }
}
