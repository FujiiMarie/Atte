<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/attendancedatelist', [AttendanceController::class, 'datelist'])->name('attendancedatelist');

Route::post('/attendancedatelist', [AttendanceController::class, 'create']);