<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $blogs = Blog::where('user_id', Auth::id())->get();
            return view('theme.blogs.index', compact('blogs'));
        }
        return redirect()->route('theme.index')->with('error', 'You must be logged in to view your blogs.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $categories = Category::get();
            return view('theme.blogs.create', compact('categories'));
        }
        return redirect()->route('theme.index')->with('error', 'You must be logged in to create a blog.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
        $imageName = $request->image;
        $newimage = time() . '.' . $imageName->getClientOriginalName();
        $imageName = Storage::disk('public')->putFileAs('blogs', $request->file('image'), $newimage);
        $data['image'] = $imageName;
        $data['user_id'] = Auth::id();
        Blog::create($data);
        return redirect()->route('blogs.create')->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('theme.blogs', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if (Auth::check() && Auth::id() == $blog->user_id) {
            $categories = Category::get();
            return view('theme.blogs.edit', compact('categories', 'blog'));
        }
        return redirect()->route('theme.index')->with('error', 'You must be logged in Or You are not authorized to edit this blog.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        if (Auth::check() && Auth::id() != $blog->user_id) {
            return redirect()->route('theme.index')->with('error', 'You are not authorized to edit this blog.');
        }
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($blog->image);
            $imageName = $request->image;
            $newimage = time() . '.' . $imageName->getClientOriginalName();
            $imageName = Storage::disk('public')->putFileAs('blogs', $request->file('image'), $newimage);
            $data['image'] = $imageName;
        }
        $blog->update($data);
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (Auth::check() && Auth::id() == $blog->user_id) {
            Storage::disk('public')->delete($blog->image);
            $blog->delete();
            return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
        }
        return redirect()->route('theme.index')->with('error', 'You are not authorized to delete this blog.');
    }
}
