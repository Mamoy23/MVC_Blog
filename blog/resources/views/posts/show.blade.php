@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="card m-3">
                <div class="card-header text-center">{!! $post->title !!}</div>

                <div class="card-body">
                    <p>{!! $post->content !!}</p>
                    @foreach ( explode(',', $post->tags) as $tag)
                    <p class="badge badge-pill p-2">#{{ $tag }}</p>
                    @endforeach

                    @isset($comments)
                        <ul class="list-group text-dark col-md-10 offset-md-1 p-0">
                            @foreach ($comments as $comment)
                                <li class="list-group-item">
                                    <p><i class="fas fa-quote-left mr-1"></i> {{ $comment->content }} <i class="fas fa-quote-right ml-1"></i>
                                    @if ($comment->user_id == Auth::id())
                                    <form action="{{ route('comment.destroy', $comment->id) }}" class="deleteform m-0 position-absolute" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-danger m-1"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    @endif
                                    </p>
                                    <p class="text-right m-0"><i class="fas fa-user"></i> {{ $comment->user->username }}</p>
                                    <p class="text-right m-0">Post on {{ date_format($comment->created_at, 'd/m/y g:i A') }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                    <form action=" {{ route('comment.store') }}" method="post" class="form-group">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        <textarea name="content" rows="4" placeholder="Type your comment here..." class="form-control col-md-10 offset-md-1 {{ $errors->has('content') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn btn-dark col-md-10 offset-md-1">Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 