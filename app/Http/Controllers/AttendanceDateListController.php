<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceDateListController extends Controller
{
    public function index(){
        $items = DB::select('select * from users');
        return view('attendancedatelist', ['items' => $items]);
    }
    public function create(){
        return view('');
    }
}