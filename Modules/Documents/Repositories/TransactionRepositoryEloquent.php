<?php

namespace Modules\Documents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Documents\Entities\Transaction;
use Modules\Documents\Entities\Doctype;

define('ACTIVE_DISK', config('documents.active_disk'));
/**
 * Class TransactionRepositoryEloquent.
 *
 * @package namespace Modules\Documents\Repositories;
 */
class TransactionRepositoryEloquent extends BaseRepository implements TransactionRepository
{
    use \App\Http\Helpers\DateHelper;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'document.id',
        'document.doctype.name' => 'like',
        'document.details' => 'like',
        'document.persons_concerned' => 'like',
        'target_office.name' => 'like',
        'action' => 'like',
        'by' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app('\Modules\Documents\Criteria\DocumentRequestCriteria'));
    }

    public function getByOffice($id)
    {
        return $this->model->where('transactions.office_id', $id);
    }

    public function getByTask($task)
    {
        if (($task === 'I') || ($task === 'O')) {
            return $this->model->where('task', $task)->where('pending', 0);
        }
        if ($task === 'P') {
            return $this->model->where('pending', 1);
        }
        return $this->model;
    }

    public function getByDocument($id)
    {
        return $this->model->where('document_id', $id);
    }

    public function notPending()
    {
        return $this->model->where('pending', 0);
    }

    public function pending()
    {
        return $this->model->where('pending', 1);
    }

    public function latest()
    {
        return $this->model->latest('date');
    }

    public function store($request, $document_id, $doctype_id)
    {
        $date = $this->formatDates($request->task_date, $request->task_time);
        $office_id = auth()->user()->office_id;
        $by = config('documents.PENDING');
        $transaction = $this->create(array_merge(
            $request->only('task', 'from_to_office', 'action', 'action_to_be_taken'),
            ['date' => $date],
            ['office_id' => $office_id],
            ['document_id' => $document_id],
            ['doctype_id' => $doctype_id],
            ['by' => $request->by ?? $by],
            ['pending' => $request->pending ?? 0]
        ));
        $attachments = $this->addAttachments($transaction->id);
        // Create a new receive transaction if the destination office has registered users.
        if ($request->task === 'O') {
            $office = \Modules\Documents\Entities\Office::find($request->from_to_office);
            if ($office->users()->where('name', '<>', null)->count() >= 1) {
                $user = \Modules\Users\Entities\User::where('name', $transaction->by)->value('name');
                if (!empty($user)) {
                    $by = $user;
                }
                $received = [
                    'task' => 'I',
                    'document_id' => $transaction->document_id,
                    'doctype_id' => $transaction->doctype_id,
                    'from_to_office' => $office_id,
                    'date' => $transaction->date->addMinute(),
                    'action' => config('documents.PENDING'),
                    'action_to_be_taken' => $transaction->action_to_be_taken,
                    'by' => $by,
                    'office_id' => $transaction->from_to_office,
                    'pending' => 1,
                    'parent_id' => $transaction->id
                ];
                $new = $this->create($received);
                $new_attachments = $this->addAttachments($new->id);
            }
        }
        session()->forget('attachments');
        return collect($transaction)->merge($attachments);
    }

    protected function addAttachments($transactId)
    {
        if (session()->has('attachments')) {
            $attachments = session()->get('attachments');
            try {
                for ($i = 0; $i < count($attachments) ; $i++) {
                    $file = $attachments[$i]['filename'];
                    $path = $attachments[$i]['path'];
                    $url = $attachments[$i]['url'];
                    $a = new \Modules\Documents\Entities\Attachment;
                    $a->create(['transaction_id' => $transactId, 'filename' => $file, 'path' => $path, 'url' => $url, 'drive' => ACTIVE_DISK]);
                }
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
