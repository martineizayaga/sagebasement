@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<h2>Most Sage Points</h2>
        	@if(count($profilePoints) < 1)
        	<div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> No one has Sage Points! Bad! :(
            </div>
            @else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<th>Name</th>
					<th>SagePoints</th>
				</thead>
				<tbody>
					@foreach($profilePoints as $profile)
						<tr>
							<td>{{ $profile->user->first_name . ' ' . $profile->nickname . ' ' . $profile->user->last_name }}</td>
							<td>{{ $profile->points . $profile->emoji }}</td>
						</tr>
					@endforeach
				</tbody>
				</table>
			@endif
			<h2>Highest Streak</h2>
			@if(count($profileStreaks) < 1)
			<div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> No current streaks! Sad! :(
            </div>
            @else
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<th>Name</th>
					<th>Streak</th>
				</thead>
				<tbody>
					@foreach($profileStreaks as $profile)
						<tr>
							<td>{{ $profile->user->first_name . ' ' . $profile->nickname . ' ' . $profile->user->last_name }}</td>
							<td>{{ $profile->streak . '🔥' }}</td>
						</tr>
					@endforeach
				</tbody>
				</table>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection