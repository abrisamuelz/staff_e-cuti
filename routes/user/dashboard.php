<?php

use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');