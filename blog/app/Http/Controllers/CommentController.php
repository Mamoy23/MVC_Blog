<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;

class CommentController extends Controller
{
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
}
