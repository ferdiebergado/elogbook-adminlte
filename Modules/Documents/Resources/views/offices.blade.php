@extends('layouts.master')
@section('title')
Active Offices
@endsection
@section('subtitle')
Offices where direct transaction (Receive/Release) is possible.
@endsection
@section('breadcrumb')
<li><i class="fa fa-building"></i> Active Offices</a></li>
@endsection
@section('content')
<div class="container-fluid">
	<div class="table-responsive">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th>Bureau/Service</th>
					<th>Strand</th>
					<th>User(s)</th>
				</tr>
			</thead>
			<tbody>
				@forelse($active_offices as $office)
				<tr>
					<td><span class="label label-info">{{ $office->id }}</span></td>
					<td>{{ $office->name }}</td>
					<td>{{ $office->bureauservice->name }}</td>
					<td>{{ $office->strand->name }}</td>
					<td>
						@foreach ($office->users as $user)
						@if (($user->active) && ($user->confirmed))
						<div class="container-fluid">								
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-4">
								<img class="pull-left" src="{{ url('/storage/avatars') . '/' . $user->avatar }}" width="48px" height="48px" alt="User Avatar">
							</div> 
							<div class="col-xs-9 col-sm-9 col-md-10 col-lg-8">{{ $user->name }}</div>
						</div>
						@endif
						@endforeach
					</td>
				</tr>
				@empty
				<p>No active office.</p>
				@endforelse
			</tbody>
		</table>
	</div>
	<div class="container-fluid">
	<span class="pull-right">		
			{{ $active_offices->links() }}
	</span>		
	</div>
</div>
@endsection
