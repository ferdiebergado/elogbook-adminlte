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
@if(! empty($phpinfo))
@foreach($phpinfo as $name => $section)
<h3 class="text-center bg-primary">{{ $name }}</h3>
<div class="table-responsive">
	<table class="table table-hover table-bordered ">
		@foreach($section as $key => $val)
		@if(is_array($val))
		<tr class="text-left"><td class="text-left">{{ $key }}</td><td class="text-left">{!! $val[0] !!}</td><td class="text-left">{!! $val[1] !!}</td></tr>
		@elseif(is_string($key))
		<tr class="text-left"><td class="text-left">{{ $key }}</td><td class="text-left">{!! $val !!}</td></tr>
		@else
		<tr class="text-left"><td class="text-left">{!! $val !!}</td></tr>
		@endif
		@endforeach
	</table>
</div>
@endforeach
@else
<h3>Sorry, the phpinfo() function is not accessable. Perhaps, it is disabled<a href='http://php.net/manual/en/function.phpinfo.php'>See the documentation.</a></h3>
@endif
</div>
@endsection
