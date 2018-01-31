@extends('layouts.master')

@section('title')
User Profile 
@endsection 

@section('content')

<div class="row">

	<div class="col-md-3">

		<!-- Profile Image -->
		<div class="box box-primary">
			<div class="box-body box-profile">
				<img id="avatar" class="profile-user-img img-responsive img-circle" src="{{ url('/storage/avatars') . '/' . $user->avatar }}" alt="User profile picture" title="Avatar (Click to change.)">

				<h3 class="profile-username text-center">{{ $user->name }}</h3>

				<p class="text-muted text-center">{{ $user->jobtitle }}</p>

				<ul class="list-group list-group-unbordered">
					<li class="list-group-item">
						<b>Received</b> <a class="pull-right">1,322</a>
					</li>
					<li class="list-group-item">
						<b>Released</b> <a class="pull-right">543</a>
					</li>
					<li class="list-group-item">
						<b>Total</b> <a class="pull-right">13,287</a>
					</li>
				</ul>

				<a id="change-password" href="#" class="btn btn-primary btn-block"><b>Change Password</b></a>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->

	</div>
	<!-- /.col -->
	<div class="col-md-9">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
				<li><a href="#timeline" data-toggle="tab">Timeline</a></li>
				<li><a href="#settings" data-toggle="tab">Account Details</a></li>
			</ul>
			<div class="tab-content">
				<div class="active tab-pane" id="activity">
					<!-- Post -->
					<div class="post">
						<div class="user-block">
							<img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
							<span class="username">
								<a href="#">Jonathan Burke Jr.</a>
								<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
							</span>
							<span class="description">Shared publicly - 7:30 PM today</span>
						</div>
						<!-- /.user-block -->
						<p>
							Lorem ipsum represents a long-held tradition for designers,
							typographers and the like. Some people hate it and argue for
							its demise, but others ignore the hate as they create awesome
							tools to help create filler text for everyone from bacon lovers
							to Charlie Sheen fans.
						</p>
						<ul class="list-inline">
							<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
							<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
							</li>
							<li class="pull-right">
								<a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
								(5)</a></li>
							</ul>

							<input class="form-control input-sm" type="text" placeholder="Type a comment">
						</div>
						<!-- /.post -->

						<!-- Post -->
						<div class="post clearfix">
							<div class="user-block">
								<img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
								<span class="username">
									<a href="#">Sarah Ross</a>
									<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
								</span>
								<span class="description">Sent you a message - 3 days ago</span>
							</div>
							<!-- /.user-block -->
							<p>
								Lorem ipsum represents a long-held tradition for designers,
								typographers and the like. Some people hate it and argue for
								its demise, but others ignore the hate as they create awesome
								tools to help create filler text for everyone from bacon lovers
								to Charlie Sheen fans.
							</p>

							<form class="form-horizontal">
								<div class="form-group margin-bottom-none">
									<div class="col-sm-9">
										<input class="form-control input-sm" placeholder="Response">
									</div>
									<div class="col-sm-3">
										<button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
									</div>
								</div>
							</form>
						</div>
						<!-- /.post -->

						<!-- Post -->
						<div class="post">
							<div class="user-block">
								<img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
								<span class="username">
									<a href="#">Adam Jones</a>
									<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
								</span>
								<span class="description">Posted 5 photos - 5 days ago</span>
							</div>
							<!-- /.user-block -->
							<div class="row margin-bottom">
								<div class="col-sm-6">
									<img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
								</div>
								<!-- /.col -->
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-6">
											<img class="img-responsive" src="../../dist/img/photo2.png" alt="Photo">
											<br>
											<img class="img-responsive" src="../../dist/img/photo3.jpg" alt="Photo">
										</div>
										<!-- /.col -->
										<div class="col-sm-6">
											<img class="img-responsive" src="../../dist/img/photo4.jpg" alt="Photo">
											<br>
											<img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
										</div>
										<!-- /.col -->
									</div>
									<!-- /.row -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->

							<ul class="list-inline">
								<li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
								<li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
								</li>
								<li class="pull-right">
									<a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
									(5)</a></li>
								</ul>

								<input class="form-control input-sm" type="text" placeholder="Type a comment">
							</div>
							<!-- /.post -->
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="timeline">
							<!-- The timeline -->
							<ul class="timeline timeline-inverse">
								<!-- timeline time label -->
								<li class="time-label">
									<span class="bg-red">
										10 Feb. 2014
									</span>
								</li>
								<!-- /.timeline-label -->
								<!-- timeline item -->
								<li>
									<i class="fa fa-envelope bg-blue"></i>

									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

										<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

										<div class="timeline-body">
											Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
											weebly ning heekya handango imeem plugg dopplr jibjab, movity
											jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
											quora plaxo ideeli hulu weebly balihoo...
										</div>
										<div class="timeline-footer">
											<a class="btn btn-primary btn-xs">Read more</a>
											<a class="btn btn-danger btn-xs">Delete</a>
										</div>
									</div>
								</li>
								<!-- END timeline item -->
								<!-- timeline item -->
								<li>
									<i class="fa fa-user bg-aqua"></i>

									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

										<h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
										</h3>
									</div>
								</li>
								<!-- END timeline item -->
								<!-- timeline item -->
								<li>
									<i class="fa fa-comments bg-yellow"></i>

									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

										<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

										<div class="timeline-body">
											Take me to your leader!
											Switzerland is small and neutral!
											We are more like Germany, ambitious and misunderstood!
										</div>
										<div class="timeline-footer">
											<a class="btn btn-warning btn-flat btn-xs">View comment</a>
										</div>
									</div>
								</li>
								<!-- END timeline item -->
								<!-- timeline time label -->
								<li class="time-label">
									<span class="bg-green">
										3 Jan. 2014
									</span>
								</li>
								<!-- /.timeline-label -->
								<!-- timeline item -->
								<li>
									<i class="fa fa-camera bg-purple"></i>

									<div class="timeline-item">
										<span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

										<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

										<div class="timeline-body">
											<img src="http://placehold.it/150x100" alt="..." class="margin">
											<img src="http://placehold.it/150x100" alt="..." class="margin">
											<img src="http://placehold.it/150x100" alt="..." class="margin">
											<img src="http://placehold.it/150x100" alt="..." class="margin">
										</div>
									</div>
								</li>
								<!-- END timeline item -->
								<li>
									<i class="fa fa-clock-o bg-gray"></i>
								</li>
							</ul>
						</div>
						<!-- /.tab-pane -->

						<div class="tab-pane" id="settings">
							<form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">

								{{ csrf_field() }}
								{{ method_field('PUT') }}

								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">Name</label>

									<div class="col-sm-10">
										<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">Email</label>

									<div class="col-sm-10">
										<input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}">
									</div>
								</div>
								<div class="form-group">
									<label for="jobtitle" class="col-sm-2 control-label">Job Title</label>

									<div class="col-sm-10">
										<input type="text" class="form-control" id="jobtitle"  name="jobtitle" placeholder="Job Title" value="{{ old('jobtitle', $user->jobtitle) }}">
									</div>
								</div>
								<div class="form-group">
									<label for="office_id" class="col-sm-2 control-label">Office</label>

									<div class="col-sm-10">
										<input type="text" class="form-control" id="office_id" name="office_id" placeholder="Office" value="{{ old('office_id', $user->office_id) }}">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-primary">Save</button>
									</div>
								</div>
							</form>
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
						<h4 class="modal-title">CHANGE AVATAR</h4>
					</div>

					<div class="modal-body">
						<form id="avatar-form" method="POST" action="{{ route('user.avatar', $user->id) }}" enctype="multipart/form-data">

							{{ csrf_field() }}

							<input id="input_userid" type="number" name="userid" value="{{ old('userid', $user->id) }}" hidden>

							<img id="avatar-preview" src="{{ $avatar }}" width="30%" height="30%">
							<br><br>
							<input id="avatar-input" type="file" name="avatar" accept="image/*" value="{{ old('avatar') }}" required></input>

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
						<h4 class="modal-title">CHANGE PASSWORD</h4>
					</div>

					<div class="modal-body">
						<form id="encryptableform" class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}" >

							{{ csrf_field() }}
							{{ method_field('PUT') }}							

								<div class="form-group">
									<label for="old_password" class="col-sm-4 control-label">Current Password</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="old_password" name="old_password" placeholder="Current Password" }}" required>
									</div>
								</div>

								<div class="form-group">
									<label for="password" class="col-sm-4 control-label">New Password</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="password" name="password" placeholder="New Password" }}" required>
									</div>
								</div>

								<div class="form-group">
									<label for="password_confirmation" class="col-sm-4 control-label">Confirm New Password</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm New Password" }}" required>
									</div>
								</div>
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</form>        
					</div>

				</div>

			</div>
		</div>	

		@endsection