{{ csrf_field() }}
<!-- DOCTYPE -->
<div class="row">	
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group {{ $errors->has('doctype_id') ? 'has-error' : '' }}">		
			<label>Type<sup>*</sup></label>
			@component('documents::components.select2', ['field' => $document->doctype_id, 'name' => 'doctype_id', 'rows' => $doctypes])
			@slot('id')
			doctype_id			    
			@endslot
			@slot('prompt')
			a document type			    
			@endslot
			required
			@endcomponent		
		</div>
	</div>
</div>
<!-- END DOCTYPE -->
<!-- DETAILS -->
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
			<label for="inputDetails">Details<sup>*</sup></label>
			<textarea name="details" id="inputDetails" class="form-control" title="Details" rows="5" required>{{ isset($document->details) ? $document->details : old('details') }}</textarea>
			@if ($errors->has('details')) 
			<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				{{ $errors->first('details') }}</p>
				@endif
			</div>
		</div>
	</div>
	<!-- END DETAILS-->
	<!-- PERSONS CONCERNED -->
	<div class="row">				
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group {{ $errors->has('persons_concerned') ? 'has-error' : '' }}">
				<label for="inputPersonsConcerned">Persons concerned<sup>*</sup></label>
				<textarea name="persons_concerned" id="inputPersonsConcerned" class="form-control" title="Persons concerned" rows="2" required>{{ isset($document->persons_concerned) ? $document->persons_concerned : old('persons_concerned') }}</textarea>
				@if ($errors->has('persons_concerned')) 
				<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					{{ $errors->first('persons_concerned') }}</p>
					@endif
				</div>
			</div>
			<!-- END PERSONS CONCERNED -->
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="nav-tabs-custom">
					<ul id="documents-tab" class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#transaction"><b>Transaction</b></a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div id="receive" class="tab-pane fade in active">
						<fieldset>
							<div class="row">
								<!-- TASK -->
								<div class="col-sm-6">
									<div class="form-group {{ $errors->has('task') ? 'has-error' : '' }}">
										<label for="task">Task</label>										
										@component('documents::components.select', ['field' => $transaction->task, 'name' => 'task', 'array' => ['I' => 'Receive', 'O' => 'Release']])
										@slot('id')
										task
										@endslot
										@slot('prompt')
										a task												    
										@endslot
										required
										@endcomponent				
									</div>
								</div>							
								<!-- END TASK-->										
								<!-- FROM/TO OFFICE -->
								<div class="col-sm-6">
									<div class="form-group {{ $errors->has('from_to_office') ? 'has-error' : '' }}">
										<label id="label_from_to_office" for="from_to_office">Office</label>
										@component('documents::components.select2', ['field' => $transaction->from_to_office, 'name' => 'from_to_office', 'rows' => $offices])
										@slot('id')
										from_to_office
										@endslot
										@slot('prompt')
										an office
										@endslot
										required
										@endcomponent				
									</div>
								</div>							
								<!-- END FROM/TO OFFICE-->
							</div>
							<div class="row">
								<!-- DATE -->
								<div class="col-sm-6">
									<div class="form-group {{ $errors->has('task_date') ? 'has-error' : '' }}">
										<label>Date</label>		
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" name="task_date" class="form-control pull-right datepickr" id="task_date" value="{{ isset($transaction->date) ? $transaction->date->toDateString() : old('task_date')  }}" placeholder="Select a date">
										</div>
										<!-- /.input group -->
										@if ($errors->has('task_date')) 
										<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											{{ $errors->first('task_date') }}</p>
											@endif
										</div>
										<!-- /.form group -->
									</div>
									<!-- END DATE -->
									<!-- TIME -->
									<div class="col-sm-6">
										<div class="form-group {{ $errors->has('task_time') ? 'has-error' : '' }}">
											<label>Time</label>
											<div class="input-group">
												<input type="text" name="task_time" class="form-control timepickr" value="{{ isset($transaction->date) ? $transaction->date->toTimeString() : old('task_time') }}" placeholder="Set time">
												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
											<!-- /.input group -->
											@if ($errors->has('task_time')) 
											<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
												{{ $errors->first('task_time') }}</p>
												@endif		
											</div>
											<!-- /.form group -->
										</div>
										<!-- END TIME -->							
									</div>
									<div class="row">
										<!-- ACTION -->
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<div class="form-group {{ $errors->has('action') ? 'has-error' : '' }}">
												<label id="label_action" for="inputAction">Action</label>
												<textarea name="action" id="inputAction" class="form-control" title="Action" rows="2">{{ isset($transaction->action) ? $transaction->action : old('action') }}</textarea>
												@if ($errors->has('action')) 
												<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
													{{ $errors->first('action') }}</p>
													@endif
												</div>
											</div>
											<!-- END ACTION -->
											<!-- BY -->
											<div class="col-sm-6">
												<div class="form-group {{ $errors->has('by') ? 'has-error' : '' }}">
													<label id="label_by" for="inputBy">By</label>
													<input type="text" name="by" id="inputBy" class="form-control" value="{{ isset($transaction->by) ? $transaction->by : old('by') }}" title="By">
													@if ($errors->has('by')) 
													<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
														{{ $errors->first('by') }}</p>
														@endif
													</div>
												</div>
												<!-- END BY-->
											</div>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-sm-12">
								<fieldset>				
									<div class="form-group">
										<a href="{{ route('documents.index') }}" class="btn btn-flat btn-primary"> Back</a>
										<button type="submit" class="btn btn-flat btn-primary">Save</button>
									</div>
								</div>
							</div>
