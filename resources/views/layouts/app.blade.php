
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Animals and nature</title>
    <meta name="description" content="Animals and nature videos">

    <script>
        window.pettube = {
            url:'{{ config('app.url') }}',
            user: {
                id: {{Auth::check() ? Auth::user()->id : 'null' }},
                authenticated: {{Auth::check() ? 'true' : 'false' }},
            }
        };
        window.pettube = {!! json_encode([
            'signedIn' => Auth::check(),
            'user' => Auth::user(),
        ]) !!};

    </script>
    <!-- Styles -->
    <link href="http://vjs.zencdn.net/6.2.8/video-js.css" rel="stylesheet">

      <!-- If you'd like to support IE8 -->
      <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <style>
        body {padding-bottom: 70px;}
        .level {display: flex; align-items: center;}
        .level-item {margin-right: 1em;}
        .flex { flex: 1; }
        .mr-1 { margin-right: 1em; }
        .ml-a { margin-left: auto; }
        [ v-cloak ] { display: none; }
        .ais-highlight > em { background: yellow; font-style:normal;}

    </style>
    @yield('header')
</head>
<body>
    <div id="app">
        
        @include ('layouts.partials._navigation')
            <div class="container">
                @include('layouts.partials._alerts')
            </div>
        @yield('content')

        <flash message="{{ session('flash') }}"></flash>

        @include('layouts.partials._footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
