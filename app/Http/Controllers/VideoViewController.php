<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $video->views()->create([
            'user_id' => $request->user()?->id,
            'ip'      => $request->ip(),
        ]);

        return response()->json(['views_count' => $video->views()->count()]);
    }
}
