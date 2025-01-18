<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\CentralGovtBonds;
use App\Models\StateGovtBonds;
use Illuminate\Http\Request;

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

        return view('user.bond.gSecDetails', compact('bond'));
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

        return view('user.bond.sdlDetails', compact('stateBond'));
    }


    public function govtBond()
    {
        $govtBonds = CentralGovtBonds::all();
        return view('user.bond.govtBond', compact('govtBonds'));
    }

    public function govtBondDetails($id)
    {
        // Fetch the government bond by its ID
        $govtBond = CentralGovtBonds::findOrFail($id);

        return view('user.bond.govtBondDetails', compact('govtBond'));
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
        return view('user.bond.orderBook');
    }
    public function orderModify()
    {
        return view('user.bond.orderModify');
    }

    public function myOrders()
    {
        return view('user.bond.myOrders');
    }
}
