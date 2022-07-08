<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::ActivePost()
            ->with('user:id,name')
            ->with('categories:name,slug')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return Inertia::render('Post/Index', ['posts' => $posts]);
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get()->toArray();

        //return ['categories' => $categories];

        return Inertia::render('Post/Create', ['categories' => $categories]);
    }
}
