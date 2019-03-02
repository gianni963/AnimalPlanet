<div class="row">
    <div class="bottom-vid">
        <div class="col-md-5 col-sm-9">
            <div class="bottom-vid-img">
                   <img class="img-responsive" src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image">
                   <a href="/videos/{{ $video->uid }}" class="play-icon play-small-icon">
                       <img class="img-responsive play-svg svg" src="{{ asset('images/play-button.svg') }}" alt="play" onerror="this.src='images/play-button.png'">
                   </a>
                <div class="overlay-div"></div>
            </div>    
        </div>
        <div class="col-md-7 col-sm-9">
            <div class="bottom-vid-text">
                <h1 class="sm-heading"><a href="/videos/{{ $video->uid }}">{{ $video->title }} </a></h1>
                <p class="border-bottom">
                    @if($video->description)

                        {!! nl2br(e($video->description)) !!}

                    @endif
                </p>
                <div class="hd-vid-info">
                    <p class="hd-vid-info-text text-right">
                        <span>{{ $video->created_at->diffForHumans() }}</span>
                        <span>&#47;</span>
                        <span>
                            From <a href="channel/{{ $video->channel->slug }}">{{ $video->channel->name}}</i></a>
                        </span>
                        <span>&#47;</span>
                        <span>{{ $video->viewCount() }} {{str_plural('view', $video->viewCount()) }}</span>
                    </p>
                </div>
            </div>    
        </div>
    </div>
</div>