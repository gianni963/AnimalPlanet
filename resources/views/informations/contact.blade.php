@extends('layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-offset-3 col-sm-6">
			<h2>Contact</h2>
			<hr>
			<form action="{{ route('postContact') }}" method="POST" >
				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label name="email">Your email:</label>
					<input id="email" name="email" class="form-control">
					    @if ($errors->has('email'))
                            <span class="help-block">
                                     <strong>{{ $errors->first('email') }}</strong>
                               </span>
                        @endif
				</div>			

				<div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
					<label name="subject">Subject:</label>
					<input id="subject" name="subject" class="form-control">
					    @if ($errors->has('subject'))
                            <span class="help-block">
                                     <strong>{{ $errors->first('subject') }}</strong>
                               </span>
                        @endif					
				</div>

				<div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
					<label name="message">Message:</label>
					<textarea id="message" name="message" placeholer="write your message here" class="form-control"></textarea>
						@if ($errors->has('message'))
                            <span class="help-block">
                                     <strong>{{ $errors->first('emessge') }}</strong>
                               </span>
                        @endif
				</div>
				<input type="submit" value="Send Message">
				
			</form>
		</div>
	</div>

@endsection
