@extends('layouts.app')

@section('refresh')
{{-- <meta http-equiv="refresh" content="25"> --}}
@endsection

@section('notifications')
<li class="dropdown">
    <a href="#" class="dropdown-toggle notification_link notification_link" data-toggle="dropdown" role="button" aria-expanded="false">
        <i class="fa fa-bell" aria-hidden="true"></i><span class="caret"></span>
        @if(count($requests_users) > 0)
        <span class="badge">{{ count($requests_users) }}</span>
        @endif
    </a>

    <ul class="dropdown-menu" role="menu">
        @if(count($requests_users) > 0)
            <li class="dropdown-header">Friend Requests</li>
                <li role="separator" class="divider"></li>
                <li id="friend-request-dropdown">
                    <table id="friend-request-table">
                        @foreach($requests_users as $user)
                            <tbody>
                                <tr>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}: Accept Friend Request?</td>
                                    <td>
                                        {!! Form::open(['action' => ['UserController@acceptFriendRequest'], 'class' => 'btn-group']) !!}
                                            {!! Form::button('<i class="fa fa-check-square-o" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-default check-button']) !!}
                                            {{ Form::hidden('sender_id', $user->id) }}
                                        {!! Form::close() !!}

                                        {!! Form::open(['action' => ['UserController@denyFriendRequest'], 'class' => 'btn-group']) !!}
                                            {{ Form::hidden('sender_id', $user->id) }}
                                            {!! Form::button('<i class="fa fa-times-circle" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-default']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            </tbody>    
                        @endforeach
                    </table>
                </li>
            
        @else
            <li class="dropdown-header">No friend requests today.</li>
        @endif
    </ul>
</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(count($checked_in_profiles) < 1)
            <div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> Sorry, no one has checked into Sage :(
            </div>
                @if(!Auth::guest())
                    {!! Form::open(['action' => ['ProfileController@checkIn']{{-- , 'onsubmit' => 'return validateForm()' --}}]) !!}
                        {!! Form::button('Check In', ['class' => 'btn btn-success btn-block', 'id' => 'submitCheckInButton', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                @endif
            @else
            <div class="panel panel-default">
                    @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success:</strong> {{ Session::get('success') }}
                    </div>
                    @elseif (Session::has('warning'))
                    <div class="alert alert-warning" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong> {{ Session::get('warning') }}
                    </div>
                    @endif
                    
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if(count($checked_in_profiles) > 0)
                    <div class="table-responsive">
                        <table id="check-in-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Group(s)</th>
                                    <th>SagePoints</th>
                                    <th>Streak</th>
                                    <th>Last Seen</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checked_in_profiles as $profile)
                                <tr>
                                    <td>
                                        @if(!is_null($profile->image))
                                            {{-- <img src="//placehold.it/100" class="avatar img-circle" alt="avatar"> --}}
                                            <img src="{{ asset('/images/' . $profile->image) }}" style="width: 2.5rem; height: 2.5rem;" class="avatar img-circle" alt="avatar">
                                        @endif
                                    </td>
                                    <td>{{ $profile->user->first_name . ' ' . $profile->nickname . ' ' . $profile->user->last_name }}</td>
                                    <td>{{ implode(", ", unserialize($profile->groups)) }}</td>
                                    <td>{{ $profile->points . $profile->emoji }}</td>
                                    <td>{{ $profile->streak == 0 ? 0 : $profile->streak . '🔥'}}</td>
                                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($profile->checked_in))->diffForHumans() }}</td>
                                    <td>
                                        @if(!Auth::guest())
                                            @if($profile->user_id != Auth::id())
                                                @if(Auth::user()->checkHasSentFriendRequestTo($profile->user))
                                                Friend Request Sent
                                                @elseif(Auth::user()->checkHasFriendRequestFrom($profile->user))
                                                Accept FriendRequest?
                                                    {!! Form::open(['action' => ['UserController@acceptFriendRequest'], 'class' => 'btn-group']) !!}
                                                        {!! Form::button('<i class="fa fa-check-square-o" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-default check-button']) !!}
                                                        {{ Form::hidden('sender_id', $user->id) }}
                                                    {!! Form::close() !!}

                                                    {!! Form::open(['action' => ['UserController@denyFriendRequest'], 'class' => 'btn-group']) !!}
                                                        {{ Form::hidden('sender_id', $user->id) }}
                                                        {!! Form::button('<i class="fa fa-times-circle" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-default']) !!}
                                                    {!! Form::close() !!}
                                                @elseif(Auth::user()->checkisFriendWith($profile->user))
                                                    🙏Friends🙏
                                                @else
                                                {!! Form::open(['action' => ['UserController@befriend']]) !!}
                                                    {{ Form::hidden('id', $profile->user_id) }}

                                                    {!! Form::button('Friend <i class="fa fa-user-plus" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-success btn-block']) !!}
                                                {!! Form::close() !!}
                                                @endif
                                            @else
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(!Auth::guest())
                        {!! Form::open(['action' => ['ProfileController@checkIn'], 'onsubmit' => 'return validateForm()', 'id' => 'checkInForm']) !!}
                            {!! Form::button('Check In', ['class' => 'btn btn-success btn-block', 'id' => 'submitCheckInButton', 'type' => 'submit']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
{{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAntptXxN3Y8dbyhzIWh5vj3Lsh7jHyidQ&callback=initMap" type="text/javascript"></script> --}}
<script type="text/javascript">
    var lat = '';
    var lng = '';
    var locationFound = false;

    $(document).ready(function()
    {
        $('.notification_link').click(function()
        {
            $('.badge').hide();
        });

        
        var submitCheckInButton = document.getElementById('submitCheckInButton');
        $('button#submitCheckInButton').attr('disabled', 'disabled').html("<span class='fa fa-refresh glyphicon-refresh-animate'></span> Pending Location...");
        if(!(typeof sessionStorage.lat == "undefined") || !(typeof sessionStorage.lng == "undefined")) {
            $('button#submitCheckInButton').removeAttr('disabled').html("Check In");
        } else if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function positionSuccess(loc) {
                lat = loc.coords.latitude;
                lng = loc.coords.longitude;
                sessionStorage.lat = lat;
                sessionStorage.lng = lng;
                locationFound = true;
                $('button#submitCheckInButton').removeAttr('disabled').html("Check In");
            });
        } else {
            alert("I'm sorry, your browser doesn't support geolocation");
            locationFound = true;
            $('button#submitCheckInButton').removeAttr('disabled').html("Check In");
        }

    });

    function validateForm() {
        return getDistanceFromLatLonInKm(41.035888799999995, -73.57869889999999, sessionStorage.lat, sessionStorage.lng) < 0.25;
    }

    function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
        var R = 6371; // Radius of the earth in km
        var dLat = deg2rad(lat2-lat1);  // deg2rad below
        var dLon = deg2rad(lon2-lon1); 
        var a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2)
            ; 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c; // Distance in km
        return d;
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180)
    }
        
</script>
@endsection









































