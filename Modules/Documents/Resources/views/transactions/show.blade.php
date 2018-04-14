@extends('layouts.master')
@section('title')
VIEW TRANSACTION 
@endsection
@section('breadcrumb')
@include('documents::includes.breadcrumbs.transactions')
@include('documents::includes.breadcrumbs.show')
@endsection
@section('content')
<div class="content">
	<!-- TRANS. NO. -->
	<div class="row">
		<label class="control-label col-sm-2" >Trans. No.:</label>
		<div class="col-sm-10">
			<p><span class="label label-info">{{ $transaction->id }}</span></p>
		</div>
	</div>
	<!-- TASK -->
	<div class="row">
		<label class="control-label col-sm-2">Task:</label>
		<div class="col-sm-10">
			@switch($transaction->task)
			@case('I')
			<p><span class="label label-primary">Receive</span></p>
			@break			
			@case('O')
			<p><span class="label label-success">Release</span></p>
			@break
			@endswitch
		</div>
	</div>	
	<hr>
	@include('documents::transactions.document')	
	<!-- FROM OFFICE -->
	<div class="row">
		<label class="control-label col-sm-2">{{ $transaction->task === 'I' ? 'From' : 'To' }}:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->target_office->name }}</p>
		</div>
	</div>
	<!-- TO OFFICE -->
	<div class="row">
		<label class="control-label col-sm-2">{{ $transaction->task === 'I' ? 'To' : 'From' }}</label>
		<div class="col-sm-10">
			<p>{{ $transaction->office->name }}</p>
		</div>
	</div>	
	<!-- DATE -->
	<div class="row">
		<label class="control-label col-sm-2">Date:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->date->toFormattedDateString() }}</p>
		</div>
	</div>	
	<!-- TIME -->
	<div class="row">
		<label class="control-label col-sm-2">Time:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->date->format('g:i A') }}</p>
		</div>
	</div>	
	<!-- ACTION TAKEN -->
	<div class="row">
		<label class="control-label col-sm-2">Action Taken:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->action }}</p>
		</div>
	</div>	
	<!-- ACTION TO BE TAKEN -->
	<div class="row">
		<label class="control-label col-sm-2">Action To Be Taken:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->action_to_be_taken }}</p>
		</div>
	</div>	
	<!-- STATUS -->
	<div class="row">
		<label class="control-label col-sm-2">Status:</label>
		<div class="col-sm-10">
			<p><span class="label label-{{ $transaction->pending ? 'warning' : 'success' }}">{{ $transaction->pending ? 'Pending' : 'OK' }}</p>
			</div>
		</div>	
		
		<!-- RECEIVED/RELEASED BY -->
		<div class="row">
			<label class="control-label col-sm-2">{{ $transaction->task === 'I' ? 'Received by' : 'Released to' }}:</label>
			<div class="col-sm-10">
				<p>{{ $transaction->by }}</p>
			</div>
		</div>	
		<!-- END RECEIVED/RELEASED BY -->

		<!-- RECEIVED BY -->
		{{--  <div class="row">
			<label class="control-label col-sm-2">{{ $transaction->task === 'I' ? 'Released' : 'Received' }} By:</label>
			<div class="col-sm-10">
				<p>{{ $transaction->task ==='I' ? $transaction->creator->name : $transaction->by }}</p>
			</div>
		</div>	  --}}
		<!-- ATTACHMENTS -->
		<div class="row">
			<label class="control-label col-sm-2">Attachment(s):</label>
			<div class="col-sm-10">			
				@forelse ($attachments as $attachment)
				<p><a href="{{ $attachment->url }}" target="_blank">{{ $attachment->filename }}</a></p>
				@empty
				No attachment.
				@endforelse	
			</div>
		</div>
	</div>
	@endsection
