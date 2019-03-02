<div class="latest-vid-img-container">        
    <div class="vid-img">
        <img class="img-responsive" src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image">
        <a href="/videos/{{ $video->uid }}" class="play-icon play-small-icon">
            <img class="img-responsive play-svg svg" src="{{ asset('images/play-button.svg') }}" alt="play" onerror="this.src='images/play-button.png'">                        
        </a>
        <div class="overlay-div"></div>
    </div>
    <div class="vid-text">
        <p><span>By</span> <a href="channel/{{ $video->channel->slug }}">{{ $video->channel->name}}</a></p>
        <h1><a href="/videos/{{ $video->uid }}">{{ $video->title }} </a></h1>
        <p class="vid-info-text">
            <span>{{ $video->created_at->diffForHumans() }}</span>
            <span>&#47;</span>
            <span>{{ $video->viewCount() }} {{str_plural('view', $video->viewCount()) }}</span>
        </p>
    </div>
</div>