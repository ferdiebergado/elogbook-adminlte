<br><br>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<a href="{{ URL::previous() }}" class="btn btn-flat btn-primary"> Back</a>
			<button id="btnShowModal" class="btn btn-flat btn-primary"> Save</button>
		</div>
	</div>
</div>
<!-- modal -->
<div id="modalConfirm" class="modal modal-primary fade" id="modal-primary">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Confirm Save</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to save this?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
					<button id="btnSave" class="btn btn-outline">Save changes</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->	
