<!-- Main Bar-->
<div id="main-bar" class="main-bar-v2">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="logo">
					<a href="{{ url('/') }}">
						<img class="img-responsive" src="{{ asset('images/logo-blue.png') }}" alt="Logo">	
					</a>
				</div>					
			</div>

			<div style="padding-top: 20px" class="col-md-2 pull-right">
				@if (Auth::guest())
                
					<a  style="font-size: 18px;margin-right: 10px;" href="{{ route('login') }}">Login</a>
				
				
					<a  style="font-size: 18px;" href="{{ route('register') }}">Register</a>
				@else
                    <a style="font-size: 18px;" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                		{{ csrf_field() }}
                    </form>
				@endif
			</div>
		</div>
	</div>
</div>

	<!-- Main Bar -->



<!-- Main Navigation -->

<div id="navigation-w-search">
	<div id="main-navigation" class="nav-v2">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-12 col-xs-12 for-drop-search">
					<div id="cssmenu" class="cssmenu-v2">
						<ul>
						   <li><a href="{{ url('/') }}"><i class="fi ion-ios-home"></i>Home</a> </li>
						   <li><a href="/forum/threads"><i class="fi ion-android-apps"></i>Forum</a></li>
						   <li><a href="#">About</a></li>

						   	@if (!Auth::guest())
							  	<li><a href="{{ url('/upload') }}">Upload Video</a></li>
							  	<li><a href="#"><i class="fi ion-person"></i>{{ Auth::user()->name }}</a>
									<ul>

										<li><a href="{{ url('/videos') }} ">Your Videos</a></li>
										<li><a href="{{ url('/channel/'. $channel->slug) }} ">Your channel</a></li>
										<li><a href="{{ url('/channel/'. $channel->slug. '/edit') }}">Channel settings</a></li>
										<li><a href="{{ url('/profile/') }}">Profile</a></li>
										<li><a href="/forum/threads?by={{ auth()->user()->name }}">Your Threads</a></li>
									</ul>
							  	</li>
							<user-notifications></user-notifications>
							@endif
 
						</ul>
					</div>						
				</div>
					<div class="col-md-4 col-sm-12 col-xs-11">
            <form action="/search" method="get" class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" name="q" class="form-control" placeholder="Search a video" value="{{ Request::get('q') }}">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
					</div>					
			</div>
		</div>			
	</div>	
</div>

	<!-- Main Navigation -->