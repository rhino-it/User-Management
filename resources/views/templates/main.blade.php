<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'User Management System') }}</title>
    <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="#">{{ config('app.name', 'User Management System') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

{{--        <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--            <ul class="navbar-nav mr-auto">--}}
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="#">Home</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>--}}
{{--                </li>--}}
{{--            </ul>--}}

{{--        </div>--}}
        <div class="form-inline my-2 my-lg-0">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ route('user.profile') }}">Profile</a>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>

@can('logged-in')
<nav class="navbar sub-nav navbar-expand-lg">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                @can('is-admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>
@endcan


<main class="container">
    @include('partials.alerts')
    @yield('content')
</main>

</body>
</html>
