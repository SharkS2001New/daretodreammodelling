<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TikTokController extends Controller
{
    public function redirect()
    {
        // TikTok OAuth URL - you'll need to register your app with TikTok
        $clientId = config('services.tiktok.client_id');
        $redirectUri = config('services.tiktok.redirect');
        $state = bin2hex(random_bytes(16));
        
        session(['tiktok_oauth_state' => $state]);

        $authUrl = "https://www.tiktok.com/v2/auth/authorize/?client_key={$clientId}&response_type=code&scope=user.info.basic,video.list&redirect_uri={$redirectUri}&state={$state}";

        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        // Verify state parameter
        if ($request->state !== session('tiktok_oauth_state')) {
            return redirect()->route('account.linked')->with('error', 'Invalid state parameter');
        }

        if ($request->has('error')) {
            return redirect()->route('account.linked')->with('error', 'TikTok connection cancelled');
        }

        $code = $request->code;
        
        try {
            // Exchange code for access token
            $response = Http::post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key' => config('services.tiktok.client_id'),
                'client_secret' => config('services.tiktok.client_secret'),
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => config('services.tiktok.redirect')
            ]);

            $data = $response->json();

            if (isset($data['access_token'])) {
                // Save TikTok access token to user
                $user = Auth::user();
                $user->update([
                    'tiktok_access_token' => $data['access_token'],
                    'tiktok_connected' => true,
                    'tiktok_user_id' => $data['open_id'] ?? null
                ]);

                return redirect()->route('account.linked')->with('success', 'TikTok account connected successfully!');
            }

            return redirect()->route('account.linked')->with('error', 'Failed to connect TikTok account');

        } catch (\Exception $e) {
            return redirect()->route('account.linked')->with('error', 'Error connecting TikTok: ' . $e->getMessage());
        }
    }

    public function disconnect(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'tiktok_access_token' => null,
            'tiktok_connected' => false,
            'tiktok_user_id' => null
        ]);

        return back()->with('success', 'TikTok account disconnected successfully!');
    }

    public function fetchVideos(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->tiktok_access_token) {
            return response()->json(['error' => 'Not connected to TikTok'], 400);
        }

        try {
            $response = Http::withToken($user->tiktok_access_token)
                ->get('https://open.tiktokapis.com/v2/video/list/', [
                    'fields' => 'id,title,video_description,duration,cover_image_url,share_url,create_time,likes_count,comments_count,views_count'
                ]);

            return $response->json();

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch videos'], 500);
        }
    }
}