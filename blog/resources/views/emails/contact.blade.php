@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">Contact us</div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                <div class="card-body">
					@isset($user)
                    <form action=" {{ route('contact') }}" method="post" class="form-group">
                        @csrf
                        <input type="hidden" name="username" value="{{ $user->username }}">
						<input type="hidden" name="useremail" value="{{ $user->email }}">
                        <input type="text" name="objet" placeholder="Objet" class="form-control{{ $errors->has('objet') ? ' is-invalid' : '' }}">
                        @if ($errors->has('objet'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('objet') }}</strong>
                            </span>
                        @endif
                        <textarea name="content" cols="30" rows="12" placeholder="Type your message here" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"></textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn btn-dark">Send</button>
                    </form>
					@else
					<p>Message sent to administrators. <br /> Thank you !</p>
					@endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection