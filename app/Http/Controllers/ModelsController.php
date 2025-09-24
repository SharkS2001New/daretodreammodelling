<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\UserPublicInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class ModelsController extends Controller
{
    public function index(Request $request)
    {
        // Subquery → get latest photo IDs per model
        $latestPhotoIds = Photo::selectRaw('MAX(id) as id')
            ->groupBy('user_id')
            ->pluck('id');

        $query = Photo::with(['user.publicInfo', 'likes', 'views'])
            ->whereIn('id', $latestPhotoIds);

        // === Simple Filters ===
        $filters = $request->only([
            'gender', 'ethnicity', 'hair', 'eye', 'height', 'shoes',
            'waist', 'hips', 'nationality'
        ]);

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $query->whereHas('user.publicInfo', function ($q) use ($field, $value) {
                    $q->where($field, $value);
                });
            }
        }

        // ✅ Age filter (skip if default values)
        $min = (int) $request->input('age_min', 18);
        $max = (int) $request->input('age_max', 45);

        if ($request->filled('age_min') && $request->filled('age_max')
            && !($min === 18 && $max === 45)) {
            $query->whereHas('user.publicInfo', function ($q) use ($min, $max) {
                $q->whereBetween('age', [$min, $max]);
            });
        }

        // ✅ Languages filter (multi-select)
        // if ($request->filled('languages')) {
        //     $languages = (array) $request->languages;
        //     $query->whereHas('user.publicInfo', function ($q) use ($languages) {
        //         $q->where(function ($subQ) use ($languages) {
        //             foreach ($languages as $lang) {
        //                 $subQ->orWhere('languages', 'LIKE', "%{$lang}%");
        //             }
        //         });
        //     });
        // }

        $photos = $query->latest()->paginate(20);

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
