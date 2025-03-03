<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\LeaveConfigController;

Route::prefix('admin/leave-management')->name('admin.leave-management.')->middleware(['auth'])->group(function () {

    // Main Page - Combined Listing (Leave Types + Leave Configs)
    Route::get('/', [LeaveTypeController::class, 'index'])->name('index');
    // Leave Types CRUD (without index because index is above)
    Route::resource('leave-types', LeaveTypeController::class)->except(['index','destroy']);
    // Leave Configs CRUD (leave-configs does not have combined index)
    Route::resource('leave-configs', LeaveConfigController::class)->except(['index','destroy']);
});
