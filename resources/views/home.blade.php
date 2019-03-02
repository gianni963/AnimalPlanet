@extends ('layouts.app')

@section ('content')

<!-- Main Section -->

@include('partials._carousel')

<!-- Main Section -->

<!-- Secondary Section -->

<div id="secondary-section">
    <div class="container">
        <div class="row">
        @include('partials._videolist')


            <div class="col-md-3 col-sm-4">

                <div class="sidebar">
                    @if(count($trending))
                    <div class="sidebar-vid most-liked">
                        <h1 class="sidebar-heading">Trending Threads</h1>
                        @foreach($trending as $thread) 

                        <div class="media">
                            <div class="media-left">
 
                            </div>
                            <div class="media-body">
                                <h1><a href="{{ url($thread->path) }}">{{ $thread->title}}</a></h1>
                            </div>
                        </div>

                        @endforeach
                    @endif
                    </div>
                    @if($threads->count())
                    <div class="sidebar-vid most-liked">
                        <h1 class="sidebar-heading">Last Thread</h1>
                        @foreach($threads as $thread) 

                        <div class="media">
                            <div class="media-left">
                                <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="60" height="60" class="mr-1">
                            </div>
                            <div class="media-body">
                                <h1><a href="{{ $thread->path() }}">{{ $thread->title}}</a></h1>
                                <a href="{{ route('publicProfile', $thread->creator) }}">{{ $thread->creator->name}}</a>
                                <p>
                                    <span><i class="fa fa-comment"></i>  {{ $thread->replies_count }}</span>
                                    <span><i class="fa fa-eye"></i>{{ $thread->visits }}</span>
                                </p>
                            </div>
                        </div>

                        @endforeach

                    </div>
                    @endif
                    @include('partials._aside_video_list')

                
                </div>
        </div>
    </div>
</div>

@endsection

