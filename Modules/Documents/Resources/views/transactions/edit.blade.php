@extends('layouts.master')
@section('title')
EDIT TRANSACTION
@endsection
@section('content')
<div class="content">
	<form id="document-form" class="data-form" method="POST" role="form" action="{{ route('transactions.update', $transaction->id) }}" autocomplete>
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="hidden" id="document_id" name="document_id" value="{{ $transaction->document_id }}">
		@include('documents::transactions.partial')
		<br><br>
		<div class="row">
			<div class="col-sm-12">
				<fieldset>				
					<div class="form-group">
						{{-- <a href="{{ URL::previous() }}" class="btn btn-flat btn-primary">Back</a> --}}
						@component('documents::components.back')
						@endcomponent
						<button type="submit" class="btn btn-flat btn-primary">Save</button>
					</div>
				</fieldset>
			</div>
		</div>		
	</form>
</div>
@endsection		
