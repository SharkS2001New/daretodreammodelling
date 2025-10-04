<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TikTokController extends Controller
{
    public function redirect()
    {
        $clientId = config('services.tiktok.client_id');
        $redirectUri = config('services.tiktok.redirect_uri');
        
        // Validate configuration
        if (!$clientId || !$redirectUri) {
            return redirect()->route('account.linked')
                ->with('error', 'TikTok configuration error. Please contact administrator.');
        }

        // Use only the BASIC scopes that are commonly approved
        $scopes = [
            'user.info.basic',  // Basic user profile
            'video.list',       // List user videos
        ];
        
        $scope = implode(',', $scopes);
        $state = csrf_token();

        // Build the authorization URL properly
        $authUrl = "https://www.tiktok.com/v2/auth/authorize/" .
                   "?client_key=" . urlencode($clientId) .
                   "&scope=" . urlencode($scope) .
                   "&response_type=code" .
                   "&redirect_uri=" . urlencode($redirectUri) .
                   "&state=" . urlencode($state);
        
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');
        $error = $request->input('error');
        $errorDescription = $request->input('error_description');

        // Handle authorization errors
        if ($error) {
            $errorMessage = match($error) {
                'access_denied' => 'You denied access to your TikTok account. Please grant all requested permissions.',
                'invalid_scope' => 'Invalid scope requested. Please try again.',
                'invalid_client' => 'Invalid app configuration. Please contact administrator.',
                default => 'TikTok authorization failed: ' . ($errorDescription ?? $error)
            };
            
            return redirect()->route('account.linked')
                ->with('error', $errorMessage);
        }

        if (!$code) {
            return redirect()->route('account.linked')
                ->with('error', 'Failed to connect TikTok account. No authorization code received.');
        }

        // Validate state parameter for CSRF protection
        $state = $request->input('state');
        if (!$state || !hash_equals(csrf_token(), $state)) {
            return redirect()->route('account.linked')
                ->with('error', 'Security validation failed. Please try again.');
        }

        try {
            // Exchange code for access token
            $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key'    => config('services.tiktok.client_id'),
                'client_secret' => config('services.tiktok.client_secret'),
                'code'          => $code,
                'grant_type'    => 'authorization_code',
                'redirect_uri'  => config('services.tiktok.redirect_uri'), // Use from config, not route
            ]);

            $data = $response->json();

            if (!isset($data['access_token'])) {
                $errorMsg = $data['error_description'] ?? 
                           $data['error_message'] ?? 
                           $data['error'] ?? 
                           'Unknown error during token exchange';
                
                return redirect()->route('account.linked')
                    ->with('error', 'TikTok authorization failed: ' . $errorMsg);
            }

            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'] ?? null;
            $openId = $data['open_id'] ?? null;
            $expiresIn = $data['expires_in'] ?? 7200;
            $scope = $data['scope'] ?? '';

            $user = Auth::user();

            // Fetch TikTok profile info
            $profileResponse = Http::withToken($accessToken)
                ->timeout(10)
                ->get('https://open.tiktokapis.com/v2/user/info/', [
                    'fields' => 'open_id,union_id,display_name,avatar_url',
                ]);

            $profile = $profileResponse->json();

            $tiktokUrl = null;
            $displayName = null;
            
            if (isset($profile['data']['user']['display_name'])) {
                $displayName = $profile['data']['user']['display_name'];
                $tiktokUrl = "https://www.tiktok.com/@" . $displayName;
            }

            // Check if video.list scope was granted
            $hasVideoScope = str_contains($scope, 'video.list');
            
            if (!$hasVideoScope) {
                Log::warning('TikTok connection missing video.list scope', [
                    'user_id' => $user->id,
                    'granted_scopes' => $scope
                ]);
            }

            // Save TikTok info into linked_accounts table
            $user->linkedAccount()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'tiktok_url'              => $tiktokUrl,
                    'tiktok_connected'        => true,
                    'tiktok_access_token'     => $accessToken,
                    'tiktok_refresh_token'    => $refreshToken,
                    'tiktok_open_id'          => $openId,
                    'tiktok_token_expires_at' => now()->addSeconds($expiresIn),
                ]
            );

            if (!$hasVideoScope) {
                return redirect()->route('account.linked')
                    ->with('warning', 'TikTok account connected! However, video access was not granted. You may not be able to display TikTok videos.');
            }

            return redirect()->route('account.linked')
                ->with('success', 'TikTok account connected successfully! You can now display your TikTok videos.');

        } catch (\Exception $e) {
            return redirect()->route('account.linked')
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function disconnect(Request $request)
    {
        $user = Auth::user();
        
        $user->linkedAccount()->update([
            'tiktok_url' => null,
            'tiktok_connected' => false,
            'tiktok_access_token' => null,
            'tiktok_refresh_token' => null,
            'tiktok_open_id' => null,
            'tiktok_token_expires_at' => null,
        ]);

        return redirect()->route('account.linked')
            ->with('success', 'TikTok account disconnected successfully.');
    }

    public function status()
    {
        $user = Auth::user();
        $linkedAccount = $user->linkedAccount;

        return response()->json([
            'tiktok_connected' => $linkedAccount && $linkedAccount->tiktok_connected,
            'tiktok_url'       => $linkedAccount->tiktok_url ?? null,
        ]);
    }

    public function videos()
    {
        $user = Auth::user();
        $linkedAccount = $user->linkedAccount;

        // Ensure TikTok is connected
        if (!$linkedAccount || !$linkedAccount->tiktok_connected || !$linkedAccount->tiktok_access_token) {
            return response()->json([
                'error' => 'TikTok account not connected.'
            ], 403);
        }

        // Check if token expired
        if ($linkedAccount->tiktok_token_expires_at && $linkedAccount->tiktok_token_expires_at->isPast()) {
            if (!$this->refreshTikTokToken($linkedAccount)) {
                return response()->json([
                    'error' => 'Unable to refresh TikTok token.'
                ], 401);
            }
        }

        try {
            // Call TikTok /video/list endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $linkedAccount->tiktok_access_token,
                'Content-Type'  => 'application/json',
            ])->withQueryParameters([
                'fields' => 'id,title,cover_image_url,share_url,create_time'
            ])->post(
                'https://open.tiktokapis.com/v2/video/list/',
                [
                    'max_count' => 20 // fetch up to 20 videos
                ]
            );


            // Handle unauthorized
            if ($response->status() === 401) {
                if ($this->refreshTikTokToken($linkedAccount)) {
                    // Retry after refresh
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $linkedAccount->tiktok_access_token,
                        'Content-Type'  => 'application/json',
                    ])->withQueryParameters([
                        'fields' => 'id,title,cover_image_url,share_url,create_time'
                    ])->post(
                        'https://open.tiktokapis.com/v2/video/list/',
                        [
                            'max_count' => 20
                        ]
                    );
                } else {
                    return response()->json([
                        'error' => 'token_refresh_failed',
                        'message' => 'Unable to refresh TikTok token. Please reconnect your account.'
                    ], 401);
                }
            }

            if ($response->successful()) {
                $data = $response->json();

                return response()->json([
                    'data' => [
                        'videos' => $data['data']['videos'] ?? []
                    ]
                ]);
            }

            return response()->json([
                'data' => [
                    'videos' => []
                ],
                'error' => 'api_error'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'exception',
                'message' => 'An error occurred while fetching TikTok videos.'
            ], 500);
        }
    }

    private function refreshTikTokToken($linkedAccount)
    {
        try {
            if (!$linkedAccount->tiktok_refresh_token) {
                return false;
            }

            $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key' => config('services.tiktok.client_id'),
                'client_secret' => config('services.tiktok.client_secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $linkedAccount->tiktok_refresh_token,
            ]);

            if ($response->successful()) {
                $tokenData = $response->json();
                
                $linkedAccount->update([
                    'tiktok_access_token' => $tokenData['access_token'],
                    'tiktok_refresh_token' => $tokenData['refresh_token'] ?? $linkedAccount->tiktok_refresh_token,
                    'tiktok_token_expires_at' => now()->addSeconds($tokenData['expires_in'] ?? 7200),
                ]);
                
                return true;
            }
            
            return false;
            
        } catch (\Exception $e) {
            return false;
        }
    }

    // New method to handle reconnection
    public function reconnect(Request $request)
    {
        $user = Auth::user();
        
        // Disconnect first
        $user->linkedAccount()->update([
            'tiktok_connected' => false,
            'tiktok_access_token' => null,
            'tiktok_refresh_token' => null,
        ]);

        return redirect()->route('tiktok.connect')
            ->with('info', 'Please reconnect your TikTok account and grant all requested permissions.');
    }
}