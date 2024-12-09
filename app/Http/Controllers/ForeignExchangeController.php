<?php

namespace App\Http\Controllers;

use App\Models\Fx;
use Illuminate\Http\Request;
use Throwable;

class ForeignExchangeController extends Controller
{
    public function index()
    {
        try {
            $foreignExchange = Fx::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.foreignExchange.fxChange', compact('foreignExchange'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        try {
            // Create new basket
            $foreignExchange = new Fx();
            $foreignExchange->name = $request->name;
            $foreignExchange->rate = $request->rate;
            $foreignExchange->save();

            return redirect()->route('foreignExchange.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the basket by ID
            $foreignExchange = Fx::findOrFail($id);

            // Update the foreignExchange fields
            $foreignExchange->name = $request->input('name');
            $foreignExchange->rate = $request->input('rate');

            // Save the updated foreignExchange
            $foreignExchange->save();

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
        // Find the foreignExchange by ID
        $foreignExchange = Fx::findOrFail($id);

        // Delete the foreignExchange
        $foreignExchange->status = 'Deleted';
        $foreignExchange->save();

        // Return success response
        return response()->json(['success' => 'Record deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the record.'], 500);
    }
}


}
