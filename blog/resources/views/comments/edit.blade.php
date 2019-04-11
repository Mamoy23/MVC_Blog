@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit comment</div>

                <div class="card-body">
                    <form action=" {{ route('comment.update', $comment->id) }}" method="post" class="form-group">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <textarea name="content" rows="4" placeholder="Type your comment here..." class="form-control col-md-10 offset-md-1 {{ $errors->has('content') ? ' is-invalid' : '' }}">
                            {{ $comment->content }}
                        </textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn btn-dark col-md-10 offset-md-1">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection