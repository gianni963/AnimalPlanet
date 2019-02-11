@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="page-header">
						<avatar-form :user="{{ $publicProfileUser }}"></avatar-form>
				</div>
				<strong>
					Channel associated: 
					<strong>
						<a href="/channel/{{$publicProfileUser->channel->first()->slug}}">{{ $publicProfileUser->channel->first()->name }}</a>
					</strong>
				</strong>
				<hr>

				@forelse ($activities as $date => $activity)
					<h3 class="page-header">{{ $date }}</h3>
					@foreach ($activity as $record)
						@if (view()->exists("publicprofiles.activities.{$record->type}"))
							@include ("publicprofiles.activities.{$record->type}", ['activity' => $record])
						@endif
					@endforeach
				@empty
					<p> There is no activity for this user</p>
				@endforelse

			 </div>
		</div>
	</div>

@endsection
