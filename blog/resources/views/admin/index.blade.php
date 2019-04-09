@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary">Last new users</h1>
    <table class="table table-primary table-striped table-borderless">
        <thead class="bg-primary text-white">
            <th>Username</th>
            <th>Role</th>
            <th>Email</th>
            <th>Name</th>
            <th>Created</th>
            <th>Birthday</th>
        </thead>
        <tbody>
        @foreach ($lastusers as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td class="font-weight-bold">{{ ucfirst($user->role->name) }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name . ' ' . $user->lastname }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->birthdate }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h1 class="text-danger">Last new posts</h1>
    <table class="table table-danger table-striped table-borderless">
        <thead class="bg-danger text-white">
            <th>Title</th>
            <th>Content</th>
            <th>Tags</th>
            <th>Created</th>
            <th>Post by</th>
        </thead>
        <tbody>
        @foreach ($lastposts as $post)
            <tr>
                <td class="font-weight-bold">{{ $post->title }}</td>
                <td>{{ substr($post->content, 0, 20) }}...</td>
                <td>{{ str_replace(',', ', ', $post->tags) }}</td>
                <td>{{ $post->created }}</td>
                <td>{{ $post->user->username }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h1 class="text-success">Last new comments</h1>
    <table class="table table-success table-striped table-borderless">
        <thead class="bg-success text-white">
            <th>Content</th>
            <th>Post on</th>
            <th>Post by</th>
        </thead>
        <tbody>
        @foreach ($lastcomments as $comment)
            <tr>
                <td>{{ substr($comment->content, 0, 20) }}...</td>
                <td>{{ $comment->created_at }}</td>
                <td>{{ $comment->user->username }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection 