<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
        return Inertia::render('Post/Form');
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

    public function edit($id)
    {
        $post = Post::with('categories:id')->with('tags:id')->findOrFail($id);

        if ($post->user_id != Auth::user()->id) {
            return redirect('/posts')->with('message', 'You can not edit this post.');
        }

        return Inertia::render('Post/Form', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::user()->id) {
            return redirect('/posts')->with('message', 'You can not edit this post.');
        }

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

        $post->update($params);
        $post->categories()->sync($params['category']);
        $post->tags()->sync($params['tag']);

        return redirect('/posts')->with('message', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::user()->id) {
            return redirect('/posts')->with('message', 'You can not delete this post.');
        }

        $post->categories()->detach($post->category);
        $post->tags()->detach($post->tag);
        $post->delete();
        return redirect('/posts')->with('message', 'Post deleted successfully.');
    }
}
