@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-default">
                <div class="panel-heading">Channel Setting</div>

                    <div class="panel-body">

                        <form action="/channel/{{ $channel->slug }}/edit" method="post" enctype="multipart/form-data">

                            <div class="form-group {{ $errors->has('name')? 'has-error' : '' }}">
                                <label for="name" >Name</label>
                                <input type="text"  name="name" id="name" class="form-control" value="{{ old('name') ? old('name') : $channel->name }}"> 

                                @if($errors->has('name'))
                                    <span class="help-block">
                                        {{ $errors->first('name') }}
                                    <s/span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('slug')? 'has-error' : '' }}">
                                <label for="slug" >Unique URL</label>

                                <div class="input-group">
                                    <div class="input-group-addon">http://localhost/</div>
                                    <input type="text"  name="slug" id="slug" class="form-control" value="{{ old('slug') ? old('slug') : $channel->slug }}"> 
                                </div>

                                @if($errors->has('slug'))
                                    <span class="help-block">
                                        {{ $errors->first('slug') }}
                                    <s/span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('description')? 'has-error' : '' }}">
                                <label for="description" >Description</label>
                                <textarea name="description" id="description" class="form-control">{{old('description') ? old('description') : $channel->description }}</textarea>

                                

                                @if($errors->has('description'))
                                    <span class="help-block">
                                        {{ $errors->first('description') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="image" >Channel image</label>
                                <input type="file" name="image" id="image">

                            </div>

                            <button class="btn btn-default" type="submit">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                        </form>

                    </div>
                
            </div>
        </div>

    </div>
    

</div>
@endsection