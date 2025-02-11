<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        return view('user.home');
    }

    public function bonds()
    {
        return view('user.bond.index');
    }

    public function gSec()
    {
        $bonds = Bond::all();
        return view('user.bond.gSec', compact('bonds'));
    }

    public function gSecDetails($id)
    {
        // Fetch the bond by its ID
        $bond = Bond::findOrFail($id);
        $bondBuy = BondBuyOrder::where('bond_id', $id)->get();
        $bondSell = BondSellOrder::where('bond_id', $id)->get();


        return view('user.bond.gSecDetails', compact('bond', 'bondBuy', 'bondSell'));
    }


    public function sdl()
    {
        $stateBond = StateGovtBonds::all();
        return view('user.bond.sdl', compact('stateBond'));
    }

    public function sdlDetails($id)
    {
        // Fetch the state bond by its ID
        $stateBond = StateGovtBonds::findOrFail($id);
        $stateBuy = StateBondBuyOrder::where('bond_id', $id)->get();
        $stateSell = StateBondSellOrder::where('bond_id', $id)->get();

        return view('user.bond.sdlDetails', compact('stateBond', 'stateBuy', 'stateSell'));
    }


    public function govtBond()
    {
        $govtBonds = CentralGovtBonds::all();
        return view('user.bond.govtBond', compact('govtBonds'));
    }

    public function govtBondDetails($id)
    {
        // Fetch the government bond by its ID
        $centralGovtBond = CentralGovtBonds::findOrFail($id);
        $centralBuy = CentralBondBuyOrder::where('bond_id', $id)->get();
        $centralSell = CentralBondSellOrder::where('bond_id', $id)->get();

        return view('user.bond.govtBondDetails', compact('centralBuy', 'centralSell', 'centralGovtBond'));
    }


    public function buy()
    {
        return view('user.bond.buy');
    }
    public function sell()
    {
        return view('user.bond.sell');
    }

    public function orderBook()
    {
        $userId = Auth::id();

        $buyOrders = BondBuyOrder::where('user_id', $userId)->where('status', 'pending')->get();
        $stateBuyOrders = StateBondBuyOrder::where('user_id', $userId)->where('status', 'pending')->get();
        $centralBuyOrders = CentralBondBuyOrder::where('user_id', $userId)->where('status', 'pending')->get();
        $sellOrders = BondSellOrder::where('user_id', $userId)->where('status', 'pending')->get();
        $stateSellOrders = StateBondSellOrder::where('user_id', $userId)->where('status', 'pending')->get();
        $centralSellOrders = CentralBondSellOrder::where('user_id', $userId)->where('status', 'pending')->get();

        return view('user.bond.orderBook', compact('buyOrders', 'sellOrders', 'stateBuyOrders', 'stateSellOrders', 'centralBuyOrders', 'centralSellOrders'));
    }
    public function orderModify()
    {
        return view('user.bond.orderModify');
    }

    public function myOrders()
    {
        $userId = Auth::id();

        $buyOrders = BondBuyOrder::where('user_id', $userId)->get();
        $stateBuyOrders = StateBondBuyOrder::where('user_id', $userId)->get();
        $centralBuyOrders = CentralBondBuyOrder::where('user_id', $userId)->get();
        $sellOrders = BondSellOrder::where('user_id', $userId)->get();
        $stateSellOrders = StateBondSellOrder::where('user_id', $userId)->get();
        $centralSellOrders = CentralBondSellOrder::where('user_id', $userId)->get();

        return view('user.bond.myOrders', compact('buyOrders', 'sellOrders', 'stateBuyOrders', 'stateSellOrders', 'centralBuyOrders', 'centralSellOrders'));
    }

    public function modifyOrder(Request $request, $type, $bondType, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
        ]);

        // Determine the correct model for buy or sell order
        $orderClass = $this->getOrderClass($type, 'buy');
        $order = $orderClass::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }

        // Update the order
        $order->price = $request->price;
        $order->quantity = $request->quantity;
        $order->save();

        return response()->json(['message' => 'Order modified successfully!']);
    }

    public function cancelOrder($type, $bondType, $id)
    {
        // Determine the correct model for buy or sell order
        $orderClass = $this->getOrderClass($type, 'sell');
        $order = $orderClass::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }

        // Delete the order
        $order->delete();

        return response()->json(['message' => 'Order canceled successfully!']);
    }


    private function getOrderClass($type, $action)
    {
        $tableMapping = [
            'buy' => [
                'generic' => BondBuyOrder::class,
                'state' => StateBondBuyOrder::class,
                'central' => CentralBondBuyOrder::class,
            ],
            'sell' => [
                'generic' => BondSellOrder::class,
                'state' => StateBondSellOrder::class,
                'central' => CentralBondSellOrder::class,
            ]
        ];

        if (!array_key_exists($type, $tableMapping[$action])) {
            abort(404, 'Invalid bond type.');
        }

        return $tableMapping[$action][$type];
    }
}
