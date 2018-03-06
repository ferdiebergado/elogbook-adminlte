@extends('layouts.master')
@section('title')
Recent Activities
@endsection
@section('subtitle')
&nbsp;Activities related to Documents processed in this Office.
@endsection
@section('content')
<br>
<div class="row">	
	@forelse ($transactions as $transaction)
	<!-- /.col -->
	<div class="col-md-12">
		<!-- Box Comment -->
		<div class="box box-widget">
			<div class="box-header with-border">
				<div class="user-block">
					<img class="img-circle" src="{{ url('/storage/avatars') . '/' . ($transaction->task === 'I' ? $transaction->editor->avatar : $transaction->creator->avatar) }}" alt="User Image">
					<span class="username">{{ $transaction->task === 'I' ? $transaction->editor->name : $transaction->creator->name }}</span>
					<span class="description">{{ $transaction->task === 'I' ? 'Received' : 'Released' }} {{ $transaction->updated_at->diffForHumans() }}</span>
				</div>
				<!-- /.user-block -->
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<!-- post text -->
				<!-- Attachment -->
				<div class="attachment-block clearfix">
					{{-- <img class="attachment-img" src="../dist/img/photo1.png" alt="Attachment Image"> --}}
					<div class="attachment-pushed">
						<h4 class="attachment-heading"><a href="{{ route('documents.show', $transaction->document->id) }}">{{ $transaction->document->doctype->name }}</a></h4>
						<div class="attachment-text">
							{{ $transaction->document->details }}
						</div>
						<p><small>Person(s) Concerned: <b>{{ $transaction->document->persons_concerned }}</b></small></p>
						<!-- /.attachment-text -->
					</div>
					<!-- /.attachment-pushed -->
				</div>
				<!-- /.attachment-block -->
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer -->
{{-- 				<div class="box-footer">
</div> --}}
<!-- /.box-footer -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
@empty
<p>&nbsp;No activities to display.</p>
@endforelse
</div>
<div class="container-fluid">
	<div class="pull-right">		
		{{ $transactions->links() }}
	</div>
</div>
@endsection
