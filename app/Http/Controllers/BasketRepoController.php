<?php

namespace App\Http\Controllers;

use App\Models\BasketRepo;
use Illuminate\Http\Request;
use Throwable;

class BasketRepoController extends Controller
{
    public function index()
    {
        try {
            $basket = BasketRepo::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.basketRepo', compact('basket'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        try {
            // Create new basket
            $basket = new BasketRepo();
            $basket->basketName = $request->basketName;
            $basket->war = $request->war;
            $basket->save();

            return redirect()->route('basketRepo.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the basket by ID
            $basket = BasketRepo::findOrFail($id);

            // Update the basket fields
            $basket->basketName = $request->input('basketName');
            $basket->war = $request->input('war');

            // Save the updated basket
            $basket->save();

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
        // Find the basket by ID
        $basket = BasketRepo::findOrFail($id);

        // Delete the basket
        $basket->status = 'Deleted';
        $basket->save();

        // Return success response
        return response()->json(['success' => 'Record deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the record.'], 500);
    }
}


}
