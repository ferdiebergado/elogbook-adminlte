@extends('layouts.master')
@section('page-title')
User Profile
@endsection
@section('breadcrumb')
@include('users::includes.breadcrumbs.user')
@endsection
@section('title')
@yield('page-title')
@endsection 
@section('content')
<div class="row">
	<div class="col-md-3">
		<!-- Profile Image -->
		<div class="box box-primary">
			<div class="box-body box-profile">
				<img id="avatar" class="profile-user-img img-responsive img-circle" src="{{ $avatar }}" alt="User profile picture" title="Avatar (Click to change.)">
				<h3 class="profile-username text-center">{{ $user->name }}</h3>
				<p class="text-muted text-center">{{ $user->jobtitle->name }}</p>
				<p class="text-center"><small>Member since {{ $user->created_at->toFormattedDateString() }}</small></p>
				<ul class="list-group list-group-unbordered">
					<li class="list-group-item">
						<b>Received</b> <a class="pull-right"><span class="label label-primary">{{ $received }}</span></a>
					</li>
					<li class="list-group-item">
						<b>Released</b> <a class="pull-right"><span class="label label-success">{{ $released }}</span></a>
					</li>
					<li class="list-group-item">
						<b>Total</b> <a class="pull-right"><span class="label label-default">{{ $total }}</span></a>
					</li>
				</ul>
				<a id="change-password" href="#" class="btn btn-primary btn-block"><b><span><i class="fa fa-unlock-alt"></i></span> CHANGE PASSWORD</b></a>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
	<div class="col-md-9">
		<div class="nav-tabs-custom">
			<ul id="profile-tab" class="nav nav-tabs">
				{{-- 				<li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
				<li><a href="#timeline" data-toggle="tab">Timeline</a></li> --}}
				<li class="active"><a href="#account" data-toggle="tab">Account Details</a></li>
			</ul>
			<div class="tab-content">
				<!-- ACCOUNT DETAILS -->
				{{-- <div class="tab-pane {{ Route::currentRouteName() === 'users.edit' ? 'active' : '' }}" id="account"> --}}
					<div class="tab-pane active" id="account">
						<div class="container-fluid">						
							<form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}" autocomplete>
								{{ csrf_field() }}
								{{ method_field('PUT') }}
								@include('users::partial')
								<div class="row">										
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-flat btn-primary"><span><i class="fa fa-save"></i></span> SAVE</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- /.tab-pane -->
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<!-- Change Avatar Modal -->
	<div id="avatar-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><b><span><i class="fa fa-user"></i></span> CHANGE AVATAR</b></h4>
				</div>
				<div class="modal-body">
					<form id="avatar-form" method="POST" action="{{ route('user.avatar', $user->id) }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input id="input_userid" type="number" name="userid" value="{{ isset($user->id) ? $user->id : old('userid') }}" hidden>
						<img id="avatar-preview" src="{{ $avatar }}" width="30%" height="30%">
						<br><br>
						<input id="avatar-input" type="file" name="avatar" accept=".jpg,.jpeg,.png" value="{{ old('avatar') }}" required></input>
						<p class="help-block">Upload .jpeg, .jpg or .png files only. File size should be less than 500 kb.</p>
					</div>
					<div class="modal-footer">
						<button id="btnAvatar" type="submit" class="btn btn-primary"><span><i class="fa fa-save"></i></span> SAVE</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><span><i class="fa fa-ban"></i></span> Close</button>
					</form>        
				</div>
			</div>
		</div>
	</div>		
	<!-- Change Password Modal -->
	<div id="changepassword-modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><b><span><i class="fa fa-unlock-alt"></i></span> CHANGE PASSWORD</b></h4>
				</div>
				<div class="modal-body">
					<form id="encryptableform" class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}" >
						{{ csrf_field() }}
						{{ method_field('PUT') }}							
						<div class="form-group">
							<label for="old_password" class="col-sm-4 control-label">Current Password</label>
							<div class="col-sm-8">
								<div class="input-group">								
									<span class="input-group-addon">									
										<i class="fa fa-key"></i>
									</span>
									<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Current Password" }}" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-4 control-label">New Password</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">									
										<i class="fa fa-lock"></i>
									</span>								
									<input type="password" class="form-control" id="password" name="password" placeholder="New Password" }}" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="password_confirmation" class="col-sm-4 control-label">Confirm New Password</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">									
										<i class="fa fa-lock"></i>
									</span>								
									<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password" }}" required>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"><span><i class="fa fa-save"></i></span> SAVE</button>
						<button type="button" class="btn btn-default" data-dismiss="modal"><span><i class="fa fa-ban"></i></span> CLOSE</button>
					</form>        
				</div>
			</div>
		</div>
	</div>	
	@endsection
	