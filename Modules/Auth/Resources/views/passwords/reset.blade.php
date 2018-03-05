@extends('layouts.master')
@section('title')
Reset Password
@endsection
@section('subtitle')
Enter new email and password.
@endsection
@section('content')
<form id="encryptableform" class="form-horizontal" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-envelope"></i>
                </span>             
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" maxlength="150" required autofocus>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-4 control-label">Password</label>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-key"></i>
                </span>             
                <input id="password" type="password" class="form-control" name="password" maxlength="150" required>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-key"></i>
                </span>             
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" maxlength="150" required>
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-unlock"></i> Reset Password
            </button>
        </div>
    </div>
</form>
@endsection
