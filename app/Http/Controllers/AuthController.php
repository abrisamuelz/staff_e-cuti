<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Step 1: Redirect the user to System A’s OAuth server for login.
     */
    public function redirectToProvider()
    {
        //check if user is already logged in, if so, log them out
        if (Auth::check()) {
            Auth::logout();
        }
        // Build the query parameters for /oauth/authorize in System A
        $query = http_build_query([
            'client_id'     => config('services.oauth.client_id'),
            'redirect_uri'  => config('services.oauth.redirect_uri'),
            'response_type' => 'code',
            'scope'         => '', // Add scopes here if needed
        ]);

        // Send user to System A’s /oauth/authorize
        return redirect(config('services.oauth.server_url') . '/oauth/authorize?' . $query);
    }

    /**
     * Step 2: Handle the callback from System A.
     *         Exchange authorization code for an access token,
     *         then fetch user info from System A to log in locally.
     */
    public function handleProviderCallback(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            Log::error('SSO callback error: missing authorization code.');
            return redirect('/')->withErrors('Authorization code not provided.');
        }

        // Exchange the authorization code for an access token.
        $tokenResponse = Http::asForm()->post(
            config('services.oauth.server_url') . '/oauth/token',
            [
                'grant_type'    => 'authorization_code',
                'client_id'     => config('services.oauth.client_id'),
                'client_secret' => config('services.oauth.client_secret'),
                'redirect_uri'  => config('services.oauth.redirect_uri'),
                'code'          => $code,
            ]
        );

        $tokenData = $tokenResponse->json();

        if (!isset($tokenData['access_token'])) {
            Log::error('Token exchange error', [
                'tokenData' => $tokenData,
                'status'    => $tokenResponse->status(),
                'body'      => $tokenResponse->body(),
            ]);
            return redirect('/')
                ->withErrors($tokenData['error_description'] ?? 'Unable to authenticate with SSO server.');
        }

        $accessToken = $tokenData['access_token'];

        try {
            $userResponse = Http::withToken($accessToken)
                ->withCookies([], parse_url(config('services.oauth.server_url'), PHP_URL_HOST))
                ->withHeaders(['Accept' => 'application/json'])
                ->timeout(3)
                ->retry(2, 100)
                ->get(config('services.oauth.server_url') . '/api/user');
        } catch (\Exception $e) {
            Log::error('Login failed', [
                'message' => $e->getMessage(),
            ]);
            return redirect('/')->withErrors('Unable to fetch user data from SSO server.');
        }

        if ($userResponse->failed()) {
            Log::error('Fetching user data failed', [
                'status' => $userResponse->status(),
                'body'   => $userResponse->body(),
            ]);
            return redirect('/')->withErrors('Unable to fetch user data from SSO server.');
        }

        $oauthUser = $userResponse->json();

        // Handle profile image:
        // Assume the SSO system sends a base64-encoded image string in 'profile_photo_path'
        // which might be prefixed with data URI scheme information (e.g. "data:image/png;base64,...")
        if (!empty($oauthUser['profile_photo_path'])) {
            $base64Image = $oauthUser['profile_photo_path'];
            $extension = 'png'; // default extension

            // Check if the string contains a data URI prefix.
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                $extension = strtolower($matches[1]);
                // Remove the data URI prefix
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            }

            // Decode the base64 string.
            $image = base64_decode($base64Image);

            if ($image === false) {
                // Decoding failed; fall back to a default avatar.
                $profilePhotoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($oauthUser['name'] ?? 'User') . '&color=7F9CF5&background=EBF4FF';
            } else {
                // Ensure the directory exists.
                $directory = storage_path('app/public/profiles');
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Generate a unique filename based on the user's email.
                $imageName = 'profile-' . md5($oauthUser['email']) . '.' . $extension;
                $path = $directory . '/' . $imageName;

                // Save the image file.
                file_put_contents($path, $image);

                // Build the public URL for the stored image.
                $profilePhotoUrl = 'profiles/' . $imageName;
            }
        } else {
            // Use a default avatar if no image data is provided.
            $profilePhotoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($oauthUser['name'] ?? 'User') . '&color=7F9CF5&background=EBF4FF';
        }

        // Update or create the local user in System B.
        $user = User::updateOrCreate(
            ['email' => $oauthUser['email']],
            [
                'name'               => $oauthUser['name'] ?? '',
                'role'               => $oauthUser['role'] ?? 'user',
                'profile_photo_path' => $profilePhotoUrl,
            ]
        );

        // Log::info('Data Fetch', [
        //     'user_saved'    => $user,
        //     'oauthUser_get' => $oauthUser,
        //     'profile_url'   => $profilePhotoUrl,
        // ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
