@extends('layouts.master')
@section('title')
TRANSACTIONS
@endsection
@section('content')
<div class="clearfix">	
	<div class="col-sm-12">
		<a class="btn btn-flat btn-success pull-right" href={{ route('transactions.create') }} role="button" title="Create New Transaction">Create New</a>
	</div>
</div>
<br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
	<div class="table-responsive">
		<table id="transactions-table" class="table table-hover table-condensed dataTable js-exportable" style="font-size: 1.3rem;"></table>
	</div>
</div>
@stop
@push('scripts')
@component('components.datatablejs')
@slot('datatableid')
transactions-table
@endslot
@slot('datatableroute')
{!! route('transactions.index', ['task' => Request::query('task') ])  !!}
@endslot
@slot('datatableurl')
{!! url('/transactions') !!}
@endslot
@slot('datatablewith')
@endslot
@slot('datatabletargetcol')
8
@endslot
@slot('ellipsiscol')
[3, 4]
@endslot
{
	name:   'id',
	title:  'Trans. No.',
	data:   'id'
},
{
	name:   'task',
	title:  'Task',
	data:   'task'
},
{   
	name:   'doctype_id',
	title:  'Type',
	data:   'document.doctype.name' 
},
{ 
	name:   'details',
	title:  'Details',
	data:   'document.details' 
},
{ 
	name:   'from_to_office',
	title:  'Office',
	data:   'target_office.name' 
},
{  
	name:   'date',
	title:  'Date/Time',
	data:   'date' 
},
{   
	name:   'by',
	title:  'By',
	data:   'by' 
},
{
	name:   'action',
	title:  'Action',
	data:   'action'
},
{   
	title: 'Actions(s)',
	data: 'id' 
}   
@endcomponent
@endpush    
