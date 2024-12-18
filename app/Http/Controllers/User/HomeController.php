<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        return view('user.bond.gSec');
    }

    public function gSecDetails()
    {
        return view('user.bond.gSecDetails');
    }

    public function sdl()
    {
        return view('user.bond.sdl');
    }

    public function sdlDetails()
    {
        return view('user.bond.sdlDetails');
    }

    public function govtBond()
    {
        return view('user.bond.govtBond');
    }

    public function govtBondDetails()
    {
        return view('user.bond.govtBondDetails');
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
