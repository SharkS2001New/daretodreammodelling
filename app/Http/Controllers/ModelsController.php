<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\UserPublicInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class ModelsController extends Controller
{
    public function index(Request $request)
    {
        // === filters we accept from the form ===
        $filters = $request->only([
            'gender','ethnicity','hair','eye','height','shoes',
            'waist','hips','nationality'
        ]);

        // Age filter
        $min = (int) $request->input('age_min', 18);
        $max = (int) $request->input('age_max', 45);
        $hasAgeFilter = $request->filled('age_min') && $request->filled('age_max') && !($min === 18 && $max === 45);

        // Build a user query only if filters are present
        $userIds = null;
        $hasAnySimpleFilter = false;
        foreach ($filters as $v) { if (!empty($v)) { $hasAnySimpleFilter = true; break; } }

        if ($hasAnySimpleFilter || $hasAgeFilter) {
            $userQuery = User::query();

            // simple filters applied to publicInfo relationship
            foreach ($filters as $field => $value) {
                if (!empty($value)) {
                    $userQuery->whereHas('publicInfo', function ($q) use ($field, $value) {
                        $q->where($field, $value);
                    });
                }
            }

            if ($hasAgeFilter) {
                $userQuery->whereHas('publicInfo', function ($q) use ($min, $max) {
                    $q->whereBetween('age', [$min, $max]);
                });
            }

            // get matching user ids
            $userIds = $userQuery->pluck('id');
            // if empty, short-circuit to empty result set
            if ($userIds->isEmpty()) {
                // return empty paginator (keeps blade logic intact)
                $photos = Photo::whereRaw('0 = 1')->paginate(20);
                return view('models.index', compact('photos'));
            }
        }

        // Get latest photo id per user (optionally restricted to filtered users)
        $latestPhotoIdsQuery = Photo::selectRaw('MAX(id) as id')->groupBy('user_id');
        if ($userIds !== null) {
            $latestPhotoIdsQuery->whereIn('user_id', $userIds);
        }
        $latestPhotoIds = $latestPhotoIdsQuery->pluck('id');

        // Eager load user photos (limited per user) + publicInfo and likes/views
        $photos = Photo::with([
                'user.publicInfo',
                'likes',
                'views',
                'user.photos' => function ($q) {
                    $q->latest()->take(50); // change limit as needed for the carousel
                }
            ])
            ->whereIn('id', $latestPhotoIds)
            ->latest()
            ->paginate(20);

        return view('models.index', compact('photos'));
    }

    public function details($id)
    {
        $photo = Photo::with(['user.publicInfo'])->findOrFail($id);

        return response()->json([
            'name'    => $photo->user->publicInfo->display_name ?? $photo->user->name,
            'city'    => $photo->user->publicInfo->location ?? null,
            'country' => $photo->user->publicInfo->nationality ?? null,
            'age'     => $photo->user->publicInfo->age ?? null,
            'gender'  => $photo->user->publicInfo->gender ?? null,
            'photo'   => $photo->file_path,
            'rating'  => 0, // you can compute from likes/views later
            'suggested' => Photo::inRandomOrder()
                ->take(4)
                ->with('user.publicInfo')
                ->get()
                ->map(function ($p) {
                    return [
                        'id'    => $p->id,
                        'name'  => $p->user->publicInfo->display_name ?? $p->user->name,
                        'photo' => $p->file_path,
                    ];
                }),
        ]);
    }

    private function getVisitorCountry(Request $request)
    {
        try {
            $ip = $request->ip();
            $response = @file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);
            return $data['country'] ?? 'Kenya';
        } catch (\Exception $e) {
            return 'Kenya'; // fallback
        }
    }

}
