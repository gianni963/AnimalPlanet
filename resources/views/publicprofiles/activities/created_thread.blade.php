@component('publicprofiles.activities.activity')

	@slot('heading')
		{{$publicProfileUser->name}} published 
			<a href= "{{ $activity->subject->path() }}">"{{ $activity->subject->title }}"</a>
	@endslot

	@slot('body')
		{{ $activity->subject->body }}  
	@endslot

@endcomponent



