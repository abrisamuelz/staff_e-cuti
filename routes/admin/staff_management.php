<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StaffController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::post('staff/sync', [StaffController::class, 'staffSync'])->name('staff.sync');
    Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('staff/{id}', [StaffController::class, 'show'])->name('staff.show');
});


