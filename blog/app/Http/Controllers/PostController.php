<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;
use App\User;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('blogger', ['except' => ['index', 'show']]);
        //$this->middleware('auth', ['except' => 'index']);
    }

    public function index()
    {
        $posts = Post::paginate(2);

        return view('posts.index', compact('posts', 'nbrComments'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'required|max:500'
        ]);

        $post = Post::create([
            'title' => strip_tags($request->title),
            'content' => $request->content,
            'tags' => strip_tags($request->tags),
            'user_id' => Auth::id(),
            'created' => NOW()
        ]);
        $post->save();

        return redirect()->route('billet.list')->with('success', 'Your post is online !');
    }

    public function show($id)
    {
        $post = Post::find($id);
        $comments = Post::find($id)->comments;
        
        return view('posts.show', compact('post', 'comments'));
    }

    public function list()
    {
        $posts = Post::where('user_id', Auth::id())->get();
    
        return view('posts.list', compact('posts'));
    }

    public function edit($id)
    {   
        $post = Post::find($id);
        if($post->user_id === Auth::id())
        return view('posts.edit', compact('post'));
        else
        return redirect()->route('billet.list')->with('success', 'Sorry its not your post');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required|max:1000',
            'tags' => 'required|max:500'
        ]);

        $post = Post::find($id);
        if($post->user_id === Auth::id()){
            $post->title = $request->title;
            $post->content = $request->content;
            $post->tags = $request->tags;
            $post->updated = NOW();
            $post->save();
        }
        else {
            return redirect()->route('billet.list')->with('success', 'Sorry its not your post');
        }
        return redirect()->route('billet.list')->with('success', 'Post updated !');

    }

    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        return redirect()->route('billet.list')->with('success', 'Post deleted !');
    }
}
