<select class="form-control select2" id="{{ $id }}" name="{{ $id }}" {{ $slot }} style="width: 100%">
	<option value="">-- Select {{ $prompt }} --</option>
	@foreach ($rows as $row)
	<option value="{{ $row->id }}" 
		@isset ($field)
		@if ($field === $row->id)
		selected="selected"
		@endif
		@endisset
		@if (!empty(old($name)))
		@if (old($name) == $row->id)
		selected="selected"
		@endif
		@endif
		>{{ $row->name }}
	</option>
	@endforeach
</select>
@if ($errors->has($name)) 
<p class="help-block">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	{{ $errors->first($name) }}
</p>
@endif							
