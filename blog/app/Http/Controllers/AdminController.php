<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;

class AdminController extends Controller
{
    public function index()
    {
        $lastusers = User::latest()->limit(10)->get();
        $lastposts = Post::latest()->limit(10)->get();
        $lastcomments = Comment::latest()->limit(10)->get();

        return view('admin.index', compact('lastusers', 'lastposts', 'lastcomments'));
    }

    public function users()
    {
        $users = User::paginate(10);

        return view('admin.show', compact('users'));
    }

    public function posts()
    {
        $posts = Post::paginate(10);

        return view('admin.show', compact('posts'));
    }

    public function comments()
    {
        $comments = Comment::paginate(10);

        return view('admin.show', compact('comments'));
    }
}
