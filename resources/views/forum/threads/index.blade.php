@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
        @if (Auth::check())
            <p><a href="/forum/threads/create">Create a New Thread</a></p>
        @endif
       <p>
            <a href="/forum/threads?popular=1">Most popular Threads All Time</a>&nbsp; &nbsp;    
            <a href="/forum/threads?unanswered=1">Unanswered Threads All Time</a>
            
        </p>
        </div>
        <div class="col-md-8">

           @include ('forum.threads._list')
           {{ $threads->render() }}
        </div>
        <div class="col-md-4">

            <div class="panel panel-default">
                    <div class="panel-heading">
                        Search in the forum section
                    </div>

                    <div class="panel-body">
                        <form method="GET" action="/forum/threads/search">
                            <div class="form-group">
                                <input type="text" placeholder="Search in the forum..." name="q" class="form-control">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

            @if(count($trending))
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Trending Threads
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ url($thread->path) }}">
                                        {{ $thread->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection