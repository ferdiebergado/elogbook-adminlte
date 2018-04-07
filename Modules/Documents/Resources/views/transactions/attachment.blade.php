<!-- ATTACHMENT -->
<div class="container-fluid">	
	<div class="row">
		<form id="attachment-form" role="form">
			{{ csrf_field() }}
			<div class="form-group">
				<label id="lblAttachment" for="attachment">Attachment(s):</label>
				@if ($errors->any())
				@if (Session::has('attachments'))
				@php $attachments = session()->get('attachments');
				for ($i = 0; $i < count($attachments) ; $i++) {
				 $file=$attachments[$i]['filename']; 
				 $path=$attachments[$i]['path']; 
				 $url=$attachments[$i]['url']; 
				 echo "<p><a href='" . $url . "'>" . $file . "</a></p>";
				}
				@endphp					
				@endif
				@endif
				<p id="ajax-loader" style="display: none;">
					Processing... 
					<img src="{{ url('/storage') . '/' . 'ajax-loader-square.gif' }}">				
				</p>
				<div id="divFiles" class="input-group">					
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
	var loader = $('#ajax-loader');
	var removeAttachment = function (elementId, filepath) {
		var elm = $("#divFiles");
		loader.show();
		$('#uploaded' + elementId).replaceWith(loader);
		$('#uploadRemove' + elementId).replaceWith(elm);
		$.post('{{ route('attachments.delete') }}', {'path': filepath}, function(data, textStatus, jqXHR) {
			loader.hide();
			return data;
		});
	}    	
	$(function() {
		var i = 1;	
		loader.hide();
		$("#attachment-form").submit(function(evt){	 
			evt.preventDefault();
			var formData = new FormData($(this)[0]);
			var foruploaded = $('#attachment').val();
			var file = foruploaded.split("\\");
			if (file.length) uploadedfile = file[file.length-1];   	
			loader.show();
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
					var uploaded = `<p><a id=\"uploaded${i}\" href=\"${response.fileurl}\" target=\"_blank\">${uploadedfile}</a> &nbsp;&nbsp; <a id=\"uploadRemove${i}\" class=\"text-danger\" onclick=\"removeAttachment(${i},\'` + response.filepath + `\'); return false;\"><i class=\"fa fa-times\" title=\"Remove\"></i></a></p>`;
					loader.hide();
					if (response.message.attachment) {
						var message = `<p id=\"errorAttachment\" class=\"text-danger\"> ${response.message.attachment} </p>`;
						$('#lblAttachment').after(message);
					} else {
						$('#lblAttachment').after(uploaded);						
					}
					$('#attachment').val('');
					i++;
				}
			});
			return false;
		}); 
	});
</script>	
@endpush
