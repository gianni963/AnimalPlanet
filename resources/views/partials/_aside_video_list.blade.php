<div class="sidebar-vid most-viewd">
    <h1 class="sidebar-heading">Dogs</h1>
     @if($lastDogsVideos->count())
        @foreach($lastDogsVideos as $video)
            <div class="most-viewd-container">
                <div class="most-viewd-img">
                    <img class="img-responsive" src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image">
                </div>
                <div class="most-viewd-text">
                    <h1><a href="/videos/{{ $video->uid }}">{{ $video->title }}</a></h1>
                    <p>
                        <span><i class="fa fa-eye"></i> {{ $video->viewCount() }}</span>
                    </p>
                </div>
            </div>
        @endforeach
    @endif
