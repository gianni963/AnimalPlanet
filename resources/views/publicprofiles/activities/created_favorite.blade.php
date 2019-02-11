@component('publicprofiles.activities.activity')

	@slot('heading')
			<a href="{{ $activity->subject->favorited->path() }}">
				{{$publicProfileUser->name}} favorited a reply.
			</a>
	@endslot

	@slot('body')
		{{ $activity->subject->favorited->body }}  
	@endslot

@endcomponent

