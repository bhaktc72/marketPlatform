<?php

namespace App\Http\Controllers;

use App\Models\Bond;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BondExport;
use App\Imports\BondImport;

class BondManagementController extends Controller
{
    public function index()
    {
        $bonds = Bond::paginate(10); // Paginate results
        return view('admin.bonds.index', compact('bonds'));
    }

    public function update(Request $request, $id)
    {
        $bond = Bond::findOrFail($id);
        $bond->{$request->field} = $request->value;
        $bond->save();

        return response()->json(['success' => true, 'message' => 'Bond updated successfully']);
    }

    public function export()
    {
        return Excel::download(new BondExport, 'bonds.xlsx');
    }

   public function import(Request $request)
{
    try {
        // Validate the uploaded file
        $request->validate([
            'bondFile' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Truncate the existing bonds table before importing new data
        Bond::truncate();

        // Import the bonds data from the uploaded Excel file
        Excel::import(new BondImport, $request->file('bondFile'));

        // Redirect back with success message
        return redirect()->back()->with('success', 'Bond data uploaded successfully!');
    } catch (\Exception $e) {
        // If something goes wrong, flash an error message
        return redirect()->back()->with('error', 'An error occurred while uploading the file.');
    }
}

}
