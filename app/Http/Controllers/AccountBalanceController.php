<?php

namespace App\Http\Controllers;

use App\Models\AccountBalance;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class AccountBalanceController extends Controller
{
    public function index()
    {
        try {
            // Fetch all account balances
            $accounts = AccountBalance::orderBy('created_at', 'desc')->get();
            return view('admin.account.index', compact('accounts'));
        } catch (Throwable $e) {
            return redirect()->back()->withErrors('Failed to retrieve records: ' . $e->getMessage());
        }
    }

    public function generate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $amount = $request->amount;

            // Delete all existing records
            AccountBalance::truncate();

            // Get all active users
            $activeUsers = User::where('status', 'Active')->get();

            // Bulk insert into AccountBalance table
            $data = $activeUsers->map(function ($user) use ($amount) {
                return [
                    'userId' => $user->id,
                    'amount' => $amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            AccountBalance::insert($data->toArray());

            return redirect()->route('accounts.index')->with('success', 'Amount successfully generated for all active users!');
        } catch (Throwable $e) {
            return redirect()->back()->withErrors('Failed to generate amounts: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        try {
            $account = AccountBalance::findOrFail($id);
            $account->amount = $request->amount;
            $account->save();

            return response()->json(['success' => true, 'message' => 'Account updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to update account.']);
        }
    }


    public function deleteAll()
    {
        try {
            AccountBalance::truncate();

            return redirect()->route('accounts.index')->with('success', 'All records deleted successfully.');
        } catch (Throwable $e) {
            return redirect()->back()->withErrors('Failed to delete records: ' . $e->getMessage());
        }
    }
}
