<?php

namespace App\Http\Controllers;

use App\Models\NdsCall;
use Illuminate\Http\Request;
use Throwable;

class NdsCallController extends Controller
{
    public function index()
    {
        try {
            $nds = NdsCall::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.ndsCall', compact('nds'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve NdsCalls: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Create new NDS
            $nds = new NdsCall();
            $nds->name = $request->name;
            $nds->rate = $request->rate;
            $nds->save();

            return redirect()->route('nds.index')->with('success', 'Record Calls added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add Nds Calls: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the NDS Call by ID
            $nds = NdsCall::findOrFail($id);

            // Update fields
            $nds->name = $request->input('name');
            $nds->rate = $request->input('rate');

            // Save the updated NDS Call
            $nds->save();

            return response()->json(['success' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update the record. Error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Find the NDS Call by ID
            $nds = NdsCall::findOrFail($id);

            // Mark the record as deleted
            $nds->status = 'Deleted';  // Or you can actually delete with $nds->delete() depending on your use case
            $nds->save();

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Failed to delete the Record. Error: ' . $th->getMessage()], 500);
        }
    }
}
