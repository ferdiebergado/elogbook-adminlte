@extends('layouts.master')
@section('title')
CREATE NEW DOCUMENT
@endsection
@section('breadcrumb')
	@include('documents::includes.breadcrumbs.documents') 
	@include('documents::includes.breadcrumbs.create')
@endsection
@section('content')
<div class="content">	
	<form id="document-form" class="data-form" method="POST" role="form" action="{{ route('documents.store') }}" autocomplete>
		@include('documents::partial')
	</form>
</div>
@endsection 