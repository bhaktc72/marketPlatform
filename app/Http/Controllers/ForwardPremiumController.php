<?php

namespace App\Http\Controllers;

use App\Models\ForwardPremium;
use App\Models\Fx;
use Illuminate\Http\Request;
use Throwable;

class ForwardPremiumController extends Controller
{
    public function index()
    {
        try {
            $forwardPremium = ForwardPremium::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.foreignExchange.forwardPremium', compact('forwardPremium'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        try {
            // Create new basket
            $forwardPremium = new ForwardPremium();
            $forwardPremium->tenor = $request->tenor;
            $forwardPremium->rate_percentage = $request->rate_percentage;
            $forwardPremium->rate = $request->rate;
            $forwardPremium->save();

            return redirect()->route('forwardPremium.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the basket by ID
            $forwardPremium = ForwardPremium::findOrFail($id);

            // Update the forwardPremium fields
            $forwardPremium->tenor = $request->input('tenor');
            $forwardPremium->rate_percentage = $request->rate_percentage;
            $forwardPremium->rate = $request->rate;

            // Save the updated forwardPremium
            $forwardPremium->save();

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
        // Find the forwardPremium by ID
        $forwardPremium = ForwardPremium::findOrFail($id);

        // Delete the forwardPremium
        $forwardPremium->status = 'Deleted';
        $forwardPremium->save();

        // Return success response
        return response()->json(['success' => 'Record deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the record.'], 500);
    }
}


}
