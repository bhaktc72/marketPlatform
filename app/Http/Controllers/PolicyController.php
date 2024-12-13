<?php

namespace App\Http\Controllers;

use App\Models\PolicyRate;
use Illuminate\Http\Request;
use Throwable;

class PolicyController extends Controller
{
    public function index()
    {
        try {
            $policy = PolicyRate::where('status', 'Active')->get(); // You can adjust pagination here as needed
            return view('admin.debt.policy', compact('policy'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to retrieve policies: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Create new policy
            $policy = new PolicyRate();
            $policy->policy_facilities = $request->policy_facilities;
            $policy->policy_rate = $request->policy_rate;
            $policy->save();

            return redirect()->route('policies.index')->with('success', 'Policy added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to add policy: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the policy by ID
            $policy = PolicyRate::findOrFail($id);

            // Update the policy fields
            $policy->policy_facilities = $request->input('policy_facilities');
            $policy->policy_rate = $request->input('policy_rate');

            // Save the updated policy
            $policy->save();

            // Return a success response
            return response()->json(['success' => 'Policy updated successfully.']);
        } catch (\Exception $e) {
            // Return an error response in case of failure
            return response()->json(['error' => 'Failed to update the policy.'], 500);
        }
    }

    public function destroy($id)
{
    try {
        // Find the policy by ID
        $policy = PolicyRate::findOrFail($id);

        // Delete the policy
        $policy->status = 'Deleted';
        $policy->save();

        // Return success response
        return response()->json(['success' => 'Policy deleted successfully.']);
    } catch (Throwable $th) {
        // throw $th;
        // Return error response
        return response()->json(['error' => 'Failed to delete the policy.'], 500);
    }
}


}
