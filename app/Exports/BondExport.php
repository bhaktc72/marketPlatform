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
            'id',
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
            'status'
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
            'ID',
            'Name',
            'Code',
            'Issuer',
            'Currency',
            'Maturity',
            'Face Value',
            'Coupon',
            'Frequency',
            'Day Count',
            'Price',
            'Status',
        ];
    }
}
