<select class="form-control select2" id="{{ $id }}" name="{{ $id }}" {{ $slot }} style="width: 100%">
	<option value="">-- Select an office --</option>
	@foreach ($offices as $office)
	<option value="{{ $office->id }}" 
		@isset ($field)
		@if ($field === $office->id)
		selected="selected"
		@endif
		@endisset
		@if (!empty(old($name)))
		@if (old($name) == $office->id)
		selected="selected"
		@endif
		@endif
		>{{ $office->name }}
	</option>
	@endforeach
</select>
@if ($errors->has($name)) 
<p class="help-block">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	{{ $errors->first($name) }}
</p>
@endif							
