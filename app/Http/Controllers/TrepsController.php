<?php

namespace App\Http\Controllers;

use App\Models\BasketRepo;
use App\Models\Treps;
use Illuminate\Http\Request;
use Throwable;

class TrepsController extends Controller
{
    public function index()
    {
        try {
            $treps = Treps::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.treps', compact('treps'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        try {
            // Create new basket
            $treps = new Treps();
            $treps->name = $request->name;
            $treps->rate = $request->rate;
            $treps->save();

            return redirect()->route('treps.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the basket by ID
            $treps = Treps::findOrFail($id);

            // Update the treps fields
            $treps->name = $request->input('name');
            $treps->rate = $request->input('rate');

            // Save the updated treps
            $treps->save();

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
        // Find the treps by ID
        $treps = Treps::findOrFail($id);

        // Delete the treps
        $treps->status = 'Deleted';
        $treps->save();

        // Return success response
        return response()->json(['success' => 'Record deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the record.'], 500);
    }
}


}
