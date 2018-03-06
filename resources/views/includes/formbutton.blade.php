<!-- modal -->
<div id="modalConfirm" class="modal modal-default fade" id="modal-primary">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><b><span><i class="fa fa-question-circle"></i></span> CONFIRMATION</b></h4>
				</div>
				<div class="modal-body">
					<h4><b>Are you sure you want to save this?</b></h4>
					<p class="help-block"><span class="label label-warning">CAUTION:</span> You can no longer undo this action once you continue.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span><i class="fa fa-ban"></i></span> Close</button>
					<button type="submit" class="btn btn-primary"><b><span><i class="fa fa-check"></i></span> CONTINUE</b></button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->	
	@section('box-footer')
	<button id="btnShowModal" type="button" class="btn btn-flat btn-primary"><i class="fa fa-save"></i> SAVE</button>
	@endsection
