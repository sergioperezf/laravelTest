@section("header")
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="//laravel.seperez.com">Prueba Laravel</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li>
                    <a href="//laravel.seperez.com">Home</a>
                </li>
                @if (Auth::check())
                <li>
                    <a href="{{ URL::route("user/profile") }}">Profile</a>
                </li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
@show