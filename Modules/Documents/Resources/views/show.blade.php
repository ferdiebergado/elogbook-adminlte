@extends('layouts.master')
@section('title')
VIEW DOCUMENT 
@endsection
@section('content')
<div class="content">
	<!-- DOC. NO. -->
	<div class="row">
		<label class="control-label col-sm-2" >Doc. No.:</label>
		<div class="col-sm-10">
			<p><span class="label label-info">{{ $document->id }}</span></p>
		</div>
	</div>
	<!-- DOCTYPE -->
	<div class="row">
		<label class="control-label col-sm-2">Type:</label>
		<div class="col-sm-10">
			<p>{{ $document->doctype->name }}</p>
		</div>
	</div>
	<!-- DETAILS -->
	<div class="row">
		<label class="control-label col-sm-2">Details:</label>
		<div class="col-sm-4">
			<div class="well well-sm"><p>{{ $document->details }}</p></div>
		</div>
	</div>
	<!-- PERSONS CONCERNED -->
	<div class="row">
		<label class="control-label col-sm-2">Person(s) Concerned:</label>
		<div class="col-sm-10">
			<p>{{ $document->persons_concerned }}</p>
		</div>
	</div>
	<!--- ACTION TAKEN -->
	<div class="row">
		<label class="control-label col-sm-2">Action Taken:</label>
		<div class="col-sm-10">
			<p>{{ $document->action_taken }}</p>
		</div>
	</div>
	<br><br>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead class="bg-blue">
						<tr>
							<th class="text-center">Task</th>
							<th class="text-center">Date</th>
							<th class="text-center">From</th>
							<th class="text-center">To</th>
							<th class="text-center">By</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<tr>
							<td>Received</td>
							<td>{{ isset($document->date_received) ? $document->date_received->toFormattedDateString() : '' }}</td>
							<td>{{ $document->received_from }}</td>
							<td>{{ $document->received_to }}</td>
							<td>{{ $document->received_by }}</td>
						</tr>
						<tr>
							<td>Released</td>
							<td>{{ isset($document->date_released) ? $document->date_released->toFormattedDateString() : '' }}</td>
							<td>{{ $document->released_from }}</td>
							<td>{{ $document->released_to }}</td>
							<td>{{ $document->released_by }}</td>
						</tr>    			
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('documents.index') }}" class="btn btn-primary" role="button">Back</a>
		</div>
	</div>
</div>
@endsection