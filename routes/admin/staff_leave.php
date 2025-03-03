<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StaffLeaveBalanceController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('staff-leaves', StaffLeaveBalanceController::class);
});
