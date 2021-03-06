<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'PettoTube') }}
                <small>Animals and nature</small>
            </a>

        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <form action="/search" method="get" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="q" class="form-control" placeholder="Search a video" value="{{ Request::get('q') }}">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                    <li><a  style="color:red; font-weight: bold" href="/forum/threads">Forum</a></li>
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else

                    <li><a href="{{ url('/upload') }}">Upload Video</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/videos') }} ">Your Videos</a>
                                <a href="{{ url('/channel/'. $channel->slug) }} ">Your channel</a>
                                <a href="{{ url('/channel/'. $channel->slug. '/edit') }}">Channel settings</a>
                                <a href="{{ url('/profile/') }}">Profile</a>
                                <a href="/forum/threads?by={{ auth()->user()->name }}">My Threads</a>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <user-notifications></user-notifications>
                @endif
            </ul>
        </div>
    </div>
</nav>