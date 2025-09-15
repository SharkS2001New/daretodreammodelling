<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class TestimonialsController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $cacheKey = "models_page_{$page}";

        $testimonials = Cache::rememberForever($cacheKey, function () {
            return Testimonial::latest()->paginate(10);
        });

        return view('testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'job_title'       => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'youtube_link'    => 'nullable|url',
            'media_type'      => 'required|in:cover,youtube',
            'testimony'       => 'required|string',
            'ratings'         => 'required|integer|min:1|max:5',
        ]);

        // Handle profile picture
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('uploads/testimonials', 'public');
        }

        // Handle media type
        $coverImagePath = null;
        $youtubeLink = null;

        if ($validated['media_type'] === 'cover' && $request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('uploads/testimonials/covers', 'public');
        }

        if ($validated['media_type'] === 'youtube') {
            $youtubeLink = $validated['youtube_link'];
        }

        $cleanTestimony = Purifier::clean($validated['testimony']);

        Testimonial::create([
            'name'            => $validated['name'],
            'job_title'       => $validated['job_title'],
            'profile_picture' => $profilePicturePath,
            'cover_image'     => $coverImagePath,
            'youtube_link'    => $youtubeLink,
            'testimony'       => $cleanTestimony,
            'ratings'         => $validated['ratings'],
            'user_id'         => auth()->id(),
        ]);

        // Clear cache
        foreach (range(1, 5) as $page) {
            Cache::forget("models_page_{$page}");
        }

        Cache::forget('models_testimonials');

        return redirect()->route('testimonials')->with('success', 'Testimonial added successfully!');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'youtube_link' => 'nullable|url',
            'testimony' => 'required|string',
            'ratings' => 'required|integer|min:1|max:5',
            'media_type' => 'required|in:cover,youtube',
        ]);

        // 🔹 Fetch testimonial by ID
        $testimonial = Testimonial::findOrFail($id);

        $data = $request->only(['name', 'job_title', 'testimony', 'ratings']);

        // ✅ Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($testimonial->profile_picture && \Storage::disk('public')->exists($testimonial->profile_picture)) {
                \Storage::disk('public')->delete($testimonial->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')
                ->store('testimonials/profile_pictures', 'public');
        }

        // ✅ Handle cover image OR YouTube link
        if ($request->media_type === 'cover') {
            if ($request->hasFile('cover_image')) {
                if ($testimonial->cover_image && \Storage::disk('public')->exists($testimonial->cover_image)) {
                    \Storage::disk('public')->delete($testimonial->cover_image);
                }
                $data['cover_image'] = $request->file('cover_image')
                    ->store('testimonials/cover_images', 'public');
            }
            $data['youtube_link'] = null; // clear YouTube if cover chosen
        } else {
            $data['youtube_link'] = $request->youtube_link;
            $data['cover_image'] = null; // clear cover if YouTube chosen
        }

        // ✅ Update record
        $testimonial->update($data);

        // 🔥 Clear caches so updated info is visible
        foreach (range(1, 5) as $page) {
            Cache::forget("models_page_{$page}");
        }
        
        Cache::forget('models_testimonials');

        return redirect()->route('testimonials')
            ->with('success', 'Testimonial updated successfully.');
    }


    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Delete profile picture if exists
        if ($testimonial->profile_picture && Storage::disk('public')->exists($testimonial->profile_picture)) {
            Storage::disk('public')->delete($testimonial->profile_picture);
        }

        // Delete cover image if exists
        if ($testimonial->cover_image && Storage::disk('public')->exists($testimonial->cover_image)) {
            Storage::disk('public')->delete($testimonial->cover_image);
        }

        // No file to delete for YouTube since it's just a link

        // Delete testimonial record
        $testimonial->delete();

        // Clear cached testimonial pages
        foreach (range(1, 5) as $page) {
            Cache::forget("models_page_{$page}");
        }

        Cache::forget('models_testimonials');

        return redirect()
            ->route('testimonials.index') // use .index to match RESTful routes
            ->with('success', 'Testimonial deleted successfully!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['upload' => 'required|image|max:5120']);

        try {
            $path = $request->file('upload')->store('uploads/testimonials', 'public');
            return response()->json([
                'url' => asset(Storage::disk('public')->url($path))
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
