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
}
