<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPublicInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicInfoController extends Controller
{
    public function edit()
    {
        // Get public info or create empty instance
        $publicInfo = Auth::user()->publicInfo ?? new UserPublicInfo();
        return view('account.public', compact('publicInfo'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

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
            'languages' => 'nullable|array',
            'languages.*' => 'string|max:50',
            'about_me' => 'nullable|string',
        ]);

        // Convert languages array to comma-separated string
        if (isset($data['languages'])) {
            $data['languages'] = implode(',', $data['languages']);
        }

        UserPublicInfo::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );


        return back()->with('success', 'Public information updated successfully.');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        try {
            // Get the public info record
            $publicInfo = UserPublicInfo::where('user_id', $user->id)->first();

            // Delete old profile picture if exists
            if ($publicInfo && $publicInfo->profile_picture) {
                Storage::disk('public')->delete($publicInfo->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profiles', 'public');

            // Update or create public info record
            UserPublicInfo::updateOrCreate(
                ['user_id' => $user->id],
                ['profile_picture' => $path]
            );

            return back()->with('success', 'Profile picture updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error uploading image: ' . $e->getMessage());
        }
    }
}