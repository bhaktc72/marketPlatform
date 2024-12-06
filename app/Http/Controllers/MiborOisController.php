<?php

namespace App\Http\Controllers;

use App\Models\MiborOis;
use Illuminate\Http\Request;
use Throwable;

class MiborOisController extends Controller
{
    public function index()
    {
        try {
            $mibor = MiborOis::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.miborOis', compact('mibor'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Create new mibor
            $mibor = new MiborOis();
            $mibor->timeline = $request->timeline;
            $mibor->rate = $request->rate;
            $mibor->save();

            return redirect()->route('mibor.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the mibor by ID
            $mibor = MiborOis::findOrFail($id);

            // Update the mibor fields
            $mibor->timeline = $request->input('timeline');
            $mibor->rate = $request->input('rate');

            // Save the updated mibor
            $mibor->save();

            // Return a success response
            return response()->json(['success' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            // Return an error response in case of failure
            return response()->json(['error' => 'Failed to update the record.'], 500);
        }
    }

    public function destroy($id)
{
    try {
        // Find the mibor by ID
        $mibor = MiborOis::findOrFail($id);

        // Delete the mibor
        $mibor->status = 'Deleted';
        $mibor->save();

        // Return success response
        return response()->json(['success' => 'Record deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the record.'], 500);
    }
}


}
