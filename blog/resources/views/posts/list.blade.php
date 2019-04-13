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
            <a href="{{ route('billet.new') }}" class="btn btn-success m-1"><i class="fas fa-plus mr-1"></i>New post</a>
            @if (!empty($posts))
                @foreach ($posts as $post)
                <div class="card m-3">
                    <div class="card-header text-center font-weight-bold" style="font-size: 20px;">{{ $post->title }}</div>

                    <div class="card-body">
                        <p>{!! $post->content !!}</p>
                        @foreach ( explode(',', $post->tags) as $tag)
                        <p class="badge badge-pill p-2">#{{ $tag }}</p>
                        @endforeach
                        <div class="d-flex float-right">
                            <a href="{{ route('billet.edit', $post->id) }}" class="btn btn-dark m-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('billet.destroy', $post->id) }}" class="deleteform" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit" class="btn btn-danger m-1"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <p class="text-white m-1"><i class="fas fa-arrow-up mr-1"></i>Post for the first time</p>
            @endif
        </div>
    </div>
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