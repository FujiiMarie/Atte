<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/attendanceregister', function () {
    return view('attendanceregister');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [AttendanceController::class, 'index'])->name('dashboard');
Route::get('/start_attendance', [AttendanceController::class, 'start_attendance']);
Route::get('/end_attendance', [AttendanceController::class, 'end_attendance']);
Route::get('/start_rest', [AttendanceController::class, 'start_rest']);
Route::get('/end_rest', [AttendanceController::class, 'end_rest']);

Route::get('/attendancedatelist', [AttendanceController::class, 'datelist'])->name('attendancedatelist');