{{ csrf_field() }}
<!-- DOCTYPE -->
<div class="row">	
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="form-group {{ $errors->has('doctype_id') ? 'has-error' : '' }}">		
			<label>Type<sup>*</sup></label>
			@component('documents::components.select2', ['field' => $transaction->document()->doctype_id, 'name' => 'doctype_id', 'rows' => $doctypes])
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
										<!-- RECEIVED FROM -->
										<div class="col-sm-6">
											<div class="form-group {{ $errors->has('received_from') ? 'has-error' : '' }}">
												<label for="received_from">From</label>
												@component('documents::components.select2', ['field' => $transaction->received_from, 'name' => 'received_from'])
												@slot('id')
												received_from
												@endslot
												@endcomponent				
											</div>
										</div>							
										<!-- END RECEIVED FROM-->
									</div>
									<div class="row">
										<!-- DATE RECEIVED -->
										<div class="col-sm-6">
											<div class="form-group {{ $errors->has('received_date') ? 'has-error' : '' }}">
												<label>Date</label>		
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" name="received_date" class="form-control pull-right datepickr" id="received_date" value="{{ isset($document->date_received) ? $document->date_received->toDateString() : old('received_date')  }}" placeholder="Select a date">
												</div>
												<!-- /.input group -->
												@if ($errors->has('received_date')) 
												<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
													{{ $errors->first('received_date') }}</p>
													@endif
												</div>
												<!-- /.form group -->
											</div>
											<!-- END DATE RECEIVED -->
											<!-- TIME RECEIVED -->
											<div class="col-sm-6">
												<div class="form-group {{ $errors->has('received_time') ? 'has-error' : '' }}">
													<label>Time</label>
													<div class="input-group">
														<input type="text" name="received_time" class="form-control timepickr" value="{{ isset($document->date_received) ? $document->date_received->toTimeString() : old('received_time') }}" placeholder="Set time">
														<div class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</div>
													</div>
													<!-- /.input group -->
													@if ($errors->has('received_time')) 
													<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
														{{ $errors->first('received_time') }}</p>
														@endif		
													</div>
													<!-- /.form group -->
												</div>
												<!-- END TIME RECEIVED -->							
											</div>
											<div class="row">
												<!-- ACTION TO BE TAKEN -->
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group {{ $errors->has('action_to_be_taken') ? 'has-error' : '' }}">
														<label for="inputActionToBeTaken">Action to be taken</label>
														<textarea name="action_to_be_taken" id="inputActionToBeTaken" class="form-control" title="Action to be taken" rows="2">{{ isset($document->action_to_be_taken) ? $document->action_to_be_taken : old('action_to_be_taken') }}</textarea>
														@if ($errors->has('action_to_be_taken')) 
														<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
															{{ $errors->first('action_to_be_taken') }}</p>
															@endif
														</div>
													</div>
													<!-- END ACTION TO BE TAKEN -->
													<!-- RECEIVED BY -->
													<div class="col-sm-6">
														<div class="form-group {{ $errors->has('received_by') ? 'has-error' : '' }}">
															<label for="inputReceivedBy">By</label>
															<input type="text" name="received_by" id="inputReceivedBy" class="form-control" value="{{ isset($document->received_by) ? $document->received_by : old('received_by') }}" title="Received by">
															@if ($errors->has('received_by')) 
															<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																{{ $errors->first('received_by') }}</p>
																@endif
															</div>
														</div>
														<!-- END RECEIVED BY-->
													</div>
												</fieldset>
											</div>
											<div id="release" class="tab-pane fade">
												<fieldset>
													<div class="row">
														<!-- RELEASED TO -->
														<div class="col-sm-6">
															<div class="form-group {{ $errors->has('released_to') ? 'has-error' : '' }}">
																<label for="released_to">To</label>																		
																@component('documents::components.officeselect', ['field' => $document->released_to, 'name' => 'released_to'])
																@slot('id')
																released_to
																@endslot
																@endcomponent					
															</div>												
														</div>
														<!-- END RELEASED TO-->
													</div>
													<div class="row">
														<!-- DATE RELEASED -->
														<div class="col-sm-6">
															<div class="form-group {{ $errors->has('released_date') ? 'has-error' : '' }}">
																<label>Date</label>
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fa fa-calendar"></i>
																	</div>
																	<input type="text" name="released_date" class="form-control pull-right datepickr" id="released_date" value="{{ isset($document->date_released) ? $document->date_released->toDateString() : old('released_date') }}" placeholder="Select a date">
																</div>
																<!-- /.input group -->
																@if ($errors->has('released_date')) 
																<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																	{{ $errors->first('released_date') }}</p>
																	@endif		
																</div>
																<!-- /.form group -->
															</div>
															<!-- END DATE RELEASED -->
															<!-- TIME RELEASED -->
															<div class="col-sm-6">
																<div class="form-group {{ $errors->has('released_time') ? 'has-error' : '' }}">
																	<label>Time</label>
																	<div class="input-group">
																		<input type="text" name="released_time" class="form-control timepickr" value="{{ isset($document->date_released) ? $document->date_released->toTimeString() : old('released_time') }}" placeholder="Set time">
																		<div class="input-group-addon">
																			<i class="fa fa-clock-o"></i>
																		</div>
																	</div>
																	<!-- /.input group -->
																	@if ($errors->has('released_time')) 
																	<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																		{{ $errors->first('released_time') }}</p>
																		@endif		
																	</div>
																	<!-- /.form group -->
																</div>
																<!-- END TIME RECEIVED -->							
															</div>
															<div class="row">
																<!-- ACTION TAKEN -->
																<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
																	<div class="form-group {{ $errors->has('action_taken') ? 'has-error' : '' }}">
																		<label for="inputActionTaken">Action taken</label>
																		<textarea name="action_taken" id="inputActionTaken" class="form-control" title="Action taken" rows="2">{{ isset($document->action_taken) ? $document->action_taken : old('action_taken') }}</textarea>
																		@if ($errors->has('action_taken')) 
																		<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																			{{ $errors->first('action_taken') }}</p>
																			@endif
																		</div>
																	</div>
																	<!-- END ACTION TAKEN -->
																	<!-- RELEASED BY -->
																	<div class="col-sm-6">
																		<div class="form-group {{ $errors->has('released_by') ? 'has-error' : '' }}">
																			<label for="inputReleasedBy">By</label>
																			<input type="text" name="released_by" id="inputReleasedBy" class="form-control" value="{{ isset($document->released_by) ? $document->released_by : old('released_by') }}" title="Released by">
																			@if ($errors->has('released_by')) 
																			<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																				{{ $errors->first('released_by') }}</p>
																				@endif
																			</div>
																		</div>
																		<!-- END RELEASED BY-->
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
