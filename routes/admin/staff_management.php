<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StaffController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('staff', StaffController::class);
});

Route::get('staff/trashed', [StaffController::class, 'trashed'])->name('admin.staff.trashed');
Route::post('staff/restore/{id}', [StaffController::class, 'restore'])->name('admin.staff.restore');
