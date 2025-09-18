<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoViewController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        $photo->views()->create([
            'user_id' => $request->user()?->id,
            'ip'      => $request->ip(),
        ]);

        return response()->json(['views_count' => $photo->views()->count()]);
    }
}
