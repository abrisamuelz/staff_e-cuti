<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StaffController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::post('staff/sync', [StaffController::class, 'staffSync'])->name('staff.sync');
    Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
    
    Route::get('staff/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::get('staff/trashed', [StaffController::class, 'trashed'])->name('staff.trashed');
    Route::post('staff/restore/{id}', [StaffController::class, 'restore'])->name('staff.restore');
});


