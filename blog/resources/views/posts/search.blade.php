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
            
            @if (!empty($results->first()))
                @foreach ($results as $result)
                <div class="card m-3">
                    <div class="card-header font-weight-bold text-center">
                        <form action="{{ route('billet.search.show', $result->id) }}" method="get">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <button type="submit" class="btn btn-link" style="font-size: 20px;">{!! $result->title !!}</button>
                        </form>
                    </div>

                    <p class="position-absolute" style="right: 15px; top: 15px; font-size:15px;"><i class="fas fa-user mr-1"></i>{{ $result->user->username }}</p>

                    <div class="card-body p-4">
                        <p>{!! substr($result->content, 0, 200) !!}</p>
                        @foreach ( explode(',', $result->tags) as $tag)
                            <p class="badge badge-pill">#{{ $tag }}</p>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <p class="badge badge-pill m-0 mr-1">{{ count($result->comments) }} <i class="fas fa-comment-dots ml-1"></i></p>
                            </div>
                        <div class="text-center">
                            <a href="{{ route('billet.show', $result->id) }}" class="btn btn-link mb-1"><i class="fas fa-search-plus fa-lg"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-center text-white">No post found, sorry.</p>
            @endif
        </div>
    </div>
</div>
@endsection