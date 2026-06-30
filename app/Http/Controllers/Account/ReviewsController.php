<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $received = Review::where('model_id', $user->id)
            ->where('approved', true)
            ->with(['reviewer.publicInfo'])
            ->latest()
            ->paginate(15, ['*'], 'received_page');

        $given = Review::where('reviewer_id', $user->id)
            ->with(['model.publicInfo'])
            ->latest()
            ->paginate(15, ['*'], 'given_page');

        $averageRating = Review::where('model_id', $user->id)
            ->where('approved', true)
            ->avg('rating');

        return view('account.reviews.index', compact('received', 'given', 'averageRating'));
    }

    public function store(Request $request, User $model)
    {
        $authUser = Auth::user();

        if ($model->id === $authUser->id) {
            return back()->with('error', 'You cannot review yourself.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            [
                'reviewer_id' => $authUser->id,
                'model_id' => $model->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'approved' => true,
            ]
        );

        return back()->with('success', 'Your review has been submitted.');
    }
}
