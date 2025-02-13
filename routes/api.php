<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/sso/logout', function(Request $request) {
    // Extract the user ID and signature from the request.
    $userId    = $request->input('user_id');
    $signature = $request->input('signature');

    // Get the shared secret (must match System A's configuration)
    $secret = config('sso.shared_logout_secret');

    // Recreate the expected signature from the payload.
    $expectedSignature = hash_hmac('sha256', json_encode(['user_id' => $userId]), $secret);

    // Verify the signature
    if (!hash_equals($expectedSignature, $signature)) {
        Log::warning("System B: Invalid back-channel logout signature", ['user_id' => $userId]);
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // Log out the user if the session is active.
    if (Auth::check() && Auth::id() == $userId) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info("System B: Back-channel logout successful for user {$userId}");
    } else {
        Log::info("System B: No active session for user {$userId} during back-channel logout");
    }

    return response()->json(['message' => 'Logged out successfully'], 200);
})->name('sso.logout');


