<?php
namespace Modules\Documents\Http\Helpers;
use Modules\Documents\Repositories\TransactionRepository;
trait TransactionHelper
{
	public function storeTransaction($request, $document_id, $repository)
	{
		$date = $this->formatDates($request->task_date, $request->task_time);
		$office_id = auth()->user()->office_id;
		$by = config('documents.PENDING');
		$transaction = $repository->create(array_merge(
			$request->only('task', 'from_to_office', 'action', 'action_to_be_taken', 'pending'), 
			['date' => $date], 
			['office_id' => $office_id],
			['document_id' => $document_id], 
			['by' => !empty($request->by) ? $request->by : $by ]
		));
            // Create a new receive transaction if the destination office has registered users.
		if ($request->task === 'O') {
			$office = \Modules\Documents\Entities\Office::find($request->from_to_office);
			if ($office->users()->where('name', '<>', null)->count() >= 1) {                    
				$user = \Modules\Users\Entities\User::where('name', $transaction->by)->value('name');
				if (!empty($user)) {
					$by = $user;
				}
				$received = [
					'task'              =>  'I',
					'document_id'       =>  $transaction->document_id,
					'from_to_office'    =>  $office_id,
					'date'              =>  $transaction->date->addMinute(),
					'action'            =>  config('documents.PENDING'),
					'action_to_be_taken' => $transaction->action_to_be_taken,
					'by'                =>  $by,
					'office_id'         =>  $transaction->from_to_office,
					'pending'           =>  1
				];
				$repository->create($received);
			}
		}	
		return $transaction;
	}
}