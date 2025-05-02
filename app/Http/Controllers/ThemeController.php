<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;

class ThemeController extends Controller
{
    //
    public function index()
    {
        $blogs = Blog::paginate(5);
        return view('theme.index', compact('blogs'));
    }
    public function category($id)
    {
        $CategoryName = Category::find($id)->name;
        $blogs = Blog::where('category_id', $id)->paginate(5);
        return view('theme.category', compact('blogs', 'CategoryName'));
    }
    public function contact()
    {
        return view('theme.contact');
    }

    public function register()
    {
        return view('theme.register');
    }
    public function login()
    {
        return view('theme.login');
    }
}
