<br><br>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<a href="{{ URL::previous() }}" class="btn btn-flat btn-primary"> Back</a>
			<button id="btnShowModal" type="button" class="btn btn-flat btn-primary"> Save</button>
		</div>
	</div>
</div>
<!-- modal -->
<div id="modalConfirm" class="modal modal-default fade" id="modal-primary">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><b>CONFIRMATION</b></h4>
				</div>
				<div class="modal-body">
					<h4><b>Are you sure you want to save this?</b></h4>
					<p class="help-block"><span class="label label-warning">CAUTION:</span> You can no longer undo this action once you continue.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Continue</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->	
