<select id="{{ $id }}" name="{{ $id }}" class="form-control" {{ $slot }}>
	<option value="">-- Select {{ $prompt }} --</option>
	@foreach ($array as $key => $value)
	<option value="{{ $key }}" 
		@if (!empty(old($name)))
			@if (old($name) === $key)
				selected="selected"
			@endif
		@endif	
		@isset ($field)
			@if ($field === $key)
				selected="selected"
			@endif
		@endisset
		>{{ $value }}
	</option>
	@endforeach	
</select>
@if ($errors->has($name)) 
<span class="help-block">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	{{ $errors->first($name) }}
</span>
@endif
