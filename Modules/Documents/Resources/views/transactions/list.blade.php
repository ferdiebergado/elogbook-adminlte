<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead class="bg-blue">
						<tr>
							<th class="text-center">Trans. No.</th>
							<th class="text-center">Task</th>
							<th class="text-center">Date</th>
							<th class="text-center">From/To</th>
							<th class="text-center">Action (to be) Taken</th>
							<th class="text-center">By</th>
							@if (Route::currentRouteName() === 'documents.edit')
							<th class="text-center">Action(s)</th>
							@endif
						</tr>
					</thead>
					<tbody class="text-center">
						@foreach ($document->transactions as $transaction)
						<tr>
							<td>{{ $transaction->id }}</td>
							<td>{{ $transaction->task === 'I' ? 'Receive' : $transaction->task === 'O' ? 'Released' : '' }}</td>
							<td>{{ $transaction->date }}</td>
							<td>{{ $transaction->target_office->name }}</td>
							<td>{{ $transaction->action }}</td>
							<td>{{ $transaction->by }}</td>
							@if (Route::currentRouteName() === 'documents.edit')
							<td><a class="btn btn-sm btn-warning" href="{{ route('transactions.edit', $transaction->id) }}" role="button" title="Edit"><i class="fa fa-edit"></i></a></td>
							@endif
						</tr>
						@endforeach			
					</tbody>
				</table>
			</div>
		</div>
	</div>
