@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Video "{{$video->title }}"</div>

                    <div class="panel-body">
                        <form action="/videos/{{ $video->uid}}" method="post">

                            <div class="form-group {{ $errors->has('title')? 'has-error' : '' }}">
                                <label for="title" >Title</label>
                                <input type="text"  name="title" id="title" class="form-control" value="{{ old('title') ? old('title') : $video->title }}"> 

                                @if($errors->has('title'))
                                    <span class="help-block">
                                        {{ $errors->first('title') }}
                                    <s/span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('description')? 'has-error' : '' }}">

                                <label for="description" >Description</label>
                                <textarea name="description" class="form-control" id="description">{{ old('description') ? old('description') : $video->description }} </textarea> 

                                @if($errors->has('title'))
                                    <span class="help-block">
                                        {{ $errors->first('title') }}
                                    <s/span>
                                @endif

                            </div>

                            <div class="form-group {{ $errors->has('description')? 'has-error' : '' }}">

                                <label for="visibilty" >Visibility</label>
                                <select name="visibility" id="visibility" class="form-control">  
                                    @foreach(['public', 'unlisted', 'private'] as $visibility)

                                        <option value="{{ $visibility }}"{{ $video->visibility == $visibility ? 'selected="selected"' : '' }}>{{ ucfirst($visibility) }}</option>

                                    @endforeach

                                </select> 

                                @if($errors->has('visibilty'))
                                    <span class="help-block">
                                        {{ $errors->first('visibilty') }}
                                    <s/span>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="allow_votes">
                                    <input type="checkbox" name="allow_votes" id="allow_votes"{{ $video->votesAllowed() ? 'checked="checked"' : ''}}>Allow votes
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="allow_comments">
                                    <input type="checkbox" name="allow_comments" id="allow_comments"{{ $video->votesAllowed() ? 'checked="checked"' : ''}}>Allow comments
                                </label>
                            </div>

                            <button type="submit" class="btn btn-default">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                        </form>

                	</div>
            	</div>
    	 	</div>
    	</div>
    </div>
@endsection
