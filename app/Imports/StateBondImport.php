<?php

namespace App\Imports;

use App\Models\StateGovtBonds;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StateBondImport implements ToModel
{
    public function model(array $row)
    {
        return new StateGovtBonds([
            'isin'             => $row[0],
            'stateGovt'             => $row[1],
            'nomenclature'     => $row[2],
            'dateOfIssue'      => $this->transformDate($row[3]), // Handle dateOfIssue
            'dateOfMaturity'   => $this->transformDate($row[4]), // Handle dateOfMaturity
            'outStandingStock' => $row[5],
        ]);
    }

    /**
     * Transform date from string to Carbon instance.
     */
    private function transformDate($value)
    {
        if (empty($value)) {
            return null; // Handle empty value
        }

        try {
            // Check if the value is an Excel serial date (numeric)
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            // Attempt to parse a formatted date string
            return Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            // Log the error for debugging and return null
            Log::error('Date parsing failed: ' . $value . ' - Error: ' . $e->getMessage());
            return null;
        }
    }
}
