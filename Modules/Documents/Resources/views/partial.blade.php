{{ csrf_field() }}

<!-- DOCTYPE -->
<div class="col-sm-6">

	<div class="form-group {{ $errors->has('doctype_id') ? 'has-error' : '' }}">			
		<label>Type<sup>*</sup></label>

		<select name="doctype_id" id="inputDoctype_id" class="form-control select2" required="required">
			<option value=""></option>
			@foreach ($doctypes as $type)
			<option value="{{ $type->id }}"  
				@isset($document->doctype_id)

				@if($document->doctype_id === $type->id)

				selected

				@endif

				@endisset

				@if (!empty(old('doctype_id')))
				@if (old('doctype_id') === $type->id)

				selected

				@endif
				@endif

				>{{ $type->name }}</option>
				@endforeach
			</select>

			@if ($errors->has('doctype_id')) 

			<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				{{ $errors->first('doctype_id') }}</p>

				@endif			

			</div>

		</div>
		<!-- END DOCTYPE -->

		<!-- DETAILS -->
		<div class="col-sm-12">

			<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">

				<label for="inputDetails">Details<sup>*</sup></label>

				<textarea name="details" id="inputDetails" class="form-control" title="Details" rows="5"> {{ isset($document->details) ? $document->details : old('details') }}</textarea>

				@if ($errors->has('details')) 

				<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					{{ $errors->first('details') }}</p>

					@endif

				</div>
			</div>
			<!-- END DETAILS-->

			<!-- PERSONS CONCERNED -->
			<div class="col-sm-6">

				<div class="form-group {{ $errors->has('persons_concerned') ? 'has-error' : '' }}">

					<label for="inputPersonsConcerned">Persons concerned<sup>*</sup></label>

					<textarea name="persons_concerned" id="inputPersonsConcerned" class="form-control" title="Persons concerned" rows="2">{{ isset($document->persons_concerned) ? $document->persons_concerned : old('persons_concerned') }}</textarea>

					@if ($errors->has('persons_concerned')) 

					<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						{{ $errors->first('persons_concerned') }}</p>

						@endif

					</div>
				</div>
				<!-- END PERSONS CONCERNED -->

				<!-- ACTION TAKEN -->
				<div class="col-sm-6">

					<div class="form-group {{ $errors->has('action_taken') ? 'has-error' : '' }}">

						<label for="inputActionTaken">Action taken<sup>*</sup></label>

						<textarea name="action_taken" id="inputActionTaken" class="form-control" title="Action taken" rows="2">{{ isset($document->action_taken) ? $document->action_taken : old('action_taken') }}</textarea>

						@if ($errors->has('action_taken')) 

						<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							{{ $errors->first('action_taken') }}</p>

							@endif

						</div>
					</div>
					<!-- END ACTION TAKEN -->

					<div class="col-sm-12">

						<div class="nav-tabs-custom">

							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#receive"><b>Received</b></a></li>
								<li><a data-toggle="tab" href="#release"><b>Released</b></a></li>
							</ul>

						</div>

						<div class="tab-content">
							<div id="receive" class="tab-pane fade in active">
								
								<fieldset>
									<div class="row">

										<!-- RECEIVED FROM -->
										<div class="col-sm-6">

											<div class="form-group {{ $errors->has('received_from') ? 'has-error' : '' }}">

												<label for="inputReceivedFrom">From (Office)</label>

												<input type="text" name="received_from" id="inputReceivedFrom" class="form-control" value="{{ isset($document->received_from) ? $document->received_from : old('received_from') }}" title="Received From (Office)">

												@if ($errors->has('received_from')) 

												<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
													{{ $errors->first('received_from') }}</p>

													@endif

												</div>
											</div>
											<!-- END RECEIVED FROM-->

											<!-- RECEIVED TO -->
											<div class="col-sm-6">

												<div class="form-group {{ $errors->has('received_to') ? 'has-error' : '' }}">

													<label for="inputReceivedTo">To (Office)</label>

													<input type="text" name="received_to" id="inputReceivedTo" class="form-control" value="{{ isset($document->received_to) ? $document->received_to : old('received_to') }}" title="Received To (Office)">

													@if ($errors->has('received_to')) 

													<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
														{{ $errors->first('received_to') }}</p>

														@endif

													</div>
												</div>
												<!-- END RECEIVED TO-->

											</div>
											<div class="row">
												
												<!-- DATE RECEIVED -->
												<div class="col-sm-6">

													<div class="form-group {{ $errors->has('received_date') ? 'has-error' : '' }}">
														<label>Date</label>

														<div class="input-group date">
															<div class="input-group-addon">
																<i class="fa fa-calendar"></i>
															</div>
															<input type="text" name="received_date" class="form-control pull-right" id="received_date" value="{{ isset($document->date_received) ? $document->date_received->toDateString() : old('received_date')  }}">
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

														<div class="bootstrap-timepicker">
															<div class="form-group {{ $errors->has('received_time') ? 'has-error' : '' }}">
																<label>Time</label>

																<div class="input-group">
																	<input type="text" name="received_time" class="form-control timepicker" value="{{ isset($document->date_received) ? $document->date_received->toTimeString() : old('received_time') }}">

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

														</div>
														<!-- END TIME RECEIVED -->							

													</div>
													<div class="row">
														
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
															
															<!-- RELEASED FROM -->
															<div class="col-sm-6">

																<div class="form-group {{ $errors->has('released_from') ? 'has-error' : '' }}">

																	<label for="inputReleasedFrom">From (Office)</label>

																	<input type="text" name="released_from" id="inputReleasedFrom" class="form-control" value="{{ isset($document->released_from) ?  $document->released_from : old('released_from') }}" title="Released From (Office)">

																	@if ($errors->has('released_from')) 

																	<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																		{{ $errors->first('released_from') }}</p>

																		@endif

																	</div>
																</div>
																<!-- END RELEASED FROM-->

																<!-- RELEASED TO -->
																<div class="col-sm-6">

																	<div class="form-group {{ $errors->has('released_to') ? 'has-error' : '' }}">

																		<label for="inputReleasedTo">To (Office)</label>

																		<input type="text" name="released_to" id="inputReleasedTo" class="form-control" value="{{ isset($document->released_to) ? $document->released_to : old('released_to') }}" title="Released To (Office)">

																		@if ($errors->has('released_to')) 

																		<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
																			{{ $errors->first('released_to') }}</p>

																			@endif

																		</div>
																	</div>
																	<!-- END RELEASED TO-->
																</div>
																<div class="row">
																	
																	<!-- DATE RELEASED -->
																	<div class="col-sm-6">

																		<div class="form-group {{ $errors->has('released_date') ? 'has-error' : '' }}">
																			<label>Date</label>

																			<div class="input-group date">
																				<div class="input-group-addon">
																					<i class="fa fa-calendar"></i>
																				</div>
																				<input type="text" name="released_date" class="form-control pull-right" id="released_date" value="{{ isset($document->date_released) ? $document->date_released->toDateString() : old('released_date') }}">
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
																			<div class="bootstrap-timepicker">
																				<div class="form-group {{ $errors->has('released_time') ? 'has-error' : '' }}">
																					<label>Time</label>

																					<div class="input-group">
																						<input type="text" name="released_time" class="form-control timepicker" value="{{ isset($document->date_released) ? $document->date_released->toTimeString() : old('released_time') }}">

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
																				<!-- /.form group -->
																			</div>
																			<!-- END TIME RECEIVED -->							

																		</div>
																		<div class="row">
																			
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
															<br><br>
															<div class="row">
																
																<div class="col-sm-12">
																	<fieldset>								
																		<div class="form-group">

																			<a href="{{ route('documents.index') }}" class="btn btn-primary"> Back</a>

																			<button type="submit" class="btn btn-primary">Save</button>

																		</div>
																	</div>

																</fieldset>

															</div>