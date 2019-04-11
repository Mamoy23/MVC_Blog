<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Post;
use App\Comment;
use App\User;
use App\Mail\Contact;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('blogger', ['except' => ['index', 'show', 'contact']]);
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
        if($post->user_id === Auth::id() || Auth::user()->role->name === 'administrator')
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
        
        if($post->user_id === Auth::id() || Auth::user()->role->name === 'administrator'){
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

        if($post->user_id === Auth::id() || Auth::user()->role->name == 'administrator'){
            $post->delete();
        }
        else {
            return redirect()->route('billet.list')->with('success', 'Sorry its not your post');
        }
        return redirect()->route('billet.list')->with('success', 'Post deleted !');
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $this->validate($request, [
            'search' => 'required|max:255'
        ]);
        
        $posts = Post::all();
        $tags = [];
        foreach($posts as $post){
            foreach(explode(',', $post->tags) as $tag){
                if(levenshtein($search, $tag) <= 3) {
                    $tags[] = $tag;
                }
            }
        }

        // $results = Post::where('title', 'like', '%'.$search.'%')
        //         ->orWhere('content', 'like', '%'.$search.'%')
        //         ->get();

        $query = Post::query();
        $query->where('title', 'like', '%'.$search.'%')
            ->orWhere('content', 'like', '%'.$search.'%');
            foreach($tags as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
            $results = $query->get();

        foreach($results as &$result){
            
        $result->title = str_replace($search,"<mark class='highlight p-0'>$search</mark>",$result->title);
        $result->content = str_replace($search,"<mark class='highlight p-0'>$search</mark>",$result->content);

        $result->content = str_replace(strtolower($search),"<mark class='highlight p-0'>$search</mark>",$result->content);
        $result->title = str_replace(strtolower($search),"<mark class='highlight p-0'>$search</mark>",$result->title);

        $result->content = str_replace(ucfirst($search),"<mark class='highlight p-0'>".strtolower($search)."</mark>",$result->content);
        $result->title = str_replace(ucfirst($search),"<mark class='highlight p-0'>$search</mark>",$result->title);

        }
        return view('posts.search', compact('results', 'search'));
    }

    public function searchPost(Request $request, $id)
    {
        $search = $request->search;

        $post = Post::find($id);
        $comments = Post::find($id)->comments;

        $post->title = str_replace($search,"<mark class='highlight p-0'>$search</mark>",$post->title);
        $post->content = str_replace($search,"<mark class='highlight p-0'>$search</mark>",$post->content);

        $post->content = str_replace(strtolower($search),"<mark class='highlight p-0'>$search</mark>",$post->content);
        $post->title = str_replace(strtolower($search),"<mark class='highlight p-0'>$search</mark>",$post->title);

        $post->content = str_replace(ucfirst($search),"<mark class='highlight p-0'>".strtolower($search)."</mark>",$post->content);
        $post->title = str_replace(ucfirst($search),"<mark class='highlight p-0'>$search</mark>",$post->title);
        
        return view('posts.show', compact('post', 'comments'));
    }

    public function contact()
    {
        $data = ['message' => 'This is a test!'];
        
        Mail::to('john@example.com')->send(new Contact($data));
        // $user = Auth::user();

        // return view('contact', compact('user'));
    }
}
