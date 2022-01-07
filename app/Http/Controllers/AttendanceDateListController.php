<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceDateListController extends Controller
{
    public function index(){
        return view('attendancedatelist');
    }
}
