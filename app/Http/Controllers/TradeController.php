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
    //     public function executeTrade(Request $request)
    //     {
    //         $request->validate([
    //             // 'bond_id' => 'required',
    //             // 'bond_type' => 'required|in:state,central,security',
    //             // 'trade_type' => 'required|in:buy,sell',
    //             // 'trade_price' => 'required|numeric|min:1',
    //             // 'trade_quantity' => 'required|integer|min:1',
    //         ]);

    //         $bondType = $request->bond_type;
    //         $bondId = $request->bond_id;
    //         $price = $request->trade_price;
    //         $quantity = $request->trade_quantity;
    //         $tradeType = $request->trade_type;
    //         $totalCost = $price * $quantity;

    //         $userBalance = AccountBalance::where('userId', Auth::user()->id)->first();

    //         if (!$userBalance) {
    //             return response()->json(['message' => 'User balance not found!'], 400);
    //         }

    //         DB::beginTransaction();

    //         try {
    //             $buyTable = null;
    //             $sellTable = null;

    //             if ($bondType == "state") {
    //                 $buyTable = new StateBondBuyOrder();
    //                 $sellTable = new StateBondSellOrder();
    //                 $bond = StateGovtBonds::findOrFail($bondId);
    //             } elseif ($bondType == "central") {
    //                 $buyTable = new CentralBondBuyOrder();
    //                 $sellTable = new CentralBondSellOrder();
    //                 $bond = CentralGovtBonds::findOrFail($bondId);
    //             } elseif ($bondType == "security") {
    //                 $buyTable = new BondBuyOrder();
    //                 $sellTable = new BondSellOrder();
    //                 $bond = Bond::findOrFail($bondId);
    //             } else {
    //                 return response()->json(['message' => 'Invalid bond type!'], 400);
    //             }

    //             if ($tradeType == "buy") {
    //                 if ($userBalance->amount < $totalCost) {
    //                     return response()->json(['message' => 'Insufficient balance!'], 400);
    //                 }

    //                 $match = $sellTable::where('bond_id', $bondId)
    //                     ->where('price', '<=', $price)
    //                     ->orderBy('price', 'asc')
    //                     ->first();

    //                 if ($match) {
    //                     $executedQty = min($quantity, $match->quantity);
    //                     $executedCost = $executedQty * $match->price;

    //                     $userBalance->amount -= $executedCost;
    //                     $userBalance->save();

    //                     $sellerBalance = AccountBalance::where('userId', $match->user_id)->first();
    //                     if ($sellerBalance) {
    //                         $sellerBalance->amount += $executedCost;
    //                         $sellerBalance->save();
    //                     }

    //                     $match->quantity -= $executedQty;
    //                     if ($match->quantity == 0) {
    //                         $match->delete();
    //                     } else {
    //                         $match->save();
    //                     }

    //                     $bond = new $buyTable();
    //                     $bond->user_id = Auth::id();
    //                     $bond->bond_id = $bondId;
    //                     $bond->price = $match->price;
    //                     $bond->quantity = $executedQty;
    //                     $bond->save();
    //                 } else {
    //                     $bond = new $buyTable();
    //                     $bond->user_id = Auth::id();
    //                     $bond->bond_id = $bondId;
    //                     $bond->price = $price;
    //                     $bond->quantity = $quantity;
    //                     $bond->save();
    //                 }
    //             } else {
    //                 $match = $buyTable::where('bond_id', $bondId)
    //                     ->where('price', '>=', $price)
    //                     ->orderBy('price', 'desc')
    //                     ->first();

    //                 if ($match) {
    //                     $executedQty = min($quantity, $match->quantity);
    //                     $executedCost = $executedQty * $match->price;

    //                     $userBalance->amount += $executedCost;
    //                     $userBalance->save();

    //                     $buyerBalance = AccountBalance::where('userId', $match->user_id)->first();
    //                     if ($buyerBalance) {
    //                         $buyerBalance->amount -= $executedCost;
    //                         $buyerBalance->save();
    //                     }

    //                     $match->quantity -= $executedQty;
    //                     if ($match->quantity == 0) {
    //                         $match->delete();
    //                     } else {
    //                         $match->save();
    //                     }

    //                     $bond = new $sellTable();
    //                     $bond->user_id = Auth::id();
    //                     $bond->bond_id = $bondId;
    //                     $bond->price = $match->price;
    //                     $bond->quantity = $executedQty;
    //                     $bond->save();
    //                 } else {
    //                     $bond = new $sellTable();
    //                     $bond->user_id = Auth::id();
    //                     $bond->bond_id = $bondId;
    //                     $bond->price = $price;
    //                     $bond->quantity = $quantity;
    //                     $bond->save();
    //                 }
    //             }

    //             DB::commit();
    //             Log::info("Trade Request Data:", $request->all());

    //             return response()->json(['message' => 'Trade executed successfully!']);
    //         } catch (\Exception $e) {
    //             Log::error("Trade execution error: " . $e->getMessage());
    //             DB::rollBack(); // Fix rollback
    //             return response()->json(['message' => 'Trade execution failed!'], 500);
    //         }
    //     }


    // public function executeTrade(Request $request)
    // {
    //     $request->validate([
    //         // Validation rules can be uncommented as per requirement
    //         'bond_id' => 'required',
    //         'bond_type' => 'required|in:state,central,security',
    //         'trade_type' => 'required|in:buy,sell',
    //         'trade_price' => 'required|numeric|min:1',
    //         'trade_quantity' => 'required|integer|min:1',
    //     ]);

    //     $bondType = $request->bond_type;
    //     $bondId = $request->bond_id;
    //     $price = $request->trade_price;
    //     $quantity = $request->trade_quantity;
    //     $tradeType = $request->trade_type;
    //     $totalCost = $price * $quantity;

    //     $userBalance = AccountBalance::where('userId', Auth::user()->id)->first();

    //     if (!$userBalance) {
    //         return response()->json(['message' => 'User balance not found!'], 400);
    //     }

    //     DB::beginTransaction();

    //     try {
    //         $buyTable = null;
    //         $sellTable = null;

    //         if ($bondType == "state") {
    //             $buyTable = new StateBondBuyOrder();
    //             $sellTable = new StateBondSellOrder();
    //             $bond = StateGovtBonds::findOrFail($bondId);
    //         } elseif ($bondType == "central") {
    //             $buyTable = new CentralBondBuyOrder();
    //             $sellTable = new CentralBondSellOrder();
    //             $bond = CentralGovtBonds::findOrFail($bondId);
    //         } elseif ($bondType == "security") {
    //             $buyTable = new BondBuyOrder();
    //             $sellTable = new BondSellOrder();
    //             $bond = Bond::findOrFail($bondId);
    //         } else {
    //             return response()->json(['message' => 'Invalid bond type!'], 400);
    //         }

    //         if ($tradeType == "buy") {
    //             if ($userBalance->amount < $totalCost) {
    //                 return response()->json(['message' => 'Insufficient balance!'], 400);
    //             }

    //             $match = $sellTable::where('bond_id', $bondId)
    //                 ->where('price', '<=', $price)
    //                 ->orderBy('price', 'asc')
    //                 ->first();

    //             if ($match) {
    //                 $executedQty = min($quantity, $match->quantity);
    //                 $executedCost = $executedQty * $match->price;

    //                 $userBalance->amount -= $executedCost;
    //                 $userBalance->save();

    //                 $sellerBalance = AccountBalance::where('userId', $match->user_id)->first();
    //                 if ($sellerBalance) {
    //                     $sellerBalance->amount += $executedCost;
    //                     $sellerBalance->save();
    //                 }

    //                 $match->quantity -= $executedQty;
    //                 if ($match->quantity == 0) {
    //                     $match->delete();
    //                 } else {
    //                     $match->save();
    //                 }

    //                 $bond = new $buyTable();
    //                 $bond->user_id = Auth::id();
    //                 $bond->bond_id = $bondId;
    //                 $bond->price = $match->price;
    //                 $bond->quantity = $executedQty;
    //                 $bond->total_cost = $executedCost; // Storing total cost
    //                 $bond->save();
    //             } else {
    //                 $bond = new $buyTable();
    //                 $bond->user_id = Auth::id();
    //                 $bond->bond_id = $bondId;
    //                 $bond->price = $price;
    //                 $bond->quantity = $quantity;
    //                 $bond->total_cost = $totalCost; // Storing total cost
    //                 $bond->save();
    //             }
    //         } else {
    //             $match = $buyTable::where('bond_id', $bondId)
    //                 ->where('price', '>=', $price)
    //                 ->orderBy('price', 'desc')
    //                 ->first();

    //             if ($match) {
    //                 $executedQty = min($quantity, $match->quantity);
    //                 $executedCost = $executedQty * $match->price;

    //                 $userBalance->amount += $executedCost;
    //                 $userBalance->save();

    //                 $buyerBalance = AccountBalance::where('userId', $match->user_id)->first();
    //                 if ($buyerBalance) {
    //                     $buyerBalance->amount -= $executedCost;
    //                     $buyerBalance->save();
    //                 }

    //                 $match->quantity -= $executedQty;
    //                 if ($match->quantity == 0) {
    //                     $match->delete();
    //                 } else {
    //                     $match->save();
    //                 }

    //                 $bond = new $sellTable();
    //                 $bond->user_id = Auth::id();
    //                 $bond->bond_id = $bondId;
    //                 $bond->price = $match->price;
    //                 $bond->quantity = $executedQty;
    //                 $bond->total_cost = $executedCost; // Storing total cost
    //                 $bond->save();
    //             } else {
    //                 $bond = new $sellTable();
    //                 $bond->user_id = Auth::id();
    //                 $bond->bond_id = $bondId;
    //                 $bond->price = $price;
    //                 $bond->quantity = $quantity;
    //                 $bond->total_cost = $totalCost; // Storing total cost
    //                 $bond->save();
    //             }
    //         }

    //         DB::commit();
    //         Log::info("Trade Request Data:", $request->all());

    //         return response()->json(['message' => 'Trade executed successfully!']);
    //     } catch (\Exception $e) {

    //         Log::error("Trade execution error: " . $e->getMessage());
    //         DB::rollBack();
    //         return response()->json(['message' => 'Trade execution failed!'], 500);
    //     }
    // }

    // public function executeTrade(Request $request)
    // {
    //     $request->validate([
    //         'bond_id' => 'required',
    //         'bond_type' => 'required|in:state,central,security',
    //         'trade_type' => 'required|in:buy,sell',
    //         'trade_price' => 'required|numeric|min:1',
    //         'trade_quantity' => 'required|integer|min:1',
    //     ]);

    //     $bondType = $request->bond_type;
    //     $bondId = $request->bond_id;
    //     $price = $request->trade_price;
    //     $quantity = $request->trade_quantity;
    //     $tradeType = $request->trade_type;

    //     $totalCost = $price * $quantity;
    //     $userBalance = AccountBalance::where('userId', Auth::user()->id)->first();

    //     if (!$userBalance) {
    //         return response()->json(['message' => 'User balance not found!'], 400);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $buyTable = null;
    //         $sellTable = null;

    //         if ($bondType == "state") {
    //             $buyTable = new StateBondBuyOrder();
    //             $sellTable = new StateBondSellOrder();
    //             $bond = StateGovtBonds::findOrFail($bondId);
    //         } elseif ($bondType == "central") {
    //             $buyTable = new CentralBondBuyOrder();
    //             $sellTable = new CentralBondSellOrder();
    //             $bond = CentralGovtBonds::findOrFail($bondId);
    //         } elseif ($bondType == "security") {
    //             $buyTable = new BondBuyOrder();
    //             $sellTable = new BondSellOrder();
    //             $bond = Bond::findOrFail($bondId);
    //         } else {
    //             return response()->json(['message' => 'Invalid bond type!'], 400);
    //         }

    //         if ($tradeType == "buy") {
    //             // Check for a matching sell order
    //             $match = $sellTable::where('bond_id', $bondId)
    //                 ->where('price', '<=', $price)
    //                 ->orderBy('price', 'asc')
    //                 ->first();

    //             if ($match) {
    //                 // Execute trade logic
    //                 $executedQty = min($quantity, $match->quantity);
    //                 $executedCost = $executedQty * $match->price;

    //                 if ($userBalance->amount < $executedCost) {
    //                     return response()->json(['message' => 'Insufficient balance!'], 400);
    //                 }

    //                 // Update buyer's balance
    //                 $userBalance->amount -= $executedCost;
    //                 $userBalance->save();

    //                 // Update seller's balance
    //                 $sellerBalance = AccountBalance::where('userId', $match->user_id)->first();
    //                 if ($sellerBalance) {
    //                     $sellerBalance->amount += $executedCost;
    //                     $sellerBalance->save();
    //                 }

    //                 // Update matched sell order quantity or delete if fully executed
    //                 $match->quantity -= $executedQty;
    //                 if ($match->quantity == 0) {
    //                     $match->delete();
    //                 } else {
    //                     $match->save();
    //                 }

    //                 // Save executed buy order
    //                 $buyOrder = new $buyTable();
    //                 $buyOrder->user_id = Auth::id();
    //                 $buyOrder->bond_id = $bondId;
    //                 $buyOrder->price = $match->price;
    //                 $buyOrder->quantity = $executedQty;
    //                 $buyOrder->total_cost = $executedCost;
    //                 $buyOrder->save();
    //             } else {
    //                 // No match, add to pending orders
    //                 $pendingOrder = new $buyTable();
    //                 $pendingOrder->user_id = Auth::id();
    //                 $pendingOrder->bond_id = $bondId;
    //                 $pendingOrder->price = $price;
    //                 $pendingOrder->quantity = $quantity;
    //                 $pendingOrder->total_cost = $totalCost;
    //                 $pendingOrder->status = 'pending'; // Set status to pending
    //                 $pendingOrder->save();
    //             }
    //         } else {
    //             // Check for a matching buy order
    //             $match = $buyTable::where('bond_id', $bondId)
    //                 ->where('price', '>=', $price)
    //                 ->orderBy('price', 'desc')
    //                 ->first();

    //             if ($match) {
    //                 // Execute trade logic
    //                 $executedQty = min($quantity, $match->quantity);
    //                 $executedCost = $executedQty * $match->price;

    //                 // Update seller's balance
    //                 $userBalance->amount += $executedCost;
    //                 $userBalance->save();

    //                 // Update buyer's balance
    //                 $buyerBalance = AccountBalance::where('userId', $match->user_id)->first();
    //                 if ($buyerBalance) {
    //                     $buyerBalance->amount -= $executedCost;
    //                     $buyerBalance->save();
    //                 }

    //                 // Update matched buy order quantity or delete if fully executed
    //                 $match->quantity -= $executedQty;
    //                 if ($match->quantity == 0) {
    //                     $match->delete();
    //                 } else {
    //                     $match->save();
    //                 }

    //                 // Save executed sell order
    //                 $sellOrder = new $sellTable();
    //                 $sellOrder->user_id = Auth::id();
    //                 $sellOrder->bond_id = $bondId;
    //                 $sellOrder->price = $match->price;
    //                 $sellOrder->quantity = $executedQty;
    //                 $sellOrder->total_cost = $executedCost;
    //                 $sellOrder->save();
    //             } else {
    //                 // No match, add to pending orders
    //                 $pendingOrder = new $sellTable();
    //                 $pendingOrder->user_id = Auth::id();
    //                 $pendingOrder->bond_id = $bondId;
    //                 $pendingOrder->price = $price;
    //                 $pendingOrder->quantity = $quantity;
    //                 $pendingOrder->total_cost = $totalCost;
    //                 $pendingOrder->status = 'pending'; // Set status to pending
    //                 $pendingOrder->save();
    //             }
    //         }

    //         DB::commit();
    //         return response()->json(['message' => 'Trade executed successfully!']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error("Trade execution error: " . $e->getMessage());
    //         return response()->json(['message' => 'Trade execution failed!'], 500);
    //     }
    // }


    public function executeTrade(Request $request)
    {
        $request->validate([
            'bond_id' => 'required',
            'bond_type' => 'required|in:state,central,security',
            'trade_type' => 'required|in:buy,sell',
            'trade_price' => 'required|numeric|min:1',
            'trade_quantity' => 'required|integer|min:1',
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
                $buyTable = StateBondBuyOrder::class;
                $sellTable = StateBondSellOrder::class;
            } elseif ($bondType == "central") {
                $buyTable = CentralBondBuyOrder::class;
                $sellTable = CentralBondSellOrder::class;
            } elseif ($bondType == "security") {
                $buyTable = BondBuyOrder::class;
                $sellTable = BondSellOrder::class;
            } else {
                return response()->json(['message' => 'Invalid bond type!'], 400);
            }

            if ($tradeType === "buy") {
                $match = $sellTable::where('bond_id', $bondId)
                    ->where('price', '<=', $price)
                    ->orderBy('price', 'asc')
                    ->first();

                if ($match) {
                    $executedQty = min($quantity, $match->quantity);
                    $executedCost = $executedQty * $match->price;

                    if ($userBalance->amount < $executedCost) {
                        return response()->json(['message' => 'Insufficient balance!'], 400);
                    }

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

                    $buyOrder = new $buyTable();
                    $buyOrder->user_id = Auth::id();
                    $buyOrder->bond_id = $bondId;
                    $buyOrder->price = $match->price;
                    $buyOrder->quantity = $executedQty;
                    $buyOrder->total_cost = $executedCost;
                    $buyOrder->save();
                } else {
                    $pendingOrder = new $buyTable();
                    $pendingOrder->user_id = Auth::id();
                    $pendingOrder->bond_id = $bondId;
                    $pendingOrder->price = $price;
                    $pendingOrder->quantity = $quantity;
                    $pendingOrder->total_cost = $totalCost;
                    $pendingOrder->status = 'pending';
                    $pendingOrder->save();
                }
            } else if ($tradeType === "sell") {
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

                    $sellOrder = new $sellTable();
                    $sellOrder->user_id = Auth::id();
                    $sellOrder->bond_id = $bondId;
                    $sellOrder->price = $match->price;
                    $sellOrder->quantity = $executedQty;
                    $sellOrder->total_cost = $executedCost;
                    $sellOrder->save();
                } else {
                    $pendingOrder = new $sellTable();
                    $pendingOrder->user_id = Auth::id();
                    $pendingOrder->bond_id = $bondId;
                    $pendingOrder->price = $price;
                    $pendingOrder->quantity = $quantity;
                    $pendingOrder->total_cost = $totalCost;
                    $pendingOrder->status = 'pending';
                    $pendingOrder->save();
                }
            }

            DB::commit();
            return response()->json(['message' => 'Trade executed successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Trade execution failed!'], 500);
        }
    }
}
