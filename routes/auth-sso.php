<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'redirectToProvider'])->name('login');
Route::get('/oauth/callback', [AuthController::class, 'handleProviderCallback']);

// Redirect registration requests to System SSO.
Route::get('register', function () {
    return redirect(config('services.oauth.server_url') . '/register');
})->name('register');

// Route::get('/local-logout', function () {
//     Auth::logout();
//     return redirect('/');
// })->name('local.logout');

Route::get('/local-logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return view('auth/local-logout');
})->name('local.logout');