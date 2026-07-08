<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Video;
use App\Models\User;
use App\Support\ModelAccess;

class ModelUploadsController extends Controller
{
    public function index($slug)
    {
        $user = User::with([
            'linkedAccount',
            'publicInfo',
            'photos.likes',
            'photos.views',
            'videos.likes',
            'videos.views',
            'followers',
            'reviewsReceived' => fn ($q) => $q->where('approved', true)->with('reviewer.publicInfo'),
        ])->where('slug', $slug)->firstOrFail();

        $isFollowing = Auth::check()
            && Auth::id() !== $user->id
            && $user->followers()->where('user_id', Auth::id())->exists();

        $userReview = Auth::check() && Auth::id() !== $user->id
            ? \App\Models\Review::where('reviewer_id', Auth::id())->where('model_id', $user->id)->first()
            : null;

        $reviews = $user->reviewsReceived;
        $reviewStats = [
            'count' => $reviews->count(),
            'average' => $reviews->count() ? round($reviews->avg('rating'), 1) : null,
        ];

        $stats = [
            'followers' => $user->followers->count(),
            'photo_likes' => $user->photos->sum(fn($p) => $p->likes->count()),
            'photo_views' => $user->photos->sum(fn($p) => $p->views->count()),
            'video_likes' => $user->videos->sum(fn($v) => $v->likes->count()),
            'video_views' => $user->videos->sum(fn($v) => $v->views->count()),
        ];

        $canManage = ModelAccess::canManage($user);
        
        return view('models.show', compact('user', 'stats', 'isFollowing', 'reviews', 'reviewStats', 'userReview', 'canManage'));
    }

    private function fetchTikTokVideos($user)
    {
        try {
            \Log::info('Fetching TikTok videos for user: ' . $user->id);
            
            // Check if user has linked account with TikTok tokens
            if (!$user->linkedAccount || !$user->linkedAccount->tiktok_access_token) {
                \Log::warning('No TikTok access token for user: ' . $user->id);
                return ['data' => ['videos' => []]];
            }

            $linkedAccount = $user->linkedAccount;

            // Check if token needs refresh
            if ($linkedAccount->tiktok_token_expires_at && $linkedAccount->tiktok_token_expires_at->isPast()) {
                \Log::info('TikTok token expired, refreshing...');
                $this->refreshTikTokToken($linkedAccount);
            }

            $response = Http::withToken($linkedAccount->tiktok_access_token)
                ->timeout(30)
                ->get('https://open.tiktokapis.com/v2/video/list/', [
                    'fields' => 'id,title,cover_image_url,share_url',
                    'max_count' => 10,
                ]);

            \Log::info('TikTok API Response Status: ' . $response->status());
            \Log::info('TikTok API Response Body: ' . $response->body());

            if ($response->status() === 401) {
                \Log::info('TikTok token invalid, refreshing...');
                if ($this->refreshTikTokToken($linkedAccount)) {
                    // Retry with new token
                    $response = Http::withToken($linkedAccount->tiktok_access_token)
                        ->get('https://open.tiktokapis.com/v2/video/list/', [
                            'fields' => 'id,title,cover_image_url,share_url',
                            'max_count' => 10,
                        ]);
                } else {
                    \Log::error('Failed to refresh TikTok token');
                    return ['data' => ['videos' => []]];
                }
            }

            if ($response->successful()) {
                $data = $response->json();
                $videoCount = count($data['data']['videos'] ?? []);
                \Log::info('TikTok videos count: ' . $videoCount);
                return $data;
            } else {
                \Log::error('TikTok API Error: ' . $response->body());
                return ['data' => ['videos' => []]];
            }
            
        } catch (\Exception $e) {
            \Log::error('TikTok API Exception: ' . $e->getMessage());
            return ['data' => ['videos' => []]];
        }
    }

    private function refreshTikTokToken($linkedAccount)
    {
        try {
            if (!$linkedAccount->tiktok_refresh_token) {
                \Log::error('No refresh token available for TikTok account');
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
                
                \Log::info('TikTok token refreshed successfully');
                return true;
            }
            
            \Log::error('Token refresh failed: ' . $response->body());
            return false;
            
        } catch (\Exception $e) {
            \Log::error('Token refresh exception: ' . $e->getMessage());
            return false;
        }
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:3072', // 3MB
        ]);

        try {
            $user = ModelAccess::resolveTargetUser($request);
            ModelAccess::authorizeManage($user);
            
            // Store the photo
            $path = $request->file('photo')->store('model-photos', 'public');
            
            // Save photo to database
            $userPhoto = $user->photos()->create([
                'file_path' => $path,
                'original_name' => $request->file('photo')->getClientOriginalName(),
                'file_size' => $request->file('photo')->getSize(),
                'mime_type' => $request->file('photo')->getMimeType(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully',
                'photo' => $userPhoto
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading photo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deletePhoto($id)
    {
        try {
            $photo = Photo::findOrFail($id);
            ModelAccess::authorizeManage($photo->user);
            
            // Delete file from storage
            Storage::disk('public')->delete($photo->file_path);
            
            // Delete record from database
            $photo->delete();

            return back()->with('success', 'Photo deleted successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting photo: ' . $e->getMessage());
        }
    }

    /**
     * Upload a video file.
     */
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,m4v|max:20480', // max 20MB
        ]);

        $user = ModelAccess::resolveTargetUser($request);
        ModelAccess::authorizeManage($user);

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('uploads/videos', 'public');

            // Save video record in DB
            $video = new Video();
            $video->user_id = $user->id;
            $video->file_path = $path;
            $video->save();

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully!',
                'video'   => [
                    'id' => $video->id,
                    'file_path' => asset('storage/' . $video->file_path)
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No video uploaded.'], 400);
    }

    /**
     * Delete a video.
     */
    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);
        ModelAccess::authorizeManage($video->user);

        // Delete file from storage
        if ($video->file_path && \Storage::disk('public')->exists($video->file_path)) {
            \Storage::disk('public')->delete($video->file_path);
        }

        $video->delete();

        return redirect()->back()->with('success', 'Video deleted successfully.');
    }

    public function storeLink(Request $request)
    {
        $request->validate([
            'youtube_url' => 'required|url',
        ]);

        $user = ModelAccess::resolveTargetUser($request);
        ModelAccess::authorizeManage($user);

        $user->videos()->create([
            'youtube_url' => $request->youtube_url,
        ]);

        return back()->with('success', 'Video link added successfully!');
    }
}