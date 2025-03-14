<?php 

// app/Helpers/ApiHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ApiHelper
{
    // Function to handle the API request with authentication
    public static function fetchData($route)
    {
        $clientId = config('services.oauth.client_id');
        $clientSecret = config('services.oauth.client_secret');
        $serverUrl = config('services.oauth.server_url');

        // Send the request to the API
        $response = Http::withHeaders([
            'X-Client-ID' => $clientId,
            'X-Client-Secret' => $clientSecret,
        ])->get($serverUrl . '/' . $route);
        
        // Return the response if successful, or null otherwise
        return $response->successful() ? $response->json() : $response->throw();
    }
}
