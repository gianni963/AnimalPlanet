<div class="item">
	<div class="vid-img-holder wow fadeInUp" data-wow-duration="0.5s">
	    <div class="top-shadow">
	          <span>{{ $video->created_at->diffForHumans() }}</span> 
	          <span>From <a href="{{ $video->channel->name}}"><i class="fa fa-youtube-play"></i></a></span>
	          <span><i class="fa fa-eye"></i> {{ $video->viewCount() }} </span>
	    </div>
	      <a href="/videos/{{ $video->uid }}">
	        <img class="img-responsive" src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image">
	        <span class="play-icon play-md-icon">
	            <img class="img-responsive play-svg svg" src="{{ asset('images/play-button.svg') }}" alt="play" onerror="this.src='images/play-button.png'">
	        </span>    
	      </a>  
	      <h3 class="vid-author">
	        <span>
	            By <a href="channel/{{ $video->channel->slug }}" title="Posts by" rel="author">{{ $video->channel->name}}</a>
	         </span>
	         
            <a href="videos/{{ $video->uid }}">
            	{{ $video->title }}
			</a>                    					               	       
	      </h3> 
	      <div class="bottom-shadow"></div>
	      <div class="overlay-div"></div>
	  </div>
</div>



<!-- <div class="row">
	<div class="col-sm-3">
		<a href="/videos/{{ $video->uid }}">
			<img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image" class="img-responsive">
		</a>
	</div>
	<div class="col-sm-9">
		<a href="/videos/{{ $video->uid }}">{{ $video->title}}</a>

		@if ($video->description)
			<p>{{ $video->description }}</p>
		@else
			<p class="muted">No description</p>
		@endif

		<ul class="list-inline">
			<li><a href="/channel/{{ $video->channel->slug }}">{{ $video->channel->name}}</a></li>
			<li>{{ $video->created_at->diffForHumans() }}</li>
			<li>{{ $video->viewCount() }} {{str_plural('view', $video->viewCount()) }}</li>
		</ul>

	</div>
</div> -->