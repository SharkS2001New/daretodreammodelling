<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoView;
use Illuminate\Http\Request;

class PhotoViewController extends Controller
{
    public function store(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        PhotoView::create([
            'photo_id' => $photo->id,
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip'      => $request->ip(),
        ]);

        return response()->json(['success' => true]);
    }
}
