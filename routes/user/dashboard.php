<?php

use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;

// Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
//     Route::resource('user', DashboardController::class);
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         // get staff where email_personal or email_work is same as the logged in user's email
//         $staff = Staff::where('email_personal', auth()->user()->email)
//             ->orWhere('email_company', auth()->user()->email)
//             ->get();

//         $viewData = [
//             'staff' => $staff,
//         ];
//         return view('dashboard', $viewData);
//     })->name('dashboard');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');