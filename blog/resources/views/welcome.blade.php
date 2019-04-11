@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Welcome</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::check())
                    @if (Auth::user()->status == 0)

                    <p>Welcome to blog</p>

                    @else 

                    <p class="alert alert-danger">You have been ban from Blog, sorry</p>

                    @endif
                    @endif

                    <p>Make your own blog !</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
