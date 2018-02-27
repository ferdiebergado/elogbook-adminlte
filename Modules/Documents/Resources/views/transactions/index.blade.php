@extends('layouts.master')
@section('title')
TRANSACTIONS
@endsection
@section('subtitle')
	Received, Released, and Pending Transactions.
@endsection
@section('breadcrumb')
	@include('documents::includes.breadcrumbs.transactions')
@endsection
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
	<div class="table table-responsive">
		<table id="transactions-table" class="table table-hover table-striped table-condensed dataTable js-exportable" style="font-size: 1.3rem;"></table>
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
9
@endslot
@slot('ellipsiscol')
[3, 4]
@endslot
{
	name:   'document_id',
	title:  'Doc. No.',
	data:   'document.id'
},
{
	name:   'task',
	title:  'Status',
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
	title:  'Action Taken',
	data:   'action'
},
{
	name:   'action_to_be_taken',
	title:  'Action To Be Taken',
	data:   'action_to_be_taken'
},
{   
	title: 'Task(s)',
	data: 'id' 
}   
@endcomponent
@endpush    
