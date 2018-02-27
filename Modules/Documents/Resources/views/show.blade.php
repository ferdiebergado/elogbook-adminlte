@extends('layouts.master')
@section('title')
VIEW DOCUMENT 
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
	<br>
	{{-- <input type="hidden" id="document_id" name="document_id" value="{{ $document->id }}"> --}}
	@include('documents::transactions.list')
	<br><br>
	<div class="row">
		<div class="col-sm-12">
			@include('documents::includes.backbutton')
			<a href="{{ route('transactions.create', ['document_id' => $document->id]) }}" class="btn btn-flat btn-success pull-right" role="button">Add New Transaction</a>			
		</div>
	</div>
</div>
@endsection
