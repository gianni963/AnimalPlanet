@extends('layouts.app')
@section('content')

	<div class="row">
		<div class="col-sm-offset-3 col-sm-6">
			<h2>Contact</h2>
			<hr>
			<form action="{{ route('postContact') }}" method="POST" >
				{{ csrf_field() }}
				<div class="form-group">
					<label name="email">Your email:</label>
					<input id="email" name="email" class="form-control">
				</div>			

				<div class="form-group">
					<label name="subject">Subject:</label>
					<input id="subject" name="subject" class="form-control">
				</div>

				<div class="form-group">
					<label name="message">Message:</label>
					<textarea id="message" name="message" placeholer="write your message here" class="form-control"></textarea>
				</div>
				<input type="submit" value="Send Message">
			</form>
		</div>
	</div>

@endsection
