<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoLikeController extends Controller
{
    public function store(Request $request, $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $photo = Photo::findOrFail($id);

        $like = $photo->likes()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'liked' => true,
            'likes_count' => $photo->likes()->count(),
        ]);
    }


    public function destroy(Request $request, $id)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $photo = Photo::findOrFail($id);

        $photo->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json([
            'liked' => false,
            'likes_count' => $photo->likes()->count(),
        ]);
    }
}
