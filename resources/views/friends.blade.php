@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Friends</h2>
			@if(count($friends) < 1)
			<div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> You have no friends! Sad! :( Send a Friend Request :D
            </div>
            @else
			<div class="table-responsive">
				<table id="friend-table" class="table table-striped">
					<thead>
						<th>Name</th>
						<th>Points</th>
						<th>Streak</th>
						<th>Last Seen</th>
						<th style="text-align: center">Remove Friend</th>
					</thead>
					<tbody>
						@foreach($friends as $user)
							<tr>
								<td>{{ $user->getFullName() }}</td>
								<td>{{ $user->profile->points . $user->profile->emoji }}</td>
								<td>{{ $user->profile->streak . '🔥' }}</td>
								<td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($user->profile->checked_in))->diffForHumans() }}</td>
								<td>{!! Form::open(['action' => ['UserController@unfriend']]) !!}
                                        {{ Form::hidden('friend', $user->id) }}
                                        {!! Form::button('<i class="fa fa-times-circle" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-default']) !!}
                                    {!! Form::close() !!}
                                </td>
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