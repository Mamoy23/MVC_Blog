<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Comment;
use App\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        $lastusers = User::latest()->limit(10)->get();
        $lastposts = Post::latest()->limit(10)->get();
        $lastcomments = Comment::latest()->limit(10)->get();

        return view('admin.index', compact('lastusers', 'lastposts', 'lastcomments'));
    }

    public function users()
    {
        $users = User::where('id', '!=', Auth::id())->paginate(10);

        $roles = Role::all();

        return view('admin.show', compact('users', 'roles'));
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

    public function banUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $user = User::find($request->id);
        $user->status = 1;
        $user->save();

        return redirect()->route('admin.users');
    }

    public function debanUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $user = User::find($request->id);
        $user->status = 0;
        $user->save();

        return redirect()->route('admin.users');
    }

    public function updateUserRole(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'role' => 'required'
        ]);

        $user = User::find($request->user_id);
        $user->role_id = $request->role;
        $user->save();

        return redirect()->route('admin.users');
    }
}
