<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogTag;
use App\Models\Blog;
use App\Models\BlogCategory;
use Carbon\Carbon;

class BlogController extends Controller
{
    //

    public function index()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        $blogs = Blog::all();
        return view('blog.blog_view', compact('blogs', 'categories', 'tags'));
    }
    public function create()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('blog.create', compact('categories', 'tags'));
    }

    public function edit($id)
    {
        $blog = Blog::with('categories', 'tags')->findOrFail($id);
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('blog.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'short_description' => 'required|string',
            'status' => 'required|integer',
            'isFeatured' => 'nullable|boolean',
            'featured_image' => 'nullable|string',
        ]);

        $blog = Blog::findOrFail($id);
        $data = $request->only('title', 'content', 'short_description', 'status');
        $data['isFeatured'] = $request->has('isFeatured') ? 1 : 0;

        $data['featured_image'] = $request->featured_image ? $request->featured_image :  asset('storage/images/default-image.png');

        $blog->update($data);

        if ($request->has('categories')) {
            $blog->categories()->sync($request->categories);
        }

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'Tag deleted successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'isFeatured' => 'boolean',
            'short_description' => 'required|string|max:255',
            'featured_image' => 'nullable|string',
            'status' => 'required|integer',
            'categories' => 'array',
            'categories.*' => 'integer|exists:blog_category,id',
            'tags' => 'array',
            'tags.*' => 'integer|exists:blog_tag,id',
        ]);

        $data = $request->only('title', 'content', 'short_description', 'status');
        $data['isFeatured'] = $request->has('isFeatured') ? 1 : 0;


        $data['featured_image'] = $request->featured_image ? $request->featured_image :  asset('storage/images/default-image.png');


        $blog = Blog::create($data);

        $currentTimestamp = Carbon::now();

        if ($request->has('categories')) {
            foreach ($request->categories as $category) {
                $blog->categories()->attach($category, ['created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp]);
            }
        }

        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $blog->tags()->attach($tag, ['created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp]);
            }
        }

        return redirect()->route('blog.create')->with('success', 'Blog created successfully');
    }
}
