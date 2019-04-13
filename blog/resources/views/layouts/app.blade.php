<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
    <script>tinymce.init({ 
        selector:'textarea#editable',
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
        plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table contextmenu directionality emoticons template paste textcolor'
        ],
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                        </ul>
                        
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('inscription') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                                @if (Auth::user()->role->name === 'administrator')
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-user-cog mr-1"></i>Admin <span class="caret"></span>
                                    </a>
                                    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('admin.index') }}">
                                            {{ __('Home') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.users') }}">
                                            {{ __('Users') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.posts') }}">
                                            {{ __('Posts') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.comments') }}">
                                            {{ __('Comments') }}
                                        </a>
                                    </div>

                                </li>
                                @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user mr-1"></i>{{ Auth::user()->username }} <span class="caret"></span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-1"></i>{{ __('Logout') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                    </form>
                                    @if (Auth::user()->status != 1)
                                        <a class="dropdown-item" href="{{ route('billet.index') }}">
                                            <i class="far fa-newspaper mr-1"></i>{{ __('Posts') }}
                                        </a>
                                        @if (Auth::user()->role->name === 'administrator' || Auth::user()->role->name === 'blogger')
                                        <a class="dropdown-item" href="{{ route('billet.list') }}">
                                            <i class="fas fa-list-ul mr-1"></i>{{ __('My posts') }}
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('contact.form') }}">
                                            <i class="fas fa-envelope mr-1"></i>{{ __('Contact') }}
                                        </a>
                                        </div>
                                    @endif
                            </li>
                            @if (Auth::user()->status != 1)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-paper-plane mr-1 text-primary"></i>Chat <span class="caret"></span>
                                        @if (isset($countAll) && ($countAll != 0))
                                        <span class="badge badge-pill ml-1" style="font-size: 12px"> {{ $countAll }} </span>
                                        @endif
                                    </a>
                                    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @foreach ($chatUsers as $user)
                                        <a class="dropdown-item" href="{{ route('chat.conv', $user->id) }}">
                                            {{ $user->username }}
                                            @if (isset($count[$user->id]) && $count[$user->id] != 0)
                                                <span class="badge badge-pill m-2" style="font-size: 12px"> {{ $count[$user->id] }} </span>
                                            @endif
                                        </a>
                                        @endforeach
                                    </div>

                                </li>
                            @endif
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

                @if (Auth::check())
                <div class="m-2 d-flex justify-content-center">
                    <form action="{{ route('billet.search') }}" method="get" class="form-inline">
                        <input type="text" name="search" placeholder="Search a post" class="form-control" value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-outline-success ml-1">Search</button>
                    </form>
                </div>
                @endif
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
        </body>
</html>
