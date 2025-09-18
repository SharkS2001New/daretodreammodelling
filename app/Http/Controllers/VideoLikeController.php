<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoLikeController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $video->likes()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['likes_count' => $video->likes()->count()]);
    }

    public function destroy(Request $request, Video $video)
    {
        $video->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['likes_count' => $video->likes()->count()]);
    }
}
