  <!-- Main Section -->
@if($lastestVideos->count()>= 3))
  <div id="main-section" class="main-v2">
    <div class="container-fluid">
      <div class="row overflow-hidden">
        <div class="col-sm-12">
          <div class="video-carousel">
             
            @if($lastestVideos->count())
              @foreach($carouselVideos as $video)
                      
                  @include('video.partials._carousel_videos_result', [
                      'video' => $video
                  ])

              @endforeach
            @endif
          </div>
        </div>                      
      </div>
    </div>
  </div>
@endif

  <!-- Main Section -->