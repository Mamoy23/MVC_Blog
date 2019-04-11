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
            
            @foreach ($results as $result)
            <div class="card m-3">
                <div class="card-header text-center">
                    <form action="{{ route('billet.search.show', $result->id) }}" method="get">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <button type="submit" class="btn btn-link">{!! $result->title !!}</button>
                    </form>
                    <!-- <a href="{{ route('billet.search.show', $result->id) }}">{!! $result->title !!}</a> -->
                </div>

                <div class="card-body pb-0">
                    <p>{!! substr($result->content, 0, 200) !!}</p>
                    @foreach ( explode(',', $result->tags) as $tag)
                    <p class="badge badge-pill p-2">#{{ $tag }}</p>
                    @endforeach
                </div>

                @if (count($result->comments) > 0)
                <div class="text-center">
                    <p class="badge badge-pill">{{ count($result->comments) }} <i class="fas fa-comment-dots ml-1"></i></p>
                </div>
                @endif
                
                <div class="text-center">
                    <a href="{{ route('billet.show', $result->id) }}" class="btn btn-dark mb-1">Add a comment</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection