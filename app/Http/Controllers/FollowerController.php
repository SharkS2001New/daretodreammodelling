<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(Request $request, User $model)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($model->id === $request->user()->id) {
            return response()->json(['error' => 'You cannot follow yourself.'], 422);
        }

        $model->followers()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'following' => true,
            'followers_count' => $model->followers()->count(),
        ]);
    }

    public function destroy(Request $request, User $model)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $model->followers()->where('user_id', $request->user()->id)->delete();

        return response()->json([
            'following' => false,
            'followers_count' => $model->followers()->count(),
        ]);
    }
}
