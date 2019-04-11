<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required',
            'content' => 'required|max:1000',
        ]);

        $comment = Comment::create([
            'content' => strip_tags($request->content),
            'user_id' => Auth::id(),
            'post_id' => $request->post_id
        ]);
        $comment->save();

        return redirect()->route('billet.show', $request->post_id)->with('success', 'Your comment is online !');
    }

    public function edit($id)
    {   
        $comment = Comment::find($id);

        if($comment->user_id === Auth::id() || Auth::user()->role->name === 'administrator')
        return view('comments.edit', compact('comment'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:1000',
        ]);

        $comment = Comment::find($id);
        
        if($comment->user_id === Auth::id() || Auth::user()->role->name === 'administrator'){
            $comment->content = $request->content;
            $comment->save();
        }

        return redirect()->route('billet.show', $comment->post_id)->with('success', 'Comment updated !');

    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if($comment->user_id === Auth::id() || Auth::user()->role->name == 'administrator'){
            $comment->delete();
        }
        return redirect()->route('billet.show', $comment->post_id)->with('success', 'Comment deleted !');
        
    }
}
