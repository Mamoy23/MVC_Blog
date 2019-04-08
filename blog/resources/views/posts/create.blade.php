@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">Create a post</div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                <div class="card-body">
                    <form action=" {{ route('post.store') }}" method="post" class="form-group">
                        @csrf
                        <input type="text" name="title" placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                        <textarea name="content" cols="30" rows="7" placeholder="Content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                        <input type="text" name="tags" class="form-control w-100{{ $errors->has('tags') ? ' is-invalid' : '' }}" placeholder="Tags" data-role="tagsinput">
                        @if ($errors->has('tags'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tags') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn btn-dark">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection