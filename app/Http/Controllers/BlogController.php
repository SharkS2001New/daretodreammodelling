<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'ALL');
        $page = $request->query('page', 1); // for paginated cache keys

        // Cache categories for dropdown (no need to query each time)
        $categories = Cache::rememberForever('blog_categories', function () {
            return BlogsCategory::all();
        });

        // Build cache key depending on filters + page
        $cacheKey = "blogs_index_{$selectedCategory}_page_{$page}";

        $blogs = Cache::remember($cacheKey, 600, function () use ($selectedCategory) {
            $query = Blog::with(['category', 'user'])->latest();

            if ($selectedCategory && $selectedCategory !== 'ALL') {
                $query->whereHas('category', function ($q) use ($selectedCategory) {
                    $q->where('name', $selectedCategory);
                });
            }

            return $query->paginate(6);
        });

        return view('blogs.index', compact('blogs', 'categories', 'selectedCategory'));
    }


    public function create()
    {
        $categories = BlogsCategory::all();

        return view('blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'excerpt'           => 'nullable|string|max:500',
            'content'           => 'required|string',
            'blogs_category_id' => 'required|exists:blogs_categories,id',
            'image'             => 'nullable|image|max:2048',
            'model'             => 'nullable|string|max:255',
            'photographer'      => 'nullable|string|max:255',
            'magazine'          => 'nullable|string|max:255',
            'brand'             => 'nullable|string|max:255',
        ]);

        // Handle file upload
        $path = $request->file('image') 
            ? $request->file('image')->store('blogs', 'public') 
            : null;

        // Generate slug
        $slug = Str::slug($validated['title']);

        // Estimate read time
        $wordCount = str_word_count(strip_tags($validated['content']));
        $readTime = ceil($wordCount / 60);

        Blog::create([
            'title'             => $validated['title'],
            'excerpt'           => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150),
            'content'           => $validated['content'],
            'slug'              => $slug,
            'image'             => $path ? "/storage/$path" : null,
            'blogs_category_id' => $validated['blogs_category_id'],
            'user_id'           => Auth::id(),
            'read_time'         => $readTime,
            'published_at'      => now(),
            'model'             => $validated['model'] ?? null,
            'photographer'      => $validated['photographer'] ?? null,
            'magazine'          => $validated['magazine'] ?? null,
            'brand'             => $validated['brand'] ?? null,
        ]);

        Cache::store('file')->flush();

        return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        // Optional: check ownership if needed
        if ($blog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = BlogsCategory::all();

        return view('blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        // Ownership check
        if ($blog->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'excerpt'           => 'nullable|string|max:500',
            'content'           => 'required|string',
            'blogs_category_id' => 'required|exists:blogs_categories,id',
            'image'             => 'nullable|image|max:2048',
            'model'             => 'nullable|string|max:255', // Added
            'photographer'      => 'nullable|string|max:255', // Added
            'magazine'          => 'nullable|string|max:255', // Added
            'brand'             => 'nullable|string|max:255', // Added
        ]);

        // Handle file upload (keep old if none uploaded)
        $path = $blog->image;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $path = "/storage/$path";
            
            // Delete old image if it exists and new one is uploaded
            if ($blog->image && \Storage::disk('public')->exists(str_replace('/storage/', '', $blog->image))) {
                \Storage::disk('public')->delete(str_replace('/storage/', '', $blog->image));
            }
        }

        // Generate slug again if title changes
        $slug = $blog->title !== $validated['title'] ? Str::slug($validated['title']) : $blog->slug;

        // Estimate read time again
        $wordCount = str_word_count(strip_tags($validated['content']));
        $readTime = ceil($wordCount / 60);

        $blog->update([
            'title'             => $validated['title'],
            'excerpt'           => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 150),
            'content'           => $validated['content'],
            'slug'              => $slug,
            'image'             => $path,
            'blogs_category_id' => $validated['blogs_category_id'],
            'read_time'         => $readTime,
            'model'             => $validated['model'] ?? null, // Added
            'photographer'      => $validated['photographer'] ?? null, // Added
            'magazine'          => $validated['magazine'] ?? null, // Added
            'brand'             => $validated['brand'] ?? null, // Added
        ]);

        Cache::store('file')->flush();

        return redirect()->route('blog.index')
                        ->with('success', 'Blog updated successfully.');
    }

    public function show(Blog $blog, $slug)
    {
        $cacheKey = "blog_{$slug}";

        $blog = Cache::rememberForever($cacheKey, function () use ($slug) {
            return Blog::with(['category', 'user'])->where('slug', $slug)->firstOrFail();
        });

        return view('blogs.show', compact('blog'));
    }

    // Delete blog
    public function destroy(Blog $blog)
    {
        $blog->delete();

        Cache::store('file')->flush();

        return redirect()->route('blog.index')->with('success', 'Blog deleted successfully.');
    }
}
