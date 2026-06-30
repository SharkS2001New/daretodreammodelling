<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\LinkedAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkedAccountsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $linkedAccount = $user->linkedAccount ?? new LinkedAccount();

        // For demo purposes - replace with actual TikTok API
        $tiktokVideos = $linkedAccount->hasTikTokConnection() ? $this->getDemoTikTokVideos() : [];

        return view('account.linked', compact('user', 'linkedAccount', 'tiktokVideos'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url'   => 'nullable|url|max:255',
            'youtube_url'   => 'nullable|url|max:255',
            'other_url'     => 'nullable|url|max:255',
        ]);

        $linkedAccount = $user->linkedAccount()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return back()->with('success', 'Social media URLs updated successfully!');
    }

    private function getDemoTikTokVideos()
    {
        return [
            [
                'thumbnail' => 'https://via.placeholder.com/300x400?text=TikTok+Video+1',
                'caption' => 'Check out my latest modeling video! #fashion #model',
                'likes' => '1.2K',
                'views' => '15.7K'
            ],
            [
                'thumbnail' => 'https://via.placeholder.com/300x400?text=TikTok+Video+2',
                'caption' => 'Behind the scenes at the photoshoot 📸',
                'likes' => '2.4K',
                'views' => '28.9K'
            ],
            [
                'thumbnail' => 'https://via.placeholder.com/300x400?text=TikTok+Video+3',
                'caption' => 'New campaign is out! So excited to share this with you all ❤️',
                'likes' => '3.7K',
                'views' => '42.3K'
            ]
        ];
    }

    public function destroy($id)
    {
        $linkedAccount = LinkedAccount::findOrFail($id);
        $linkedAccount->delete();

        return redirect()->route('account.linked')->with('success', 'Linked account deleted successfully.');
    }
}
