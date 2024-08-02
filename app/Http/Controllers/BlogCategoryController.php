<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::with('parent')->get();
        return view('blog.blog_category', compact('categories'));
    }
    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('blog_categories.index')->with('success', 'Tag deleted successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'parent_id' => 'required|integer',
        ]);

        // Tính toán level dựa trên parent_id
        $level = 0;

        if ($request->parent_id != 0) {
            var_dump($request->parent_id);
            $parentCategory = BlogCategory::find($request->parent_id);
            $level = $parentCategory->level + 1;
        }

        BlogCategory::create([
            'name' => $request->name,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
            'level' => $level,
        ]);

        return redirect()->route('blog_categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'parent_id' => 'nullable|exists:blog_category,id',
        ]);

        // Tính toán level dựa trên parent_id
        $level = 0;
        if ($request->parent_id) {
            $parentCategory = BlogCategory::find($request->parent_id);
            $level = $parentCategory->level + 1;
        }

        $blogCategory->update([
            'name' => $request->name,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
            'level' => $level,
        ]);

        return redirect()->route('blog_categories.index')->with('success', 'Category updated successfully.');
    }
}
