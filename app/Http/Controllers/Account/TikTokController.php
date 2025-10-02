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
            return redirect()->route('account.linked')
                ->with('error', 'TikTok authorization failed.');
        }

        $accessToken = $data['access_token'];
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

        // Save TikTok info into linked_accounts table
        $user->linkedAccount()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'tiktok_url'       => $tiktokUrl,
                'tiktok_connected' => true,
            ]
        );

        return redirect()->route('account.linked')
            ->with('success', 'TikTok account connected successfully!');
    }

    /**
     * Disconnect TikTok account
     */
    public function disconnect(Request $request)
    {
        $user = Auth::user();

        if ($user->linkedAccount) {
            $user->linkedAccount->update([
                'tiktok_url'       => null,
                'tiktok_connected' => false,
            ]);
        }

        return back()->with('success', 'TikTok account disconnected successfully!');
    }
}
