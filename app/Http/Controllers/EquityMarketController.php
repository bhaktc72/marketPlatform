<?php

namespace App\Http\Controllers;

use App\Models\EquityMarket;
use App\Models\Fx;
use Illuminate\Http\Request;
use Throwable;

class EquityMarketController extends Controller
{
    public function index()
    {
        try {
            $equityMarket = EquityMarket::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.equityMarket.index', compact('equityMarket'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        try {
            // Create new basket
            $equityMarket = new EquityMarket();
            $equityMarket->name = $request->name;
            $equityMarket->rate = $request->rate;
            $equityMarket->save();

            return redirect()->route('equityMarket.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $equityMarket = EquityMarket::findOrFail($id);

            $equityMarket->name = $request->input('name');
            $equityMarket->rate = $request->input('rate');

            $equityMarket->save();

            return response()->json(['success' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update the record.'], 500);
        }
    }

    public function destroy($id)
{
    try {
        $equityMarket = EquityMarket::findOrFail($id);

        $equityMarket->status = 'Deleted';
        $equityMarket->save();

        return response()->json(['success' => 'Record deleted successfully.']);
    } catch (Throwable $th) {
        return response()->json(['error' => 'Failed to delete the record.'], 500);
    }
}


}
