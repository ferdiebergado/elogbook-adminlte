@extends('layouts.master')
@section('title')
CREATE NEW TRANSACTION
@endsection
@section('breadcrumb')
	@include('documents::includes.breadcrumbs.transactions')
	@include('documents::includes.breadcrumbs.create')
@endsection
@section('content')
<div class="content">
	<form id="transaction-form" class="data-form" method="POST" role="form" action="{{ route('transactions.store') }}" autocomplete>
		{{ csrf_field() }}
		@include('documents::transactions.partial')
	</form>
</div>
@endsection 