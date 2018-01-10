@extends('layouts.app')

@section('content')
   
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6  user-wrapper">
            <div class="panel panel-default"> 
                <div class="panel-heading">
                     <h3>{{$user->name}}</h3>
                </div>

                <div class="panel-body">
                    <h4 class="title">Delete you account</h4>
                    <div class="content">
                        <form action="{{ route('profile.postDeleteAccount', $user) }}" method="post">                                
                               
                            <p> Do you want to delete your account?</p> 

                            <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Delete my account</button>
                                    </div>
                            </div>
                        <div class="clearfix"></div>

                            {{ csrf_field() }}
                               
                        </form>
                    </div>

                </div>
            </div>
        </div> 
    </div>
@endsection