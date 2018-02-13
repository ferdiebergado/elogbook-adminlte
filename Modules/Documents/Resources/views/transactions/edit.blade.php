@extends('layouts.master')
@section('title')
EDIT TRANSACTION
@endsection
@section('content')
<div class="content">
	<form id="transaction-form" class="data-form" method="POST" role="form" action="{{ route('transactions.update', $transaction->id) }}" autocomplete>
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		@include('documents::transactions.partial')	
	</form>
</div>
@endsection		
