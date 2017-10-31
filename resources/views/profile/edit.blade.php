@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
            @if(!is_null($profile->image))
            {{-- <img src="//placehold.it/100" class="avatar img-circle" alt="avatar"> --}}
            <img src="{{ asset('/images/' . $profile->image) }}" class="avatar img-circle" alt="avatar">
            @endif
            <h6>Upload a different photo...</h6>
          
            {{ Form::file('profile_image', ['class' => 'form-control']) }}
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">

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

        <h3>Personal info</h3>
        
        {!! Form::open(['action' => ['ProfileController@update', Auth::id()], 'method' => 'put', 'class' => 'form-horizontal', 'files' => true]) !!}
          {{ Form::file('profile_image', ['class' => 'form-control', 'accept' => 'image/*']) }}
        	<div class="form-group">
				{{ Form::label('first_name', 'First name:', ['class' => 'col-lg-3 control-label']) }}
				<div class="col-lg-8">
					{{ Form::text('first_name', $profile->user->first_name, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('first_name', 'Nickname:', ['class' => 'col-lg-3 control-label']) }}
				<div class="col-lg-8">
					{{ Form::text('nickname', $profile->nickname, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('last_name', 'Last name:', ['class' => 'col-lg-3 control-label']) }}
				<div class="col-lg-8">
					{{ Form::text('last_name', $profile->user->last_name, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('groups', 'Group(s):', ['class' => 'col-lg-3 control-label']) }}
				<div class="col-lg-8">
					<label class="checkbox-inline"><input class="mutuallyexclusive" type="checkbox" value="Glee Club" name="groups[]" {{ in_array('Glee Club', unserialize($profile->groups)) ? 'checked' : '' }}>Glee Club</label>
	                <label class="checkbox-inline"><input class="mutuallyexclusive" type="checkbox" value="Chorus" name="groups[]" {{ in_array('Chorus', unserialize($profile->groups)) ? 'checked' : '' }}>Chorus</label>
	                <label class="checkbox-inline"><input type="checkbox" value="Chamber Singers" name="groups[]" {{ in_array('Chamber Singers', unserialize($profile->groups)) ? 'checked' : '' }}>Chamber Singers</label>
	                <label class="checkbox-inline"><input type="checkbox" value="Chorale" name="groups[]" {{ in_array('Chorale', unserialize($profile->groups)) ? 'checked' : '' }}>Chorale</label>
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('email', 'Email:', ['class' => 'col-lg-3 control-label']) }}
				<div class="col-lg-8">
					{{ Form::email('email', $profile->user->email, ['class' => 'form-control']) }}
				</div>
			</div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    {{ Form::submit('Save Changes', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" language="javascript">
$(document).ready(function(){
    $('.mutuallyexclusive').click(function() {
        $('.mutuallyexclusive').prop("checked", false);
        $(this).prop("checked", true);
    });
});
</script>


@endsection