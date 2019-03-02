<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title>Video</title>
	<meta name="viewport" content="initial-scale=1.0, width=device-width" />
	
	 <!-- CSRF Token -->    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

	<!-- Style Sheets -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<!-- Font Icons -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/ionicons.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/socicon-styles.css') }}">	
	<!-- Font Icons -->
	<link rel="stylesheet" href="{{ asset('css/hover-min.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/css-menu.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/loader.css') }}" />

	<link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
    <link href="https://vjs.zencdn.net/6.2.8/video-js.css" rel="stylesheet">

  <!-- If you'd like to support IE8 -->
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
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
</head>
<body id="index-v2">
	
		<div id="wrapper">
			<div id="main-content">
				<div id="app">

			 	@include ('layouts.partials._navigation')

		            <div class="container">
		                @include('layouts.partials._alerts')
		            </div>

		    	@yield('content')
		    	
		    	</div>
		    	
		    
		    @include('layouts.partials._footer')
		    </div>
		</div>

	
	<!-- Scripts -->
	<script src="{{ asset('js/wow.min.js') }}"></script>
	<script src="{{ asset('js/jquery-1.12.3.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/css-menu.js') }}"></script>
	<script src="{{ asset('js/jquery.validate.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>	


</body>
</html>