<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Inertia\Inertia;

class BlogController extends Controller
{

    public function __construct()
    {
        Inertia::setRootView('blog');
    }

    public function index()
    {
        $posts = Post::ActivePost()
            ->with('user:id,name')
            ->with('categories:name,slug')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Blog/Index', ['posts' => $posts]);
    }

    public function show($slug)
    {
        $post = Post::ActivePost()
            ->with('user:id,name')
            ->with('categories:slug,name')
            ->with('tags:slug,name')
            ->where('slug', $slug)
            ->firstOrFail();

        // $next = Post::ActivePost()->where('id', '>', $post->id)->orderBy('id')->first();
        // $previous = Post::ActivePost()->where('id', '<', $post->id)->orderBy('id', 'desc')->first();

        return Inertia::render('Blog/Show', [
            'post' => $post,
            'nextPost' => $post->next_post,
            'prevPost' => $post->prev_post,
        ]);
    }

    public function user_posts($userID)
    {
        $posts = Post::ActivePost()
            ->where('user_id', $userID)
            ->with('user:id,name')
            ->with('categories:name,slug')
            ->orderBy('created_at', 'desc')
            ->get();

        $user_posts = User::where('id', $userID)->value('name');

        return Inertia::render('Blog/Index', ['posts' => $posts, 'user_posts' => $user_posts]);
    }

    public function category($slug)
    {
        // This is bad for performance
        // $posts = Post::ActivePost()
        // ->whereHas('categories', fn(Builder $query) => $query->where('slug', $slug))
        // ->with('user:id,name')
        // ->with('categories:name,slug')
        // ->orderBy('created_at', 'desc')
        // ->get();

        $posts = Post::ActivePost()
            ->whereRelation('categories', 'slug', $slug)
            ->with('user:id,name')
            ->with('categories:name,slug')
            ->orderBy('created_at', 'desc')
            ->get();

        $category = Category::where('slug', $slug)->value('name');

        return Inertia::render('Blog/Index', ['posts' => $posts, 'category' => $category]);
    }

    public function tag($slug)
    {
        $posts = Post::ActivePost()
            ->whereRelation('tags', 'slug', $slug)
            ->with('user:id,name')
            ->with('categories:name,slug')
            ->orderBy('created_at', 'desc')
            ->get();

        $tag = Tag::where('slug', $slug)->value('name');

        return Inertia::render('Blog/Index', ['posts' => $posts, 'tag' => $tag]);
    }

    public function showCategoryList()
    {
        $catList = Category::select('name', 'slug')->get();

        return Inertia::render('Components/Sidebar', ['catList' => $catList]);
    }
}
