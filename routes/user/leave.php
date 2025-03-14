<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LeaveController;

Route::middleware(['auth'])->group(function () {
    Route::get('/leave', [LeaveController::class, 'index'])->name('user.leave.index');
    Route::post('/leave/apply', [LeaveController::class, 'apply'])->name('user.leave.apply');
    Route::get('/leave/pending', [LeaveController::class, 'pending'])->name('user.leave.pending');
    Route::post('/leave/approve/{id}', [LeaveController::class, 'approve'])->name('user.leave.approve');
    Route::post('/leave/reject/{id}', [LeaveController::class, 'reject'])->name('user.leave.reject');
});
