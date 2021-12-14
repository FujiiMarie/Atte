<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WokerController extends Controller
{
    public function index()
    {
        return view('wokers.home');
    }
}
