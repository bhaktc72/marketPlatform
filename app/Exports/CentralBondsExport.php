<?php

namespace App\Exports;

use App\Models\Bond;
use App\Models\CentralGovtBonds;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CentralBondsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CentralGovtBonds::select(
            'isin',
            'nomenclature',
            'dateOfIssue',
            'dateOfMaturity',
            'outStandingStock',
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
            'isin',
            'nomenclature',
            'dateOfIssue',
            'dateOfMaturity',
            'outStandingStock',
        ];
    }
}
