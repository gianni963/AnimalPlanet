@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            @if ($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
                <div class="alert alert-info">
                    Your video is private. Only you can see it.
                </div>         
            @endif 

            @if ($video->isProcessed() && $video->canBeAccessed(Auth::user()))

                <video-player video-uid="{{ $video->uid }}" video-url="{{ $video->getStreamUrl() }}" thumbnail-url="{{ $video->getThumbnail() }}"></video-player>
                
            @endif

            @if(!$video->isProcessed())
               <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is stil processing.
                    </div>
                </div>
            @elseif(!$video->canBeAccessed(Auth::user()))   
               <div class="video-placeholder">
                    <div class="video-placeholder__header">
                        This video is private.
                    </div>
                </div>

            @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>{{ $video->title }} </h4>

                    <div class="pull-right">
                       <div class="video__view">
                           {{ $video->viewCount() }} {{str_plural('view', $video->viewCount()) }}
                       </div>
                       @if($video->votesAllowed())
                        <video-vote video-uid="{{ $video->uid }}"></video-vote>
                        @endif
                    </div>
            	

                    <div class="media">
                        <div class="media-left">
                            <a href="/channel/{{ $video->channel->slug }}">
                                <img src="{{ $video->channel->getImage() }}" alt="{{ $video->channel->name }} image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="/channel/{{$video->channel->slug}}" class="media-heading">{{ $video->channel->name}}</a>
                            <subscribe channel-slug="{{ $video->channel->slug }}"></subscribe>
                        </div>
                    </div>
                </div>
            </div>
                @if($video->description)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! nl2br(e($video->description)) !!}
                        </div>
                    </div>
                @endif

            <div class="panel panel-default">
                <div class="panel-body">
                    @if ($video->commentsAllowed())
                        <video-comments video-uid="{{ $video->uid }}"></video-comments>
                    @else
                        <p>Comments are disabled.</p>
                    @endif
                </div>
            </div>

	 	</div>
	</div>
</div>
@endsection