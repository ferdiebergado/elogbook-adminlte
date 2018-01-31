@if (Session::has('message'))

	<div id="divAlertSuccess" class="alert alert-success alert-dismissible">

		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

		<span><i class="glyphicon glyphicon-check"></i> </span>

		{{ Session::get('message', 'The operation was successful.') }}

	</div>

@endif

@if (Session::has('errors') || Session::has('error'))

	<div id="divAlertError" class="alert alert-danger alert-dismissible">

		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

		<h4><i class="fa fa-ban"></i> Error: </h4>

		{{ Session::get('errors', Session::get('error')) }}

	</div>

@endif
