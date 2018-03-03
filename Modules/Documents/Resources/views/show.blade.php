@extends('layouts.master')
@section('title')
VIEW DOCUMENT 
@endsection
@section('subtitle')
	View details of selected document.
@endsection
@section('breadcrumb')
@include('documents::includes.breadcrumbs.documents') 
@include('documents::includes.breadcrumbs.show')
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
			<p><span class="label label-primary">{{ $document->doctype->name }}</span></p>
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
	<!-- ADDITIONAL INFO -->
	<div class="row">
		<label class="control-label col-sm-2">Additional Information:</label>
		<div class="col-sm-10">
			<p>{{ $document->additional_info ?? 'None.' }}</p>
		</div>
	</div>	
	<!-- CREATED BY -->
	<div class="row">
		<label class="control-label col-sm-2">Created by:</label>
		<div class="col-sm-10">
			<p>{{ $document->creator->name }}</p>
		</div>
	</div>	
	<br>
	@include('documents::transactions.list')
	@section('box-footer')
	<a href="{{ route('transactions.create', ['document_id' => $document->id]) }}" class="btn btn-flat btn-success" role="button"><i class="fa fa-plus-circle"></i> ADD NEW TRANSACTION</a>			
	@endsection
</div>
@endsection
