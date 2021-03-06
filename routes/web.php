<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/attendanceregister', function () {
    return view('attendanceregister');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function() {
  
    Route::get('/', [AttendanceController::class, 'index'])->name('dashboard');
    Route::post('/start_attendance', [AttendanceController::class, 'start_attendance']);
    Route::post('/end_attendance', [AttendanceController::class, 'end_attendance']);
    Route::post('/start_rest', [AttendanceController::class, 'start_rest']);
    Route::post('/end_rest', [AttendanceController::class, 'end_rest']);

    Route::get('/attendancedatelist', [AttendanceController::class, 'datelist'])->name('attendancedatelist');
    Route::post('/attendancedatelist', [AttendanceController::class, 'other_day'])->name('attendancedatelist');

});