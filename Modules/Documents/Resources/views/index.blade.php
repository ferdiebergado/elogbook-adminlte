@extends('layouts.master')

@section('title')

DOCUMENTS

@endsection

@section('content')

<div class="clearfix">
	
	<div class="col-sm-12">

		<a class="btn btn-success pull-right" href={{ route('documents.create') }} role="button" title="Create New Document">Create New</a>

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

{{-- doctype;office_from;office_to --}}
doctype

@endslot

@slot('datatabletargetcol')

7

@endslot

@slot('ellipsiscol')

2

@endslot

{
	name:   'id',
	title:  'Doc. No.',
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
	name:   'date_received',
	title:  'Date Received',
	data:   'date_received' 
},

{  
	name:   'received_by',
	title:  'Received By',
	data:   'received_by' 
},

{   
	name:   'date_released',
	title:  'Date Released',
	data:   'date_released' 
},

{   
	name:   'released_by',
	title:  'Released By',
	data:   'released_by' 
},

{   
	title: 'Actions(s)',
	data: 'id' 
}   

@endcomponent

@endpush    
