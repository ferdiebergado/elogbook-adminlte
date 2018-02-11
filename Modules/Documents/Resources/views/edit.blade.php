@extends('layouts.master')
@section('title')
EDIT DOCUMENT
@endsection
@section('content')
<div class="content">
	<form id="document-form" class="data-form" method="POST" role="form" action="{{ route('documents.update', $document->id) }}" autocomplete>
		{{ method_field('PUT') }}
		@include('documents::partial')
	</form>
</div>
@endsection 
