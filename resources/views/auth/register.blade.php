@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="i.e. Martín" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                            <label for="nickname" class="col-md-4 control-label">Nickname</label>

                            <div class="col-md-6">
                                <input id="nickname" type="text" class="form-control" name="nickname" value="{{ old('nickname') }}" pattern="\x22\s*(.*?)\s*\x22" title="Put nickname in between double quotes." placeholder="&quot;Hi! I'm the Sales Manager&quot;" required>
                                <em><small>Kind of like how we sign off our emails. And please use double quotes.</small></em>

                                @if ($errors->has('nickname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Eizayaga" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('groups') ? ' has-error' : '' }}">
                            <label for="groups" class="col-md-4 control-label">Groups</label>

                            <div class="col-md-6">
                                    <label class="checkbox-inline"><input class="mutuallyexclusive" type="checkbox" value="Glee Club" name="groups[]" {{ is_null(old('groups')) ? '' : (in_array('Glee Club', old('groups')) ? 'checked' : '' )}}>Glee Club</label>
                                    <label class="checkbox-inline"><input class="mutuallyexclusive" type="checkbox" value="Chorus" name="groups[]" {{ is_null(old('groups')) ? '' : (in_array('Chorus', old('groups')) ? 'checked' : '' )}}>Chorus</label>
                                    {{-- <label class="checkbox-inline"><input type="checkbox" value="Chamber Singers" name="groups[]" {{ is_null(old('groups')) ? '' : (in_array('Chamber Singers', old('groups')) ? 'checked' : '' )}}>Chamber Singers</label>
                                    <label class="checkbox-inline"><input type="checkbox" value="Chorale" name="groups[]" {{ is_null(old('groups')) ? '' : (in_array('Chorale', old('groups')) ? 'checked' : '' )}}>Chorale</label> --}}
                                    @if ($errors->has('groups'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('groups') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> --}}
<script type="text/javascript" language="javascript">
$(document).ready(function(){
    $('.mutuallyexclusive').click(function() {
        $('.mutuallyexclusive').prop("checked", false);
        $(this).prop("checked", true);
    });
});
</script>


@endsection