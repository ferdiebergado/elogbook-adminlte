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
	$(function() {
		var i = 1;
    var fileId = 0; // used by the addFile() function to keep track of IDs
    function addElement(parentId, elementTag, elementId, html) {
        // Adds an element to the document
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.innerHTML = html;
        p.appendChild(newElement);
    }
    function removeElement(elementId) {
        // Removes an element from the document
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
    }    
    function addFile() {
        fileId++; // increment fileId to get a unique ID for the new element
        var html = '<input type="file" name="uploaded_files[]" /> ' +
        '<a href="" onclick="javascript:removeElement('file-' + fileId + ''); return false;">Remove</a>';
        addElement('files', 'p', 'file-' + fileId, html);
    }		
    $('#ajax-loader').hide();
		// function deleteAttachment(filename)
		// {
			{{-- // 	$.post('{{ route('attachments.delete') }}', { 'file': filename }, function(data, status) { --}}

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
					var uploaded = `<p><a href=\"${response.fileurl}\" target=\"_blank\">${uploadedfile}</a> &nbsp;&nbsp; <a id=\"uploaded${i}\" class=\"text-danger\" href=\"{{ route('attachments.delete') }}?path=${response.filepath}\" onclick=\"javascript:removeAttachment(this.id, ${response.filepath})\"><i class=\"fa fa-times\" title=\"Remove\"></i></a></p>`;
					$('#ajax-loader').hide();
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
