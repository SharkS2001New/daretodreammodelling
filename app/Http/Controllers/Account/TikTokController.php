<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TikTokController extends Controller
{
    /**
     * Redirect the user to TikTok OAuth
     */
    public function redirect()
    {
        $clientId     = config('services.tiktok.client_id');
        $redirectUri  = route('tiktok.callback');
        $scopes       = 'user.info.basic';
        $state        = csrf_token();

        $url = "https://www.tiktok.com/v2/auth/authorize/?" . http_build_query([
            'client_key'    => $clientId,
            'scope'         => $scopes,
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'state'         => $state,
        ]);

        return redirect()->away($url);
    }

    /**
     * Handle TikTok OAuth callback
     */
    public function callback(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return redirect()->route('account.linked')
                ->with('error', 'Failed to connect TikTok account.');
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
            \Log::error('TikTok token exchange failed: ' . json_encode($data));
            return redirect()->route('account.linked')
                ->with('error', 'TikTok authorization failed.');
        }

        $accessToken = $data['access_token'];
        $refreshToken = $data['refresh_token'] ?? null;
        $openId = $data['open_id'] ?? null;
        $expiresIn = $data['expires_in'] ?? 7200; // Default 2 hours

        $user = Auth::user();

        // Fetch TikTok profile info
        $profileResponse = Http::withToken($accessToken)
            ->get('https://open.tiktokapis.com/v2/user/info/', [
                'fields' => 'open_id,union_id,display_name,avatar_url',
            ]);

        $profile = $profileResponse->json();

        $tiktokUrl = null;
        if (isset($profile['data']['user']['display_name'])) {
            $tiktokUrl = "https://www.tiktok.com/@" . $profile['data']['user']['display_name'];
        }

        // Save TikTok info into linked_accounts table with tokens
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

        \Log::info('TikTok account connected for user: ' . $user->id . ', OpenID: ' . $openId);

        return redirect()->route('account.linked')
            ->with('success', 'TikTok account connected successfully!');
    }

    public function status()
    {
        $user = Auth::user();

        return response()->json([
            'tiktok_connected' => (bool) $user->tiktok_connected,
            'tiktok_url'       => $user->tiktok_url,
        ]);
    }

    public function videos()
    {
        $user = Auth::user();

        // Ensure TikTok is connected
        if (!$user->tiktok_connected || !$user->tiktok_url) {
            return response()->json([
                'error' => 'TikTok account not connected.'
            ], 403);
        }

        // Call TikTok API
        $response = Http::withToken($user->tiktok_access_token)
            ->get('https://open.tiktokapis.com/v2/video/list/', [
                'fields'    => 'id,title,cover_image_url,share_url',
                'max_count' => 10,
            ]);

        // Handle expired token (401)
        if ($response->status() === 401) {
            $refresh = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key'    => config('services.tiktok.client_id'),
                'client_secret' => config('services.tiktok.client_secret'),
                'grant_type'    => 'refresh_token',
                'refresh_token' => $user->tiktok_refresh_token,
            ])->json();

            if (isset($refresh['access_token'])) {
                $user->update([
                    'tiktok_access_token'  => $refresh['access_token'],
                    'tiktok_refresh_token' => $refresh['refresh_token'] ?? $user->tiktok_refresh_token,
                ]);

                $response = Http::withToken($refresh['access_token'])
                    ->get('https://open.tiktokapis.com/v2/video/list/', [
                        'fields'    => 'id,title,cover_image_url,share_url',
                        'max_count' => 10,
                    ]);
            } else {
                return response()->json([
                    'error' => 'Unable to refresh TikTok token.'
                ], 401);
            }
        }

        return $response->json();
    }

    /**
     * Disconnect TikTok account
     */
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
}
