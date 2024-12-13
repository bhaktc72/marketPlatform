<?php

namespace App\Http\Controllers;

use App\Models\Treasure;
use Illuminate\Http\Request;
use Throwable;

class TreasureController extends Controller
{
    public function index()
    {
        try {
            $treasure = Treasure::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.treasure', compact('treasure'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve treasures: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        try {
            // Create new treasure
            $treasure = new Treasure();
            $treasure->tenure = $request->tenure;
            $treasure->rate = $request->rate;
            $treasure->save();

            return redirect()->route('treasure.index')->with('success', 'Treasure added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add trasure: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the trasure by ID
            $treasure = Treasure::findOrFail($id);

            // Update the trasure fields
            $treasure->tenure = $request->input('tenure');
            $treasure->rate = $request->input('rate');

            // Save the updated treasure
            $treasure->save();

            // Return a success response
            return response()->json(['success' => 'Treasure updated successfully.']);
        } catch (\Exception $e) {
            // Return an error response in case of failure
            return response()->json(['error' => 'Failed to update the trasure.'], 500);
        }
    }

    public function destroy($id)
{
    try {
        // Find the trasure by ID
        $treasure = Treasure::findOrFail($id);

        // Delete the trasure
        $treasure->status = 'Deleted';
        $treasure->save();

        // Return success response
        return response()->json(['success' => 'Treasure deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the treasure.'], 500);
    }
}


}
