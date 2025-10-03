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
        
        // Request ALL necessary scopes for video access
        $scopes = [
            'user.info.basic',      // Basic user info
            'video.list',           // List user's videos
            'video.upload',         // Upload videos (might be needed)
            'video.publish',        // Publish videos
        ];
        
        $scope = implode(',', $scopes);
        $state = csrf_token();

        $authUrl = "https://www.tiktok.com/v2/auth/authorize/?client_key={$clientId}&scope={$scope}&response_type=code&redirect_uri={$redirectUri}&state={$state}";

        Log::info('TikTok redirect URL', ['url' => $authUrl]);
        
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');
        $error = $request->input('error');

        // Check if user denied authorization
        if ($error === 'access_denied') {
            Log::warning('User denied TikTok authorization');
            return redirect()->route('account.linked')
                ->with('error', 'TikTok authorization was denied. Please grant all requested permissions.');
        }

        if (!$code) {
            Log::error('No authorization code received');
            return redirect()->route('account.linked')
                ->with('error', 'Failed to connect TikTok account. No authorization code received.');
        }

        // Exchange code for access token
        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
            'client_key'    => config('services.tiktok.client_id'),
            'client_secret' => config('services.tiktok.client_secret'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => route('tiktok.callback'),
        ]);

        $data = $response->json();

        if (!isset($data['access_token'])) {
            Log::error('TikTok token exchange failed', [
                'response' => $data,
                'code' => $code
            ]);
            return redirect()->route('account.linked')
                ->with('error', 'TikTok authorization failed: ' . ($data['error_description'] ?? 'Unknown error'));
        }

        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'] ?? null;
        $openId = $data['open_id'] ?? null;
        $expiresIn = $data['expires_in'] ?? 7200;
        $scope = $data['scope'] ?? '';

        $user = Auth::user();

        // Log the granted scopes for debugging
        Log::info('TikTok token granted', [
            'user_id' => $user->id,
            'open_id' => $openId,
            'scopes' => $scope,
            'expires_in' => $expiresIn
        ]);

        // Fetch TikTok profile info
        $profileResponse = Http::withToken($accessToken)
            ->get('https://open.tiktokapis.com/v2/user/info/', [
                'fields' => 'open_id,union_id,display_name,avatar_url,profile_deep_link',
            ]);

        $profile = $profileResponse->json();

        $tiktokUrl = null;
        $displayName = null;
        
        if (isset($profile['data']['user']['display_name'])) {
            $displayName = $profile['data']['user']['display_name'];
            $tiktokUrl = "https://www.tiktok.com/@" . $displayName;
        } elseif (isset($profile['data']['user']['profile_deep_link'])) {
            $tiktokUrl = $profile['data']['user']['profile_deep_link'];
        }

        // Check if video.list scope was granted
        $hasVideoScope = str_contains($scope, 'video.list');
        
        if (!$hasVideoScope) {
            Log::warning('TikTok connection missing video.list scope', [
                'user_id' => $user->id,
                'granted_scopes' => $scope
            ]);
            
            // You might want to inform the user they need to reconnect with proper scopes
            $user->linkedAccount()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'tiktok_url'              => $tiktokUrl,
                    'tiktok_connected'        => true, // Still mark as connected
                    'tiktok_access_token'     => $accessToken,
                    'tiktok_refresh_token'    => $refreshToken,
                    'tiktok_open_id'          => $openId,
                    'tiktok_token_expires_at' => now()->addSeconds($expiresIn),
                ]
            );

            return redirect()->route('account.linked')
                ->with('warning', 'TikTok account connected, but video access was not granted. To display your TikTok videos, please reconnect and grant video permissions.');
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

        Log::info('TikTok account fully connected', [
            'user_id' => $user->id,
            'open_id' => $openId,
            'display_name' => $displayName,
            'has_video_scope' => $hasVideoScope
        ]);

        return redirect()->route('account.linked')
            ->with('success', 'TikTok account connected successfully! You can now display your TikTok videos.');
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

        Log::info('TikTok account disconnected', ['user_id' => $user->id]);

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

        // Ensure TikTok is connected in linked_accounts
        if (!$linkedAccount || !$linkedAccount->tiktok_connected || !$linkedAccount->tiktok_access_token) {
            return response()->json([
                'error' => 'TikTok account not connected.'
            ], 403);
        }

        // Check if token needs refresh
        if ($linkedAccount->tiktok_token_expires_at && $linkedAccount->tiktok_token_expires_at->isPast()) {
            if (!$this->refreshTikTokToken($linkedAccount)) {
                return response()->json([
                    'error' => 'Unable to refresh TikTok token.'
                ], 401);
            }
        }

        try {
            // Use the correct TikTok API endpoint for videos with proper parameters
            $response = Http::withToken($linkedAccount->tiktok_access_token)
                ->timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post('https://open.tiktokapis.com/v2/video/list/', [
                    'max_count' => 20,
                    'fields' => [
                        'id', 'title', 'cover_image_url', 'share_url', 'create_time', 
                        'video_description', 'duration', 'height', 'width'
                    ]
                ]);

            Log::info('TikTok videos API request', [
                'status' => $response->status(),
                'user_id' => $user->id
            ]);

            if ($response->status() === 401) {
                // Check if it's a scope error
                $errorBody = $response->json();
                if (isset($errorBody['error']['code']) && $errorBody['error']['code'] === 'scope_not_authorized') {
                    Log::error('TikTok scope not authorized', [
                        'user_id' => $user->id,
                        'error' => $errorBody['error']
                    ]);
                    
                    return response()->json([
                        'error' => 'video_scope_missing',
                        'message' => 'TikTok video access was not granted. Please reconnect your TikTok account and grant video permissions.'
                    ], 401);
                }
                
                // Try token refresh for other 401 errors
                if ($this->refreshTikTokToken($linkedAccount)) {
                    $response = Http::withToken($linkedAccount->tiktok_access_token)
                        ->post('https://open.tiktokapis.com/v2/video/list/', [
                            'max_count' => 20,
                            'fields' => [
                                'id', 'title', 'cover_image_url', 'share_url', 'create_time'
                            ]
                        ]);
                } else {
                    return response()->json([
                        'error' => 'token_refresh_failed',
                        'message' => 'Unable to refresh TikTok token. Please reconnect your account.'
                    ], 401);
                }
            }

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']['videos'])) {
                    return response()->json([
                        'data' => [
                            'videos' => $data['data']['videos']
                        ]
                    ]);
                }
                
                return response()->json([
                    'data' => [
                        'videos' => []
                    ]
                ]);
            } else {
                Log::error('TikTok API error response', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json([
                    'error' => 'api_error',
                    'message' => 'Failed to fetch TikTok videos from API.',
                    'data' => ['videos' => []]
                ], $response->status());
            }
            
        } catch (\Exception $e) {
            Log::error('TikTok videos API exception', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return response()->json([
                'error' => 'exception',
                'message' => 'An error occurred while fetching TikTok videos.',
                'data' => ['videos' => []]
            ], 500);
        }
    }

    private function refreshTikTokToken($linkedAccount)
    {
        try {
            if (!$linkedAccount->tiktok_refresh_token) {
                Log::error('No refresh token available for TikTok account');
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
                
                Log::info('TikTok token refreshed successfully', ['user_id' => $linkedAccount->user_id]);
                return true;
            }
            
            Log::error('TikTok token refresh failed', ['response' => $response->body()]);
            return false;
            
        } catch (\Exception $e) {
            Log::error('TikTok token refresh exception', ['error' => $e->getMessage()]);
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

        Log::info('TikTok account prepared for reconnection', ['user_id' => $user->id]);

        return redirect()->route('tiktok.connect')
            ->with('info', 'Please reconnect your TikTok account and grant all requested permissions.');
    }
}