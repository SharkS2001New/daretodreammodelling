<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkedAccount;
use App\Models\User;
use App\Models\UserPublicInfo;
use App\Support\ModelAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class ModelManagementController extends Controller
{
    public function index()
    {
        $models = User::with('publicInfo')
            ->where('is_admin', false)
            ->orderBy('name')
            ->get();

        return view('admin.models.index', compact('models'));
    }

    public function create()
    {
        return view('admin.models.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'display_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
            'user_type' => 'Model',
            'email_verified_at' => now(),
            'must_change_password' => true,
        ]);

        if (! empty($data['display_name']) || ! empty($data['location'])) {
            UserPublicInfo::create([
                'user_id' => $user->id,
                'display_name' => $data['display_name'] ?? null,
                'location' => $data['location'] ?? null,
            ]);
        }

        $user->linkedAccount()->create([]);

        return redirect()
            ->route('console.models.settings', $user)
            ->with('success', 'Model account created for ' . $user->name . '. You can now complete their profile and upload media.');
    }

    public function settings(User $user)
    {
        ModelAccess::authorizeManage($user);

        $user->load(['publicInfo', 'linkedAccount']);

        return view('admin.models.settings', [
            'managedUser' => $user,
            'publicInfo' => $user->publicInfo,
            'linkedAccount' => $user->linkedAccount ?? new LinkedAccount(),
        ]);
    }

    public function updatePublic(Request $request, User $user)
    {
        ModelAccess::authorizeManage($user);

        $data = $request->validate([
            'display_name' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'ethnicity' => 'nullable|string|max:255',
            'hair' => 'nullable|string|max:255',
            'eye' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:255',
            'shoes' => 'nullable|string|max:255',
            'waist' => 'nullable|string|max:255',
            'hips' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'languages' => 'nullable',
            'about_me' => 'nullable|string',
        ]);

        if (isset($data['languages'])) {
            if (is_array($data['languages'])) {
                $data['languages'] = implode(',', array_filter($data['languages']));
            } else {
                $data['languages'] = trim((string) $data['languages']);
            }
        }

        UserPublicInfo::updateOrCreate(['user_id' => $user->id], $data);

        return back()->with('success', 'Public information updated for ' . $user->displayName() . '.');
    }

    public function updateProfilePicture(Request $request, User $user)
    {
        ModelAccess::authorizeManage($user);

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $publicInfo = UserPublicInfo::where('user_id', $user->id)->first();

        if ($publicInfo?->profile_picture) {
            Storage::disk('public')->delete($publicInfo->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profiles', 'public');

        UserPublicInfo::updateOrCreate(
            ['user_id' => $user->id],
            ['profile_picture' => $path]
        );

        return back()->with('success', 'Profile picture updated for ' . $user->displayName() . '.');
    }

    public function updateLinked(Request $request, User $user)
    {
        ModelAccess::authorizeManage($user);

        $validated = $request->validate([
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'other_url' => 'nullable|url|max:255',
        ]);

        $user->linkedAccount()->updateOrCreate(['user_id' => $user->id], $validated);

        return back()->with('success', 'Social links updated for ' . $user->displayName() . '.');
    }
}
