<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
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


    public function getData(Request $request)
    {
        $categories = BlogCategory::with('parent')->select('blog_category.*');

        return DataTables::eloquent($categories)
            ->addColumn('parent_name', function (BlogCategory $category) {
                return $category->parent_id == 0 ? 'None' : optional($category->parent)->name;
            })
            ->addColumn('status_label', function (BlogCategory $category) {
                return '<span class="badge ' . $category->status_badge_color . '">' . $category->status_label . '</span>';
            })
            ->addColumn('actions', function (BlogCategory $category) {
                return view('partials.category_actions', compact('category'))->render();
            })
            ->rawColumns(['status_label', 'actions'])
            ->make(true);
    }
}
