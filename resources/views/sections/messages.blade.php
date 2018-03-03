@if (Session::has('message'))
	<div id="divAlertSuccess" class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span><i class="glyphicon glyphicon-check"></i> </span>
		{{ Session::get('message', 'The operation was successful.') }}
	</div>
@endif
@if ($errors->any())
	<div id="divAlertError" class="alert bg-maroon alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<h4><i class="fa fa-exclamation-triangle"></i> Error: </h4>
        {{ implode('', $errors->all(':message  ')) }}
	</div>
@endif
