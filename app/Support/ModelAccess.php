<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModelAccess
{
    public static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    public static function canManage(User $target): bool
    {
        $auth = Auth::user();

        if (! $auth) {
            return false;
        }

        return $auth->id === $target->id || $auth->isAdmin();
    }

    public static function resolveTargetUser(Request $request): User
    {
        $auth = Auth::user();

        if ($auth->isAdmin() && $request->filled('user_id')) {
            return User::findOrFail($request->integer('user_id'));
        }

        return $auth;
    }

    public static function authorizeManage(User|int $target): void
    {
        $user = $target instanceof User ? $target : User::findOrFail($target);

        if (! static::canManage($user)) {
            abort(403);
        }
    }
}
