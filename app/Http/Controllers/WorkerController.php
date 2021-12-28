<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $param = ['user' =>$user];
        return view('workers.home');
    }
}
