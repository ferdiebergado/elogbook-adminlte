@extends('layouts.master')
@section('title')
Active Offices
@endsection
@section('subtitle')
&nbsp;Offices where direct transaction (Receive/Release) is possible.
@endsection
@section('breadcrumb')
<li><i class="fa fa-building"></i> Offices</a></li>
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
						<ul><img src="{{ url('/storage/avatars') . '/' . $user->avatar }}" width="15%" height="15%" alt="User Avatar"> &nbsp;{{ $user->name }}</ul>
						@endif
						@endforeach
					</td>
				</tr>
				@empty
				<p>No active office.</p>
				@endforelse
			</tbody>
			{{ $active_offices->links() }}
		</table>
	</div>
</div>
@endsection
@section('box-footer')
@include('includes.backbutton')
@endsection
