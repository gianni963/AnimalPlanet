@extends('layouts.app')

@section('header')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Thread</div>

                <div class="panel-body">
                    <form method="POST" action="/forum/threads">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="topic_id">Choose a Topic:</label>
                            <select name="topic_id" id="topic_id" class="form-control" required>
                                <option value="">Choose One...</option>

                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}">
                                        {{$topic->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title..." required>
                        </div>

                        <div class="form-group">
                            <label for="body">Description:</label>
                            <textarea name="body" id="body" class="form-control" rows="8" placeholder="This thread is about..." required>{{ old('body') }}</textarea>
                        </div>
                        <div class="form">
                            <div class="g-recaptcha" data-sitekey="6Lf8WXMUAAAAAANYhMgnhdtSjuhlN0cRd0P9sbmL"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>

                        @if (count($errors))
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif

                    </form>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection