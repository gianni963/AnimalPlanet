@extends('layouts.app')

@section('content')

           

     <!-- USER PROFILE ROW STARTS-->
        <div class="row" style="padding: 30px; margin-left: 70px;">

            
            <div class="col-md-9 col-sm-9">
                <div class="description">
                     <h3>{{$user->name}}</h3>
                <hr />
                 
                <div class="card">
                        <div class="header">
                            <h4 class="title">Edit your information</h4>
                        </div>
                        <div class="content">
                             <form action="{{ route('profile.update', $user) }}" method="post">                                
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('name')? 'has-error' : '' }}">
                                            <label for="name" class="control-label">Name:</label>
                                            <input type="text" class="form-control border-input" name="name" value="{{$user->name}}">
                                              @if($errors->has('name'))
                                                <span class="help-block">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group {{ $errors->has('email')? 'has-error' : '' }}">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control border-input"  value="{{$user->email}}">
                                             @if($errors->has('email'))
                                                    <span class="help-block">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                   <div class="col-md-3" style="padding-top: 25px;">
                                        <div class="text-center">
                                                <button type="submit" class="btn btn-info btn-fill btn-wd">Update profile</button>
                                        </div>
                                    </div>
         
                                </div>
                                <div class="clearfix"></div>


                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}


                            </form>


                            <div class="col-md-3 col-sm-3" style="padding-right:15px;">
                                   
                                 <div class="col-md-6">
                                    <div class="text-center">
                                        <a href="{{ route('profile.getDeleteAccount', $user) }}" class="btn btn-danger btn-sm"> &nbsp;Delete Account</a> 
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
             
            </div>
        </div>
       <!-- USER PROFILE ROW END-->
    </div>
@endsection