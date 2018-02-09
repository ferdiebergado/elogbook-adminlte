<select id="{{ $id }}" name="{{ $id }}" class="form-control" {{ $slot }}>
	<option value="">-- Select {{ $prompt }} --</option>
	@foreach ($array as $key => $value)
	<option value="{{ $key }}" 
		@isset ($field)
		@if ($field === $key)
		selected="selected"
		@endif
		@endisset
		@if (!empty(old($name)))
		@if (old($name) == $key)
		selected="selected"
		@endif
		@endif
		>{{ $value }}
	</option>
	@endforeach	
</select>