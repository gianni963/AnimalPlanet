@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <data-tablechannel endpoint="{{ route('channels.index') }}"></data-table>
	 	</div>
	</div>
</div>
@endsection