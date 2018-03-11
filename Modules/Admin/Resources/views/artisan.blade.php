@extends('layouts.master')
@section('title')
<i class="fa fa-terminal"></i> Artisan Console
@endsection
@section('subtitle')
Run artisan commands.
@endsection
@section('breadcrumb')
<li><i class="fa fa-list"></i> Commands</li>
@endsection
@section('content')
<form role="form">
	<div class="form-group">
		<label for="command">Command:</label>
		<div class="input-group">
			<input type="text" class="form-control" id="command" name="command" placeholder="Enter command here." autofocus>
			<span class="input-group-btn">			
				<button id="btnArtisanCommand" class="btn btn-primary"><i class="fa fa-level-up"></i></button>
			</span>
		</div>
	</div>
</form>
<label for="preArtisanOutput">Output:</label>
<pre id="preArtisanOutput" style="font-size: 1.2rem; background-color: light-gray; color: black;">NULL</pre>
@endsection
@push('scripts')
<script type="text/javascript">
	$('#btnArtisanCommand').click(function(e) {
		e.preventDefault();
		$.post("{{ route('admin.run_command') }}", { "command" : $('#command').val() }, function(data) {
			$('#preArtisanOutput').html(data);
		});
	});		
</script>
@endpush
