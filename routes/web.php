<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceDateListController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/attendancedatelist', [AttendanceDateListController::class, 'index'])->name('attendancedatelist');

Route::post('/attendancedatelist', [AttendanceDateListController::class, 'create']);