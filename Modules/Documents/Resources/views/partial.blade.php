{{ csrf_field() }}
<!-- DOCTYPE -->
<div class="row">	
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group {{ $errors->has('doctype_id') ? 'has-error' : '' }}">		
			<label>Type<sup>*</sup></label>
			@component('documents::components.select2', ['field' => $document->doctype_id, 'name' => 'doctype_id', 'rows' => $doctypes])
			@slot('id')
			doctype_id			    
			@endslot
			@slot('prompt')
			a document type			    
			@endslot
			required autofocus
			@endcomponent		
		</div>
	</div>
</div>
<!-- END DOCTYPE -->
<!-- DETAILS -->
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
			<label for="inputDetails">Details<sup>*</sup></label>
			<textarea name="details" id="inputDetails" class="form-control" title="Details" rows="5" required>{{ $document->details ?? old('details') }}</textarea>
			@if ($errors->has('details')) 
			<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				{{ $errors->first('details') }}</p>
				@endif
			</div>
		</div>
	</div>
	<!-- END DETAILS-->
	<!-- PERSONS CONCERNED -->
	<div class="row">				
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group {{ $errors->has('persons_concerned') ? 'has-error' : '' }}">
				<label for="inputPersonsConcerned">Persons concerned<sup>*</sup></label>
				<textarea name="persons_concerned" id="inputPersonsConcerned" class="form-control" title="Persons concerned" rows="2" required>{{ $document->persons_concerned ?? old('persons_concerned') }}</textarea>
				@if ($errors->has('persons_concerned')) 
				<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					{{ $errors->first('persons_concerned') }}</p>
					@endif
				</div>
			</div>
		</div>
		<!-- END PERSONS CONCERNED -->
		<!-- ADDITIONAL INFO -->
		<div class="row">				
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group {{ $errors->has('additional_info') ? 'has-error' : '' }}">
					<label for="additional_info">Additional Information</label>
					<input type="text" name="additional_info" id="additional_info" class="form-control" title="Additional Info" value="{{ $document->additional_info ?? old('additional_info') }}">
					@if ($errors->has('additional_info')) 
					<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						{{ $errors->first('additional_info') }}</p>
						@endif
					</div>
				</div>
			</div>
			<!-- END ADDITIONAL INFO -->			
			@if (Route::currentRouteName() === 'documents.create')
			@include('documents::transactions.partial')
			@endif
			@if (Route::currentRouteName() === 'documents.edit')
			@include('documents::transactions.list')
			@endif
			<br><br>
			@include('includes.formbutton')
