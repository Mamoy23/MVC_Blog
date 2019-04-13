@extends('layouts.app')

@section('content')
<div class="container">
    @isset($users)
    <h1 class="text-primary">Users</h1>
    <table class="table table-primary table-striped table-borderless">
        <thead class="bg-primary text-white text-center">
            <th>Username</th>
            <th>Role</th>
            <th>Email</th>
            <th>Name</th>
            <th>Created</th>
            <th>Birthday</th>
            <td>Ban | Unban</td>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td class="font-weight-bold">
                    <form action="{{ route('admin.role') }}" method="post" class="form-inline">
                        @csrf               
                        <select name="role" class="custom-select text-primary">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-dark">Ok</button>
                    </form>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name . ' ' . $user->lastname }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->birthdate }}</td>
                @if ($user->status == 0)
                <td>
                    <form action="{{ route('admin.ban') }}" method="POST" class="text-center">
                    @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-danger" title="Ban"><i class="fas fa-ban"></i></button>
                    </form>
                </td>
                @else
                <td>
                    <form action="{{ route('admin.deban') }}" method="POST" class="text-center">
                    @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-success" title="Unban"><i class="fas fa-lock-open"></i></button>
                    </form>
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->render() }}
    @endisset

    @isset($posts)
    <h1 class="text-danger">Posts</h1>
    <table class="table table-danger table-striped table-borderless">
        <thead class="bg-danger text-white">
            <th>Title</th>
            <th>Content</th>
            <th>Tags</th>
            <th>Created</th>
            <th>Post by</th>
            <th></th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td class="font-weight-bold">{{ $post->title }}</td>
                <td>{{ substr($post->content, 0, 20) }}</td>
                <td>{{ str_replace(',', ', ', $post->tags) }}</td>
                <td>{{ $post->created }}</td>
                <td>{{ $post->user->username }}</td>
                <td>
                    <a href="{{ route('billet.show', $post->id) }}" class="btn btn-dark m-1"><i class="fas fa-search-plus"></i></a>
                </td>
                <td>
                    <a href="{{ route('billet.edit', $post->id) }}" class="btn btn-dark m-1"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                    <form action="{{ route('billet.destroy', $post->id) }}" class="deleteform" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE" />
                        <button type="submit" class="btn btn-danger m-1"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $posts->render() }}
    @endisset

    @isset($comments)
    <h1 class="text-success">Comments</h1>
    <table class="table table-success table-striped table-borderless">
        <thead class="bg-success text-white">
            <th>Content</th>
            <th>Post on</th>
            <th>Post by</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
        @foreach ($comments as $comment)
            <tr>
                <td>{{ substr($comment->content, 0, 20) }}...</td>
                <td>{{ $comment->created_at }}</td>
                <td>{{ $comment->user->username }}</td>
                <td>
                    <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-dark m-1"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                    <form action="{{ route('comment.destroy', $comment->id) }}" class="deleteform" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE" />
                        <button type="submit" class="btn btn-danger m-1"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $comments->render() }}
    @endisset
</div>

<script>
    $(document).ready(function(){
        $('.deleteform').on('submit', function(){
            if(confirm('Are you sure you want to delete this post?')){
                return true;
            }
            else{
                return false;
            }
        });
    });
</script>

@endsection 