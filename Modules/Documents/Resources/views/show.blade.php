@extends('layouts.master')

@section('title')

VIEW DOCUMENT 

@endsection

@section('content')

<div class="content">
	<label class="control-label col-sm-3" >Doc. No.:</label>
	<div class="col-sm-9">
		<p><span class="label label-info">{{ $document->id }}</span></p>
	</div>
	<label class="control-label col-sm-3">Type:</label>
	<div class="col-sm-9">
		<p>{{ $document->doctype->name }}</p>
	</div>
	<label class="control-label col-sm-3">Details:</label>
	<div class="col-sm-9">
		<div class="well well-sm"><p>{{ $document->details }}</p></div>
	</div>
	<label class="control-label col-sm-3">Person(s) Concerned:</label>
	<div class="col-sm-9">
		<p>{{ $document->persons_concerned }}</p>
	</div>
	<label class="control-label col-sm-3">Action Taken:</label>
	<div class="col-sm-9">
		<p>{{ $document->action_taken }}</p>
	</div>
	<div class="col-sm-12">

		<div class="table-responsive">
			<table class="table table-condensed table-bordered">
				<thead class="bg-orange">
					<tr>
						<th>Task</th>
						<th>Date</th>
						<th>From</th>
						<th>To</th>
						<th>By</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<tr>
						<td>Received</td>
						<td>{{ $document->date_received->toFormattedDateString() }}</td>

						<td>{{ $document->received_from }}</td>

						<td>{{ $document->received_to }}</td>
						<td>{{ $document->received_by }}</td>
					</tr>
					<tr>
						<td>Released</td>
						<td>{{ $document->date_released->toFormattedDateString() }}</td>

						<td>{{ $document->released_from }}</td>

						<td>{{ $document->released_to }}</td>
						<td>{{ $document->released_by }}</td>
					</tr>    			
				</tbody>
			</table>
		</div>
	</div>

<div class="col-sm-12">
	
	<a href="{{ URL::previous() }}" class="btn btn-primary" role="button">Back</a>
</div>

</div>

@endsection