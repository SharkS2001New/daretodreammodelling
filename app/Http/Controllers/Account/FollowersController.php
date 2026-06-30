<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $followers = $user->followers()
            ->with(['user.publicInfo'])
            ->latest()
            ->paginate(20);

        $following = $user->following()
            ->with(['model.publicInfo'])
            ->latest()
            ->paginate(20, ['*'], 'following_page');

        return view('account.followers.index', compact('followers', 'following'));
    }
}
