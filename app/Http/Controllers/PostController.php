<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        return Inertia::render('Post/Create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => [
                'required',
                'string'
            ],
            'body' => [
                'string'
            ],
            'category' => [
                'required',
                'array'
            ],
            'tag' => [
                'required',
                'array'
            ],
        ])->validate();

        $params = $request->all();
        $params['slug'] = Str::slug($params['title']);
        $params['user_id'] = $request->user()->id;
        $params['post_type'] = Post::POST;
        $params['status'] = Post::ACTIVE;

        $post = Post::create($params);
        $post->categories()->attach($params['category']);
        $post->tags()->attach($params['tag']);

        return redirect('/posts')->with('message', 'Post created successfully.');
    }
}
