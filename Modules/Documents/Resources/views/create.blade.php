@extends('layouts.master')

@section('title')

CREATE NEW DOCUMENT

@endsection

@section('content')

<div class="container">
	
	<form id="document-form" method="POST" class="form-horizontal" role="form" action="{{ route('documents.store') }}">

		{{ csrf_field() }}

		<div class="form-group" {{ $errors->has('details') ? 'has-error' : '' }}>

			<label for="inputDetails" class="col-sm-2">Details</label>

			<div class="col-sm-10">
				
				<input type="text" name="details" id="inputDetails" class="form-control" value="{{ old('details') }}" title="Details">

				@if ($errors->has('details')) 

				<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					{{ $errors->first('details') }}</p>

					@endif

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-2 col-sm-offset-2">
					
					<a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
					
					<button type="submit" class="btn btn-primary">Save</button>

				</div>

		</div>

	</form>

</div>

@endsection 