<div class="row">
		<div class="col-sm-12">
			<label class="form-control-static">Transaction History:</label>
				<br><br>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-striped table-bordered" style="font-size: 1.3rem">
					<thead class="bg-blue">
						<tr>
							<th class="text-center">Trans. No.</th>
							<th class="text-center">Task</th>
							<th class="text-center">Date</th>
							<th class="text-center">From</th>
							<th class="text-center">Action Taken</th>
							<th class="text-center">To</th>
							<th class="text-center">Action To Be Taken</th>
							<th class="text-center">By/To</th>
							<th class="text-center">Status</th>
							@if ((Route::currentRouteName() === 'documents.edit') && (auth()->user()->role === 1))
							<th class="text-center">Action(s)</th>
							@endif
						</tr>
					</thead>
					<tbody class="text-center">
						@foreach ($transactions as $transaction)
						<tr>
							<td><span class="label label-info">{{ $transaction->id }}</span></td>
							<td><span class="label label-{{ $transaction->task === 'I' ? 'primary' : 'success' }}">{{ $transaction->task === 'O' ? 'Release' : 'Receive' }}</span></td>
							<td>{{ $transaction->date }}</td>
							<td>{{ $transaction->task === 'I' ? $transaction->target_office->name : $transaction->office->name }}</td>
							<td>{{ $transaction->action }}</td>
							<td>{{ $transaction->task === 'I' ? $transaction->office->name : $transaction->target_office->name }}</td>
							<td>{{ $transaction->action_to_be_taken }}</td>
							<td>{{ $transaction->by }}</td>
							<td><span class="label label-{{ $transaction->pending ? 'warning' : 'success' }}">{{ $transaction->pending ? 'Pending' : 'OK' }}</span></td>
							@if ((Route::currentRouteName() === 'documents.edit') && (auth()->user()->role === 1))
							<td><a class="btn btn-sm bg-maroon" href="{{ route('transactions.edit', $transaction->id) }}" role="button" title="Edit"><i class="fa fa-edit"></i></a></td>
							@endif
						</tr>
						@endforeach			
					</tbody>
				</table>
				<div class="pull-right">
				{{ $transactions->links() }}					
				</div>
			</div>
		</div>
	</div>
