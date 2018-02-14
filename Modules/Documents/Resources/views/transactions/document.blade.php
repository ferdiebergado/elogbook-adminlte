<h5><b>DOCUMENT</b></h5>
<!-- DOCTYPE -->
<div class="row">
	<label class="control-label col-sm-2">Type:</label>
	<div class="col-sm-5">
		<p>{{ $transaction->document->doctype->name }}</p>
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
<hr>
