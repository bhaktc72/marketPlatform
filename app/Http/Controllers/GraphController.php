<?php

namespace App\Http\Controllers;

use App\Models\MarketGraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GraphController extends Controller
{
    public function index()
    {
        try {
            $graphs = MarketGraph::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.graphs', compact('graphs'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            // $request->validate([
            //     'graphImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ]);

            // Create new graphs
            $graphs = new MarketGraph();

            if ($request->graphImage) {
                $graphs->graphImage = time() . '.' . $request->graphImage->extension();
                $request->graphImage->move(public_path('graphImage'), $graphs->graphImage);
            }

            $graphs->save();

            return redirect()->route('marketGraph.index')->with('success', 'Record added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add record: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $graphs = MarketGraph::findOrFail($id);

            if ($graphs->graphImage) {
                Storage::delete('public/' . $graphs->graphImage);
            }

            $graphs->status = 'Deleted';
            $graphs->save();

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (Throwable $th) {
            return response()->json(['error' => 'Failed to delete the record.'], 500);
        }
    }
}
