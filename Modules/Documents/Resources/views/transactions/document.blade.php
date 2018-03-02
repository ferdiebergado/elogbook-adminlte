<h4><b>DOCUMENT</b></h4>
<!-- DOCUMENT NO. -->
<div class="row">
	<label class="control-label col-sm-2">Document No:</label>
	<div class="col-sm-5">
		<p><span class="label label-primary">{{ $transaction->document->id }}</span></p>
	</div>
</div>
<!-- DOCTYPE -->
<div class="row">
	<label class="control-label col-sm-2">Type:</label>
	<div class="col-sm-5">
		<p><span class="label label-info">{{ $transaction->document->doctype->name }}</span></p>
	</div>
</div>
<!-- DETAILS -->
<div class="row">
	<label class="control-label col-sm-2">Details:</label>
	<div class="col-sm-5">
		<p>{{ $transaction->document->details }}</p>
	</div>
</div>
<!-- PERSONS CONCERNED -->
<div class="row">
	<label class="control-label col-sm-2">Person(s) Concerned:</label>
	<div class="col-sm-5">
		<p>{{ $transaction->document->persons_concerned }}</p>
	</div>
</div>
<!-- ADDITIONAL INFO -->
<div class="row">
	<label class="control-label col-sm-2">Additional Information:</label>
	<div class="col-sm-10">
		<p>{{ $transaction->document->additional_info }}</p>
	</div>
</div>	
<hr>
