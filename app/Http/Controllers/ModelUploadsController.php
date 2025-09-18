<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Video;
use App\Models\User;

class ModelUploadsController extends Controller
{
    public function index($slug)
    {
        $user = User::with(['linkedAccount', 'publicInfo'])
            ->whereRaw("REPLACE(LOWER(name), ' ', '-') = ?", [$slug])
            ->firstOrFail();

        return view('models.show', compact('user'));
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ]);

        try {
            $user = Auth::user();
            
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
            $photo = Photo::where('user_id', Auth::id())->findOrFail($id);
            
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
            'video' => 'required|file|mimes:mp4,m4v|max:51200', // max 50MB
        ]);

        $user = Auth::user();

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
        $video = Video::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

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

        auth()->user()->videos()->create([
            'youtube_url' => $request->youtube_url,
        ]);

        return back()->with('success', 'Video link added successfully!');
    }
}