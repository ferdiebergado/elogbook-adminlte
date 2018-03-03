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
								<label for="task">Task<sup>*</sup></label>	
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
								<label id="label_from_to_office" for="from_to_office">Office<sup>*</sup></label>
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
								<label>Date<sup>*</sup></label>		
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
									<label>Time<sup>*</sup></label>
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
								<datalist id="datalistActions">
									@for ($i = 0; $i < count($actions); $i++)
									<option value="{{ $actions[$i] }}">{{ $actions[$i] }}</option>
									@endfor
								</datalist>
								<!-- ACTION -->
								<div id="divAction" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group {{ $errors->has('action') ? 'has-error' : '' }}">
										<label id="label_action" for="inputAction">Action Taken (By this Office)<sup>*</sup></label>
										<input type="text" name="action" id="inputAction" class="form-control" title="Action" rows="2" placeholder="(Ex: Endorsed/Referred to the Chief/Director, Signed/Approved by the Chief/Director, Complied, Comments provided, etc.)" list="datalistActions" value="{{ $transaction->action ?? old('action') }}" required autocomplete>
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
											<label id="label_action_to_be_taken" for="inputActionActionToBeTaken">Action To Be Taken (By Destination Office)<sup>*</sup></label>
											<input type="text" name="action_to_be_taken" id="inputActionToBeTaken" class="form-control" title="Action To Be Taken" rows="2" placeholder="(Ex: For approval/signature/comments/compliance/processing/etc.)" value="{{  $transaction->action_to_be_taken ?? old('action_to_be_taken') }}" list="datalistActions" required autocomplete>
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
												<label id="label_by" for="inputBy">Received by/Released to</label>
												<datalist id="datalistUsers">
													@foreach ($users as $user)
													<option value="{{ $user->name }}">{{ $user->name }}</option>
													@endforeach													
												</datalist>
												<input type="text" name="by" id="inputBy" class="form-control" value="{{ $transaction->by ?? old('by') }}" title="By" placeholder="Name of Receiver/Releaser" list="datalistUsers" autocomplete>
												@if ($errors->has('by')) 
												<p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
													{{ $errors->first('by') }}</p>
													@endif
												</div>
												<!-- END BY-->
											</div>
										</div>
										<input type="hidden" id="pending" name="pending" value="{{ $transaction->pending ?? old('pending') }}">
										<input type="hidden" id="document_id" name="document_id" value="{{ $transaction->document_id ?? old('document_id') }}">
										@unless (Route::is('documents.*'))
										@include('includes.formbutton')
										@endunless
									</fieldset>
								</div>
							</div>
						</div>
					</div>
					@push('scripts')
					<script>
						$(function () {    
							var el = '#from_to_office';
							var by = '#inputBy';
							$(el).change(function() {
								$.get("{{ route('offices.showActive') }}", function(data, status) {
									var offices = data.toString().split(",");
									if (offices.indexOf($(el).val()) > -1) {
										$(by).val('(Pending)');
										$(by).attr('disabled', true);
										$(by).attr('required', false);
									} else {
										$(by).val('');
										$(by).attr('disabled', false);			
										$(by).attr('required', true);							
									}
								});
							});	
						});
					</script>
					@endpush
