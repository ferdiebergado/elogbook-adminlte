@extends('layouts.master')
@section('title-icon')
<i class="fa fa-terminal"></i> 
@endsection
@section('title')
Artisan Console
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
	$(document).ready(function() {		
		$('#btnArtisanCommand').click(function(e) {
			var command = String($('#command').val().toLowerCase());
			e.preventDefault();
			$.post("{{ route('admin.run_command') }}", { "command" : command }, function(data) {
				$('#preArtisanOutput').html(data);
			});
			// if (typeof(Storage) !== "undefined") {
			// 	if (localStorage.itemcount) {
			// 	    localStorage.itemcount = Number(localStorage.itemcount) + 1;
			// 	} else {
			// 	    localStorage.itemcount = 1;
			// 	}
			// 	localStorage.setItem(localStorage.itemcount, command);
			// } else {
			//     console.log("Sorry! No Web Storage support.");
			// }			
			$('#command').val('');
		});
		// $('#command').keyup(function(event) {
		// 	const KEY_UP = 38;
		// 	const KEY_DOWN = 40;
		// 	var key = event.which || event.keyCode;
		// 	if (key == KEY_UP) {
		// 		console.log('Pressed Up key.');				
		// 	}
		// });
	});
</script>
@endpush
