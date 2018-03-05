@extends('layouts.master')
@section('title')
LOGIN
@endsection
@section('subtitle')
Sign-in for registered users.
@endsection
@section('content')
@if (session('confirmation-success'))
<div class="alert alert-success">
    {{ session('confirmation-success') }}
</div>
@endif
@if (session('confirmation-danger'))
<div class="alert alert-danger">
    {!! session('confirmation-danger') !!}
</div>
@endif
<form id="encryptableform" class="form-horizontal data-form" role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('email') ? ' has-error ' : '' }}">
        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-envelope"></i>
                </span>             
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="150" required autofocus>
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
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-sign-in"></i> Login
            </button>
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </div>
    </div>
</form>
@endsection
