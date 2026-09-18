<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Follower;
use App\Models\LinkedAccount;
use App\Models\Message;
use App\Models\Photo;
use App\Models\PhotoLike;
use App\Models\PhotoView;
use App\Models\Review;
use App\Models\User;
use App\Models\UserPublicInfo;
use App\Models\Video;
use App\Models\VideoLike;
use App\Models\VideoView;
use App\Support\ModelAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class ModelManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();
        if (! in_array($status, ['active', 'inactive'], true)) {
            $status = 'all';
        }

        $counts = [
            'all' => User::where('is_admin', false)->count(),
            'active' => User::where('is_admin', false)->where('is_active', true)->count(),
            'inactive' => User::where('is_admin', false)->where('is_active', false)->count(),
        ];

        $models = User::with('publicInfo')
            ->where('is_admin', false)
            ->when($status !== 'all', fn ($query) => $query->where('is_active', $status === 'active'))
            ->when($search !== '', function ($query) use ($search) {
                $like = '%' . $search . '%';
                $query->where(function ($q) use ($like) {
                    $q->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhereHas('publicInfo', function ($publicInfo) use ($like) {
                            $publicInfo->where('display_name', 'like', $like)
                                ->orWhere('location', 'like', $like);
                        });
                });
            })
            ->orderBy('name')
            ->get();

        return view('admin.models.index', compact('models', 'search', 'status', 'counts'));
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
            'managedPublicInfo' => $user->publicInfo,
            'managedLinkedAccount' => $user->linkedAccount ?? new LinkedAccount(),
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

    public function deactivate(User $user)
    {
        $this->authorizeStatusChange($user);

        $user->forceFill(['is_active' => false, 'deactivated_at' => now()])->save();

        return back()->with('success', $user->displayName() . ' has been deactivated and is now hidden from the website.');
    }

    public function activate(User $user)
    {
        $this->authorizeStatusChange($user);

        $user->forceFill(['is_active' => true, 'deactivated_at' => null])->save();

        return back()->with('success', $user->displayName() . ' has been reactivated and is visible on the website again.');
    }

    public function destroy(User $user)
    {
        $this->authorizeStatusChange($user);

        $name = $user->displayName();
        $user->load(['photos', 'videos', 'publicInfo']);

        // Collect files first; they are removed only after the database work succeeds.
        $files = $user->photos->pluck('file_path')
            ->merge($user->videos->pluck('file_path'))
            ->push($user->publicInfo?->profile_picture)
            ->filter()
            ->all();

        // Related rows are removed explicitly rather than relying on ON DELETE CASCADE,
        // because the production schema was created by hand.
        DB::transaction(function () use ($user) {
            $photoIds = $user->photos->pluck('id');
            $videoIds = $user->videos->pluck('id');

            PhotoLike::whereIn('photo_id', $photoIds)->orWhere('user_id', $user->id)->delete();
            PhotoView::whereIn('photo_id', $photoIds)->orWhere('user_id', $user->id)->delete();
            Photo::whereIn('id', $photoIds)->delete();

            VideoLike::whereIn('video_id', $videoIds)->orWhere('user_id', $user->id)->delete();
            VideoView::whereIn('video_id', $videoIds)->orWhere('user_id', $user->id)->delete();
            Video::whereIn('id', $videoIds)->delete();

            Follower::where('model_id', $user->id)->orWhere('user_id', $user->id)->delete();
            Message::where('sender_id', $user->id)->orWhere('recipient_id', $user->id)->delete();
            Booking::where('model_id', $user->id)->orWhere('client_id', $user->id)->delete();
            Review::where('model_id', $user->id)->orWhere('reviewer_id', $user->id)->delete();

            // Keep any blog posts, re-attributed to the admin doing the deletion
            Blog::where('user_id', $user->id)->update(['user_id' => Auth::id()]);

            LinkedAccount::where('user_id', $user->id)->delete();
            UserPublicInfo::where('user_id', $user->id)->delete();

            $user->delete();
        });

        Storage::disk('public')->delete($files);

        return redirect()
            ->route('console.models.index')
            ->with('success', $name . ' and all their photos, videos and account data have been permanently deleted.');
    }

    /**
     * Admin accounts (including the current user) can never be deactivated or deleted here.
     */
    private function authorizeStatusChange(User $user): void
    {
        if ($user->isAdmin() || $user->id === Auth::id()) {
            abort(403, 'Admin accounts cannot be deactivated or deleted from the console.');
        }
    }
}
