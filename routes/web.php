<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         $staff = 
//         $viewData = [
//             'title' => 'Dashboard',
//             'active' => 'dashboard',
//         ];
//         return view('dashboard');
//     })->name('dashboard');
// });

require_once __DIR__ . '/admin/staff_management.php';

require_once __DIR__ . '/user/dashboard.php';
require_once __DIR__ . '/user/staff.php';

