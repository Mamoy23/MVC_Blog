<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(User $user)
    {
        Chat::where('from_id', $user->id)
        ->where('to_id', Auth::id())
        ->update(['status' => 1]);

        $count = Chat::selectRaw('COUNT(case status when 0 then 1 else null end) AS c, from_id')
        ->where('to_id', Auth::id())
        ->groupBy('from_id')
        ->pluck('c', 'from_id');

        $countAll = Chat::where('to_id', Auth::id())
            ->where('status', 0)
            ->count();

        $users = User::all()->where('id', '!=', Auth::id());

        $msgs = Chat::where(function ($query) use($user){
                $query->where('from_id', Auth::id())
                    ->where('to_id', $user->id);
                })
                ->orWhere(function ($query) use($user){
                $query->where('from_id', $user->id)
                    ->where('to_id', Auth::id());
                })
                ->oldest()
                ->get();
        return view('chats.conv', compact('users', 'user', 'msgs', 'count', 'countAll'));
    }

    public function store(User $user, Request $request)
    {
        $id_user = Auth::id();

        $this->validate($request, [
            'content' => 'required|max:1000',
        ]);

        $msg = Chat::create([
            'from_id' => $id_user,
            'to_id' => $user->id,
            'content' => $request->content,
            'status' => 0
        ]);
        $msg->save();

        return redirect()->route('chat.conv', $user)->with('success', 'Your message is sent !');
    }
}
