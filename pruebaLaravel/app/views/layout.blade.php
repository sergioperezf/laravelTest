<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <!--<link rel="stylesheet" href="/css/layout.css" />-->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <title>Prueba Laravel</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    </head>
    <body>
        @include("header")

        <div class="content">
            <div class="container">

                @if (Auth::check())
                <a href="{{ URL::route("user/logout") }}">
                    logout
                </a>
                @endif
                @if (isset($error))
                <div id="login-alert"  class="alert alert-danger col-sm-12">{{ $error }}</div>
                @endif
                @if (isset($success))
                <div id="login-alert"  class="alert alert-success col-sm-12">{{ $error }}</div>
                @endif
                @yield("content")
            </div>
        </div>
        @include("footer")

    </body>
</html>