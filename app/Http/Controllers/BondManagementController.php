<?php

namespace App\Http\Controllers;

use App\Models\Bond;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BondExport;
use App\Exports\CentralBondsExport;
use App\Exports\StateBondExport;
use App\Imports\BondImport;
use App\Imports\CentralBondImport;
use App\Imports\StateBondImport;
use App\Models\CentralGovtBonds;
use App\Models\StateGovtBonds;

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

    //Centeral Govt Bonds


    public function centralGovtBonds()
    {
        $centralBonds = CentralGovtBonds::paginate(10);
        return view('admin.bonds.centralBonds', compact('centralBonds'));
    }

    public function centralGovtBondsUpdate(Request $request, $id)
    {
        $bond = CentralGovtBonds::findOrFail($id);
        $bond->{$request->field} = $request->value;
        $bond->save();

        return response()->json(['success' => true, 'message' => 'Bond updated successfully']);
    }

    public function centralGovtBondsExport()
    {
        return Excel::download(new CentralBondsExport, 'centralBonds.xlsx');
    }

    public function centralGovtBondsImport(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'bondFile' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            // Truncate the existing bonds table before importing new data
            CentralGovtBonds::truncate();

            // Import the bonds data from the uploaded Excel file
            Excel::import(new CentralBondImport, $request->file('bondFile'));

            // Redirect back with success message
            return redirect()->back()->with('success', 'Central Govt Bond data uploaded successfully!');
        } catch (\Exception $e) {
            throw $e;
            // If something goes wrong, flash an error message
            return redirect()->back()->with('error', 'An error occurred while uploading the file.');
        }
    }

    //state govt bonds

    public function stateGovtBonds()
    {
        $stateBonds = StateGovtBonds::paginate(10);
        return view('admin.bonds.stateGovtBonds', compact('stateBonds'));
    }

    public function stateGovtBondsUpdate(Request $request, $id)
    {
        $bond = StateGovtBonds::findOrFail($id);
        $bond->{$request->field} = $request->value;
        $bond->save();

        return response()->json(['success' => true, 'message' => 'Bond updated successfully']);
    }

    public function stateGovtBondsExport()
    {
        return Excel::download(new StateBondExport, 'stateBonds.xlsx');
    }

    public function stateGovtBondsImport(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'bondFile' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            // Truncate the existing bonds table before importing new data
            StateGovtBonds::truncate();

            // Import the bonds data from the uploaded Excel file
            Excel::import(new StateBondImport, $request->file('bondFile'));

            // Redirect back with success message
            return redirect()->back()->with('success', 'State Govt Bond data uploaded successfully!');
        } catch (\Exception $e) {
            throw $e;
            // If something goes wrong, flash an error message
            return redirect()->back()->with('error', 'An error occurred while uploading the file.');
        }
    }
}
