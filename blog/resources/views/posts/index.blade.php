@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if(count($errors) > 0)
            <div class="alert alert-danger" role="alert">
                <ul>
                @foreach($errors->all() as $error)
                    <li class="list-unstyled">{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @endif
            
            @foreach ($posts as $post)
                <div class="card m-3 text-dark">
                    <div class="card-header font-weight-bold text-center" style="font-size: 20px;">
                        {{ $post->title }}
                    </div>
                    
                    <p class="position-absolute" style="right: 15px; top: 15px; font-size:15px;"><i class="fas fa-user mr-1"></i>{{ $post->user->username }}</p>

                    <div class="card-body p-4">
                        <p>{!! $post->content !!}</p>
                        @foreach ( explode(',', $post->tags) as $tag)
                            <p class="badge badge-pill">#{{ $tag }}</p>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <p class="badge badge-pill m-0 mr-1">{{ count($post->comments) }} <i class="fas fa-comment-dots ml-1"></i></p>
                            </div>
                        <div class="text-center">
                            <a href="{{ route('billet.show', $post->id) }}" class="btn btn-link mb-1"><i class="fas fa-search-plus fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            <p>{{ $posts->render()}}</p>
        </div>
    </div>
</div>
@endsection