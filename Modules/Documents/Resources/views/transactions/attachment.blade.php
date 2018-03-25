<!-- ATTACHMENT -->
<div class="container-fluid">	
	<div class="row">
		<form id="attachment-form" role="form">
			{{ csrf_field() }}
			<div class="form-group">
				<label id="lblAttachment" for="attachment">Attachment(s):</label>
				<p id="ajax-loader" style="display: none;">
					Uploading... 
					<img src="{{ url('/storage') . '/' . 'ajax-loader-square.gif' }}">				
				</p>
				<div class="input-group">					
					<input type="file" class="form-control" id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf" value="{{ old('attachment') }}" required>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-flat btn-default"><i class="fa fa-upload"></i> UPLOAD</button>
					</span>
				</div>
			</div>
		</form>
	</div>
</div>
@push('scripts')
<script>
	$(function() {
		$('#ajax-loader').hide();
		// function deleteAttachment(filename)
		// {
		// 	$.post('{{ route('attachments.delete') }}', { 'file': filename }, function(data, status) {

		// 	});	
		// }
		$("#attachment-form").submit(function(evt){	 
			evt.preventDefault();
			var formData = new FormData($(this)[0]);
			var foruploaded = $('#attachment').val();
			var file = foruploaded.split("\\");
			if (file.length) uploadedfile = file[file.length-1];   	
			$('#ajax-loader').show();
			var errorEl = $('#errorAttachment');
			if (errorEl) {
				errorEl.remove();
			}			
			$.ajax({
				url: '{{ route('attachments.store') }}',
				type: 'POST',
				data: formData,
				async: true,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
				success: function (response) {
					var uploaded = `<p><a href=\"${response.fileurl}\" target=\"_blank\">${uploadedfile}</a></p> <a href=\"\"><i class=\"fa fa-cross\" title=\"Remove\"></i></a>`;
					$('#ajax-loader').hide();
					if (response.message.attachment) {
						var message = `<p id=\"errorAttachment\" class=\"text-danger\"> ${response.message.attachment} </p>`;
						$('#lblAttachment').after(message);
					} else {
						$('#lblAttachment').after(uploaded);						
					}
					$('#attachment').val('');
				}
			});
			return false;
		}); 
	});
</script>	
@endpush
