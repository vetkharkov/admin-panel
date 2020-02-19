<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-image: url("{{asset('images/main.jpg')}}");
            background-size: 100% 100%;
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    {{--@if (Route::has('login'))--}}
    {{--<div class="top-right links">--}}
    {{--@auth--}}

    {{--<a href="/">{{ Auth::user()->name }}</a>--}}

    {{--<a href="{{ route('logout') }}"--}}
    {{--onclick="event.preventDefault();--}}
    {{--document.getElementById('logout-form').submit();">--}}
    {{--{{ __('Logout') }}--}}
    {{--</a>--}}

    {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
    {{--@csrf--}}
    {{--</form>--}}

    {{--<a href="{{ url('/home') }}">Home</a>--}}
    {{--@else--}}
    {{--<a href="{{ route('login') }}">Login</a>--}}

    {{--@if (Route::has('register'))--}}
    {{--<a href="{{ route('register') }}">Register</a>--}}
    {{--@endif--}}
    {{--@endauth--}}
    {{--</div>--}}
    {{--@endif--}}

    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="/">{{ Auth::user()->name }}</a>

                @if(Auth::user()->isDisabled())
                    <a href="{{ url('/') }}">Главная</a>
                @elseif(Auth::user()->isUser())
                    <a href="{{ url('/user/index') }}">Кабинет</a>
                @elseif(Auth::user()->isVisitor())
                    <a href="{{ url('/') }}">Главная</a>
                @elseif(Auth::user()->isAdministrator())
                    <a href="{{ url('/admin/index') }}">Панель администратора</a>
                @endif

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                {{--<a href="{{ url('/home') }}">Home</a>--}}
            @else
                <a href="{{ route('login') }}">Войти</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Регистрация</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel

        </div>

        <div class="links">
            <p>
                {{--@php--}}
                {{--dd(\App\Admin\Core\AdminApp::get_instance()->getProperty('pagination'));--}}
                {{--@endphp--}}
                {{--{{ dd($_ENV) }}--}}
                {{--{{ env('APP_KEY') }}--}}
            </p>
        </div>
    </div>
</div>
</body>
</html>
