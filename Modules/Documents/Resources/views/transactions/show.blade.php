@extends('layouts.master')
@section('title')
VIEW TRANSACTION 
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
			        <p><span class="label label-primary">Received</span></p>
			        @break			
			    @case('O')
			    	<p><span class="label label-success">Released</span></p>
			        @break
			@endswitch
		</div>
	</div>	

	<div class="well well-sm">
		<fieldset>
			<h4> DOCUMENT</h4>
			<!-- DOCTYPE -->
			<div class="row">
				<label class="control-label col-sm-2">Type:</label>
				<div class="col-sm-10">
					<p>{{ $transaction->document->doctype->name }}</p>
				</div>
			</div>
			<!-- DETAILS -->
			<div class="row">
				<label class="control-label col-sm-2">Details:</label>
				<div class="col-sm-4">
					<p>{{ $transaction->document->details }}</p>
				</div>
			</div>
			<!-- PERSONS CONCERNED -->
			<div class="row">
				<label class="control-label col-sm-2">Person(s) Concerned:</label>
				<div class="col-sm-10">
					<p>{{ $transaction->document->persons_concerned }}</p>
				</div>
			</div>
		</fieldset>
	</div>	
	<!-- OFFICE -->
	<div class="row">
		<label class="control-label col-sm-2">Office:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->target_office->name }}</p>
		</div>
	</div>
	<!-- DATE -->
	<div class="row">
		<label class="control-label col-sm-2">Date:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->date->toDateString() }}</p>
		</div>
	</div>	
	<!-- TIME -->
	<div class="row">
		<label class="control-label col-sm-2">Time:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->date->toTimeString() }}</p>
		</div>
	</div>	
	<!-- BY -->
	<div class="row">
		<label class="control-label col-sm-2">By:</label>
		<div class="col-sm-10">
			<p>{{ $transaction->by }}</p>
		</div>
	</div>	
	<br><br>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('transactions.index') }}" class="btn btn-flat btn-primary" role="button">Back</a>
		</div>
	</div>
</div>
@endsection
