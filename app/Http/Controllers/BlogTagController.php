<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::all();
        return view('blog.blog_tag', compact('tags'));
    }
    public function destroy($id)
    {
        $tag = BlogTag::findOrFail($id);
        $tag->delete();

        return redirect()->route('blog_tags.index')->with('success', 'Tag deleted successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        BlogTag::create([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('blog_tags.index')->with('success', 'Tag created successfully.');
    }

    public function update(Request $request, BlogTag $blogTag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $blogTag->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('blog_tags.index')->with('success', 'Tag updated successfully.');
    }
    public function getData(Request $request)
    {
        $tags = BlogTag::select('blog_tag.*');

        return DataTables::eloquent($tags)
            ->addIndexColumn()
            ->addColumn('status_label', function (BlogTag $tag) {
                return '<span class="badge ' . $tag->status_badge_color . '">' . $tag->status_label . '</span>';
            })
            ->addColumn('formatted_created_at', function (BlogTag $tag) {
                return $tag->created_at->format('d M Y');
            })
            ->addColumn('actions', function (BlogTag $tag) {
                return view('partials.tag_actions', compact('tag'))->render();
            })
            ->rawColumns(['status_label', 'actions'])
            ->make(true);
    }
}
