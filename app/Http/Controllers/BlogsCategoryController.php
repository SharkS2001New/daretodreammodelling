<?php

namespace App\Http\Controllers;

use App\Models\BlogsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BlogsCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogsCategory::all();
        return view('blogs_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('blogs_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'blogs_category_title' => 'required|string|max:255',
        ]);

        BlogsCategory::create($request->only('name', 'blogs_category_title'));

        return redirect()->route('blogs-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(BlogsCategory $blogs_category)
    {
        return view('blogs_categories.edit', compact('blogs_category'));
    }

    public function update(Request $request, BlogsCategory $blogs_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'blogs_category_title' => 'required|string|max:255',
        ]);

        $blogs_category->update($request->only('name', 'blogs_category_title'));

        return redirect()->route('blogs-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(BlogsCategory $blogs_category)
    {
        $blogs_category->delete();


        return redirect()->route('blogs-categories.index')->with('success', 'Category deleted.');
    }
}
