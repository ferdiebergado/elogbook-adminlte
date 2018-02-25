@extends('layouts.master')
@section('title')
{{ (Route::currentRouteName() === 'transactions.receive') || (Route::currentRouteName() === 'transactions.receive') ? 'NEW' : 'EDIT' }} TRANSACTION
@endsection
@section('subtitle')
	Create or edit a transaction.
@endsection
@section('breadcrumb')
@include('documents::includes.breadcrumbs.transactions') 
@if ((Route::currentRouteName() === 'transactions.receive') || (Route::currentRouteName() === 'transactions.release'))
@include('documents::includes.breadcrumbs.create')
@else	
@include('documents::includes.breadcrumbs.edit')
@endif
@endsection
@section('content')
<div class="content">
	<form id="transaction-form" class="data-form" method="POST" role="form" action="{{ route('transactions.update', $transaction->id) }}" autocomplete>
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		@if ((Route::currentRouteName() === 'transactions.receive') || (Route::currentRouteName() === 'transactions.release'))
			@include('documents::transactions.document')
		@endif
		@include('documents::transactions.partial')	
	</form>
</div>
@endsection		
