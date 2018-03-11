@extends('layouts.master')
@section('title')
<i class="fa fa-server"></i> Server Info
@endsection
@section('subtitle')
	PHP Server Configuration
@endsection
@section('breadcrumb')
<li><i class="fa fa-server"></i> Server Info</li>
@endsection
@section('content')
<div class="table-responsive">
	@if(! empty($phpinfo))
	@foreach($phpinfo as $name => $section)
	<h3 class="text-center bg-primary">{{ $name }}</h3>
	<table class="table table-hover table-condensed table-striped table-bordered">
		@foreach($section as $key => $val)
		@if(is_array($val))
		<tr><td>{{ $key }}</td><td>{!! $val[0] !!}</td><td>{!! $val[1] !!}</td></tr>
		@elseif(is_string($key))
		<tr><td>{{ $key }}</td><td>{!! $val !!}</td></tr>
		@else
		<tr><td>{!! $val !!}</td></tr>
		@endif
		@endforeach
		@endforeach
	</table>
	@else
	<h3>Sorry, the phpinfo() function is not accessable. Perhaps, it is disabled<a href='http://php.net/manual/en/function.phpinfo.php'>See the documentation.</a></h3>
	@endif
</div>
</div>
@endsection
