<?php

namespace App\Exports;

use App\Models\Bond;
use App\Models\StateGovtBonds;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StateBondExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return StateGovtBonds::select(
            'id',
            'isin',
            'stateGovt',
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
            'id',
            'isin',
            'stateGovt',
            'nomenclature',
            'dateOfIssue',
            'dateOfMaturity',
            'outStandingStock',
        ];
    }
}
