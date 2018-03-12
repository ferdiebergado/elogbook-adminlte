@extends('layouts.master')
@section('title')
Register
@endsection
@section('subtitle')
Sign-up for an account.
@endsection
@section('content')
@if (session('confirmation-success') && (!session()->has('errors')))
<div class="alert alert-success">
    {{ session('confirmation-success') }}
</div>
@else
<form id="encryptableform" class="form-horizontal data-form" role="form" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 control-label">Name</label>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>             
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" maxlength="50" required autofocus>
            </div>
            @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-envelope"></i>
                </span>             
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" maxlength="150" required>
            </div>
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
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-key"></i>
                </span>             
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" maxlength="150" required>
            </div>
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
            <div class="input-group">
                <span class="input-group-addon">                                    
                    <i class="fa fa-key"></i>
                </span>             
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" maxlength="150" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-user-plus"></i> Register
            </button>
        </div>
    </div>
</form>
@endif
@endsection
