@extends('layouts.master')

@section('title')

CREATE NEW DOCUMENT

@endsection

@section('content')

<div class="content">
	
	<form id="document-form" class="data-form" method="POST" role="form" action="{{ route('documents.store') }}">

		@include('documents::partial')

	</form>

</div>

@endsection 