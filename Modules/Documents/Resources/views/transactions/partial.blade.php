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
										<label id="label_action" for="inputAction">Action Taken<sup>*</sup></label>
										<textarea name="action" id="inputAction" class="form-control" title="Action" rows="2">{{ isset($transaction->action) ? $transaction->action : old('action') }}</textarea>
										@if ($errors->has('action')) 
										<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											{{ $errors->first('action') }}</p>
											@endif
										</div>
									</div>
									<!-- END ACTION -->
									<!-- ACTION TO BE TAKEN -->
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<div class="form-group {{ $errors->has('action_to_be_taken') ? 'has-error' : '' }}">
											<label id="label_action_to_be_taken" for="inputActionActionToBeTaken">Action To Be Taken</label>
											<textarea name="action_to_be_taken" id="inputActionToBeTaken" class="form-control" title="Action To Be Taken" rows="2">{{ isset($transaction->action_to_be_taken) ? $transaction->action_to_be_taken : old('action_to_taken') }}</textarea>
											@if ($errors->has('action_to_be_taken')) 
											<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
												{{ $errors->first('action_to_be_taken') }}</p>
												@endif
											</div>
										</div>
										<!-- END ACTION TO BE TAKEN -->									
									</div>
									<div class="row">										
										<!-- BY -->
										<div class="col-sm-6">
											<div class="form-group {{ $errors->has('by') ? 'has-error' : '' }}">
												<label id="label_by" for="inputBy">By</label>
												<input type="text" name="by" id="inputBy" class="form-control" value="{{ isset($transaction->by) ? $transaction->by : $transaction->by === '[Unspecified]' ? auth()->user()->name : old('by') }}" title="By">
												@if ($errors->has('by')) 
												<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
													{{ $errors->first('by') }}</p>
													@endif
												</div>
												<!-- END BY-->
											</div>
										</div>
										<input type="hidden" id="pending" name="pending" value="{{ isset($transaction->pending) ? $transaction->pending : old('pending') }}">
										<input type="hidden" id="document_id" name="document_id" value="{{ isset($transaction->document_id) ? $transaction->document_id : old('document_id') }}">	
										@if(Request::query('task') === 'I')
										<input type="hidden" id="release" name="release" value="true">				
										@endif															
									</fieldset>
								</div>
							</div>
						</div>
					</div>
