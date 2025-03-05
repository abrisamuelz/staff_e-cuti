<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});


require_once __DIR__ . '/admin/staff_management.php';
require_once __DIR__ . '/admin/user_management.php';
require_once __DIR__ . '/admin/leave_management.php';


require_once __DIR__ . '/user/dashboard.php';
// require_once __DIR__ . '/user/staff.php';

require_once __DIR__ . '/auth-sso.php';

