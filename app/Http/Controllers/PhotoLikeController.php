<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoLikeController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        $photo->likes()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['likes_count' => $photo->likes()->count()]);
    }

    public function destroy(Request $request, Photo $photo)
    {
        $photo->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['likes_count' => $photo->likes()->count()]);
    }
}
