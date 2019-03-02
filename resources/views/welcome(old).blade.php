@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <strong>Lastest Videos</strong>
                    @if($lastestVideos->count())
                        @foreach($lastestVideos as $video)
                                <div class="well">
                                    @include('video.partials._video_result', [
                                        'video' => $video
                                    ])
                                </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
