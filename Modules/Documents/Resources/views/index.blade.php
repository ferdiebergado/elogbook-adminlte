@extends('layouts.master')
@section('title')
DOCUMENTS
@endsection
@section('subtitle')
Documents that originated from this Office.
@endsection
@section('breadcrumb')
@include('documents::includes.breadcrumbs.documents')
@endsection
@section('content')
<div class="clearfix">	
	<div class="col-sm-12">
		<a class="btn btn-flat btn-success pull-right" href={{ route('documents.create') }} role="button" title="Create New Document"><i class="fa fa-plus-circle"></i> CREATE NEW</a>
	</div>
</div>
<br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
	<div class="table-responsive">
		<table id="documents-table" class="table table-hover table-condensed dataTable js-exportable" style="font-size: 1.3rem;"></table>
	</div>
</div>
@stop
@push('scripts')
@component('components.datatablejs')
@slot('datatableid')
documents-table
@endslot
@slot('datatableroute')
{!! route('documents.index') !!}
@endslot
@slot('datatableurl')
{!! url('/documents') !!}
@endslot
@slot('datatablewith')
@endslot
@slot('datatabletargetcol')
6
@endslot
@slot('ellipsiscol')
2
@endslot
{
	name:   'id',
	title:  'No.',
	data:   'id'
},
{   
	name:   'doctype_id',
	title:  'Type',
	data:   'doctype.name' 
},
{ 
	name:   'details',
	title:  'Details',
	data:   'details' 
},
{ 
	name:   'persons_concerned',
	title:  'Persons Concerned',
	data:   'persons_concerned' 
},
{  
	name:   'created_at',
	title:  'Date Created',
	data:   'created_at' 
},
{   
	name:   'created_by',
	title:  'Created By',
	data:   'user.name' 
},
{   
	title: 'Task(s)',
	data: 'id' 
}   
@endcomponent
@endpush    
