@extends('layouts.master')
@section('title-icon')
<i class="fa fa-desktop"></i> 
@endsection
@section('title')
Application Environment
@endsection
@section('subtitle')
	Framework, Dependencies and Libraries
@endsection
@section('breadcrumb')
<li><i class="fa fa-desktop"></i> Application Environment</li>
@endsection
@section('content')
<h3>Framework</h3>
<div class="table-responsive">
	<table class="table table-hover table-striped">
		<tbody>
			@foreach ($envs as $env)
			<tr>
				<td>{{ $env['name'] }}</td>
				<td>{{ $env['value'] }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="row">
    <div class="col-sm-6">
        <h3> PHP Dependencies</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                @foreach($dependencies as $dependency => $version)
                <tr>
                    <td>{{ $dependency }}</td>
                    <td><span class="label label-primary">{{ $version }}</span></td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <div class="col-sm-6">
        <div class="table-responsive">        
            <h3> Javascript Libraries</h3>
            <table class="table table-striped">
                @foreach($packages as $package => $version)
                <tr>
                    <td>{{ $package }}</td>
                    <td><span class="label label-primary">{{ $version }}</span></td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>    
</div>
@endsection
