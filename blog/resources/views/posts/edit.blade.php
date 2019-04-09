@extends('layouts.app')

@section('content')
<div class="container">
    @isset($post)
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">Edit</div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                <div class="card-body">
                    <form action=" {{ route('billet.update', $post->id ) }}" method="post" class="form-group">
                        @csrf
                        <input type="text" name="title" placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $post->title }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                        
                        <textarea name="content" cols="30" rows="7" placeholder="Content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}">{{ $post->content }}</textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif

                        <input type="text" name="tags" class="form-control w-100{{ $errors->has('tags') ? ' is-invalid' : '' }}" placeholder="Tags" data-role="tagsinput" value="{{ $post->tags }}">
                        @if ($errors->has('tags'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tags') }}</strong>
                            </span>
                        @endif

                        <button type="submit" class="btn btn-dark">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @else
    <p class="text-white" style="font-size: 20px;">Sorry, this post doesn't exist.</p>
    <a href="{{ route('billet.list') }}" class="btn btn-light">Go to my posts list<i class="fas fa-arrow-circle-right ml-1"></i></a>
    @endif
</div>
@endsection