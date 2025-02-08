<?php

namespace App\Http\Controllers;

use App\Models\AccountBalance;
use App\Models\Bond;
use App\Models\BondBuyOrder;
use App\Models\BondSellOrder;
use App\Models\CentralBondBuyOrder;
use App\Models\CentralBondSellOrder;
use App\Models\CentralGovtBonds;
use App\Models\StateBondBuyOrder;
use App\Models\StateBondSellOrder;
use App\Models\StateGovtBonds;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;

class TradeController extends Controller
{
    public function executeTrade(Request $request)
    {
        $request->validate([
            // 'bond_id' => 'required',
            // 'bond_type' => 'required|in:state,central,security',
            // 'trade_type' => 'required|in:buy,sell',
            // 'trade_price' => 'required|numeric|min:1',
            // 'trade_quantity' => 'required|integer|min:1',
        ]);

        $bondType = $request->bond_type;
        $bondId = $request->bond_id;
        $price = $request->trade_price;
        $quantity = $request->trade_quantity;
        $tradeType = $request->trade_type;
        $totalCost = $price * $quantity;

        $userBalance = AccountBalance::where('userId', Auth::user()->id)->first();

        if (!$userBalance) {
            return response()->json(['message' => 'User balance not found!'], 400);
        }

        DB::beginTransaction();

        try {
            $buyTable = null;
            $sellTable = null;

            if ($bondType == "state") {
                $buyTable = new StateBondBuyOrder();
                $sellTable = new StateBondSellOrder();
                $bond = StateGovtBonds::findOrFail($bondId);
            } elseif ($bondType == "central") {
                $buyTable = new CentralBondBuyOrder();
                $sellTable = new CentralBondSellOrder();
                $bond = CentralGovtBonds::findOrFail($bondId);
            } elseif ($bondType == "security") {
                $buyTable = new BondBuyOrder();
                $sellTable = new BondSellOrder();
                $bond = Bond::findOrFail($bondId);
            } else {
                return response()->json(['message' => 'Invalid bond type!'], 400);
            }

            if ($tradeType == "buy") {
                if ($userBalance->amount < $totalCost) {
                    return response()->json(['message' => 'Insufficient balance!'], 400);
                }

                $match = $sellTable::where('bond_id', $bondId)
                    ->where('price', '<=', $price)
                    ->orderBy('price', 'asc')
                    ->first();

                if ($match) {
                    $executedQty = min($quantity, $match->quantity);
                    $executedCost = $executedQty * $match->price;

                    $userBalance->amount -= $executedCost;
                    $userBalance->save();

                    $sellerBalance = AccountBalance::where('userId', $match->user_id)->first();
                    if ($sellerBalance) {
                        $sellerBalance->amount += $executedCost;
                        $sellerBalance->save();
                    }

                    $match->quantity -= $executedQty;
                    if ($match->quantity == 0) {
                        $match->delete();
                    } else {
                        $match->save();
                    }

                    $bond = new $buyTable();
                    $bond->user_id = Auth::id();
                    $bond->bond_id = $bondId;
                    $bond->price = $match->price;
                    $bond->quantity = $executedQty;
                    $bond->save();
                } else {
                    $bond = new $buyTable();
                    $bond->user_id = Auth::id();
                    $bond->bond_id = $bondId;
                    $bond->price = $price;
                    $bond->quantity = $quantity;
                    $bond->save();
                }
            } else {
                $match = $buyTable::where('bond_id', $bondId)
                    ->where('price', '>=', $price)
                    ->orderBy('price', 'desc')
                    ->first();

                if ($match) {
                    $executedQty = min($quantity, $match->quantity);
                    $executedCost = $executedQty * $match->price;

                    $userBalance->amount += $executedCost;
                    $userBalance->save();

                    $buyerBalance = AccountBalance::where('userId', $match->user_id)->first();
                    if ($buyerBalance) {
                        $buyerBalance->amount -= $executedCost;
                        $buyerBalance->save();
                    }

                    $match->quantity -= $executedQty;
                    if ($match->quantity == 0) {
                        $match->delete();
                    } else {
                        $match->save();
                    }

                    $bond = new $sellTable();
                    $bond->user_id = Auth::id();
                    $bond->bond_id = $bondId;
                    $bond->price = $match->price;
                    $bond->quantity = $executedQty;
                    $bond->save();
                } else {
                    $bond = new $sellTable();
                    $bond->user_id = Auth::id();
                    $bond->bond_id = $bondId;
                    $bond->price = $price;
                    $bond->quantity = $quantity;
                    $bond->save();
                }
            }

            DB::commit();
            Log::info("Trade Request Data:", $request->all());

            return response()->json(['message' => 'Trade executed successfully!']);
        } catch (\Exception $e) {
            Log::error("Trade execution error: " . $e->getMessage());
            DB::rollBack(); // Fix rollback
            return response()->json(['message' => 'Trade execution failed!'], 500);
        }
    }
}
