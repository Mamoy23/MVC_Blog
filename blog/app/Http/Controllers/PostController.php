<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(2);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required|max:1000',
            'tags' => 'required|max:500'
        ]);

        $post = Post::create([
            'title' => strip_tags($request->title),
            'content' => strip_tags($request->content),
            'tags' => strip_tags($request->tags),
            'user_id' => Auth::id()
        ]);
        $post->save();

        return redirect()->route('post.list')->with('success', 'Your post is online !');
    }

    public function show($id)
    {

    }

    public function list()
    {
        $posts = Post::where('user_id', Auth::id())->get();
        
        return view('posts.list', compact('posts'));
    }

    public function edit($id)
    {
        $post = Post::find($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required|max:1000',
            'tags' => 'required|max:500'
        ]);

        $post = Post::find($id);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->tags = $request->tags;
        $post->save();

        return redirect()->route('post.list')->with('success', 'Post updated !');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        return redirect()->route('post.list')->with('success', 'Post deleted !');
    }
}
