<div class="col-md-9 col-sm-8">
    <div class="latst-vid secondary-vid">
        <div class="vid-heading overflow-hidden">
            <span class="wow fadeInUp" data-wow-duration="0.8s">Latest videos</span>
            <div class="hding-bottm-line wow zoomIn" data-wow-duration="0.8s"></div>
        </div>
        <div class="row auto-clear">
            <div class="vid-container">
                @if($lastestVideos->count())
                    
                    @foreach($lastestVideos as $video)
                        <div class="col-md-4 col-sm-6">
                            @include('video.partials._video_element')
                                                                       
                         </div>
                    @endforeach
                    
                @endif

            </div>
        </div>
    </div>
    <div class="most-viewd secondary-vid">
        <div class="vid-heading overflow-hidden">
            <span class="wow fadeInUp" data-wow-duration="0.8s">Most Viewed Videos</span>
            <div class="hding-bottm-line wow zoomIn" data-wow-duration="0.8s"></div>
        </div>
        <div class="row">
            <div class="vid-container">

                @if($mostViewedVideos->count())
                    
                    @foreach($lastestVideos as $video)
                        <div class="col-md-4 col-sm-6">
                            @include('video.partials._video_element')
                                                                       
                         </div>
                    @endforeach
                    
                @endif
                                
            </div>
        </div>
    </div>
    @if($lastCatsVideos->count())
    <div class="sports secondary-vid">
        <div class="vid-heading overflow-hidden">
            <span class="wow fadeInUp" data-wow-duration="0.8s">Cats</span>
            <div class="hding-bottm-line wow zoomIn" data-wow-duration="0.8s"></div>
        </div>
        <div class="row">
            <div class="vid-container">

                
                    
                    @foreach($lastCatsVideos as $video)
                        <div class="col-md-6 col-sm-6">
                            @include('video.partials._video_element')
                                                                       
                         </div>
                    @endforeach
                    
                
                                                         
            </div>
        </div>
    </div>
    @endif
    
    @if($nature->count())
    <div class="hd secondary-vid">
        <div class="row">
            <div class="vid-container">
                <div class="col-sm-12">
                    <div class="threeD-videos">
                        <div class="vid-heading overflow-hidden">
                            <span class="wow fadeInUp" data-wow-duration="0.8s">Flora and nature</span>
                            <div class="hding-bottm-line wow zoomIn" data-wow-duration="0.8s"></div>
                        </div>
                        <div class="bottom-vid-img-container threeD-videos-container">
                            
                    
                            @foreach($nature as $video)
                                
                                    @include('video.partials._video_element_description')
                                                                           
                                 
                            @endforeach

                        </div>
                    </div>                                    
                </div>    
            </div>
        </div>
    </div>
    @endif
</div>