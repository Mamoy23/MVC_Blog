@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- <div class="card-header text-center"><i class="fas fa-comments"></i></div> -->

                <div class="card-body">
                    @if (Auth::id() == $user->id)
                    <p class="alert alert-danger">Sorry, you can't chat with yourself.</p>
                    @else
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success" role="alert">
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

                        <div class="container"> 
                            <div class="row">                     
                                <div class="list-group col-md-2" style="font-size: 18px;">
                                    @foreach ($users as $one)
                                    <a class="list-group-item" href="{{ route('chat.show', $one->id) }}">{{ $one->username }}
                                        @if (isset($count[$one->id]) && $count[$one->id] != 0)
                                            <span class="badge badge-pill badge-danger m-2"> {{ $count[$one->id] }} </span>
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-header bg-dark text-white text-center font-weight-bold" style="font-size: 15px">
                                            {{ $user->username}}
                                        </div>
                                        <div class="card-body" style="border: 1px solid">

                                            @foreach ($msgs as $msg)
                                                @if ($msg->from_id != (Auth::user()->id))
                                                <p class="text-right text-primary font-weight-bold m-0">{{ $user->username }}</p>
                                                <div class="border rounded col-md-6 offset-md-6 bg-primary text-white">
                                                    <p class="text-right m-0 pt-2" style="font-size: 15px;">{{ $msg->content }}</p>
                                                    <p class="text-left m-0">{{  date_format($msg->created_at, 'g:i A') }}</p>
                                                </div>
                                                @else
                                                <p class="m-0 text-dark font-weight-bold">Me</p>
                                                <div class="border rounded bg-dark text-white col-md-6">
                                                    <p class="text-left m-0 pt-2">{{ $msg->content }}</p>
                                                    <p class="text-right m-0">{{  date_format($msg->created_at, 'g:i A') }}</p>
                                                </div>
                                                @endif
                                            @endforeach

                                            <form action="" method="post">
                                            {{csrf_field()}}
                                                <textarea name="content" cols="3" rows="3" placeholder="Type your message" class="form-control mt-2"></textarea>
                                                <button type="submit" class="btn bg-dark text-white mt-2">Send<i class="fas fa-paper-plane ml-1"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection