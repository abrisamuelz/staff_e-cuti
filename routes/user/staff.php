<?php

use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\StaffController;

Route::get('/staff/{id}/show', [StaffController::class, 'show'])->middleware(['auth'])->name('staff.show');
Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->middleware(['auth'])->name('staff.edit');
Route::put('/staff/{id}/update', [StaffController::class, 'update'])->middleware(['auth'])->name('staff.update');
