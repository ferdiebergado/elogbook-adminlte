<?php
namespace Modules\Documents\Transformers;
use League\Fractal\TransformerAbstract;
use Modules\Documents\Entities\Transaction;
use Modules\Users\Entities\User;
use Modules\Users\Transformers\UserTransformer;
use Carbon\Carbon;
/**
 * Class TransactionTransformer.
 *
 * @package namespace Modules\Documents\Transformers;
 */
class TransactionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'document',
        'office',
        'targetOffice',
        'creator',
        'editor'
    ];
    /**
     * Transform the Transaction entity.
     *
     * @param \Modules\Documents\Entities\Transaction $model
     *
     * @return array
     */
    public function transform(Transaction $model)
    {
        return [
            'id'            => (int) $model->id,
            'task'          => (string) $model->task === 'I' ? 'Receive' : 'Release',
            'doctype'       => (string) $model->document->doctype->name,
            'details'       => (string) $model->document->details,
            'from_to_office' => (int) $model->from_to_office,
            'target_office' => (string) $model->target_office->name,
            'document_id'   => (int) $model->document_id,
            'fulldate'      => $model->date->format('M j, Y g:i A'),
            'date'          => $model->date->format('M j, Y'),
            'time'          => $model->date->format('g:i A'),
            'action'        => (string) $model->action,
            'action_to_be_taken' => (string) $model->action_to_be_taken,
            'by'            => (string) $model->by,
            'office'        => (string) $model->office->name,
            'office_id'     => (int) $model->office_id,
            'created_at'    => $model->created_at,
            'updated_at'    => $model->updated_at,
            'deleted_at'    => $model->deleted_at,
            'creator'       => (string) $model->creator->name,
            'editor'        => (string) $model->editor->name
        ];
    }
    public function includeDocument(Transaction $model)
    {
        $document = $model->document;
        return $this->item($document, new DocumentTransformer);
    }
    public function includeTargetOffice(Transaction $model)
    {
        $target_office = $model->target_office;
        return $this->item($target_office, new OfficeTransformer);
    }    
    public function includeOffice(Transaction $model)
    {
        $office = $model->office;
        return $this->item($office, new OfficeTransformer);
    }     
    public function includeCreator(Transaction $model)
    {
        $creator = $model->creator;
        return $this->item($creator, new UserTransformer);
    }    
    public function includeEditor(Transaction $model)
    {
        $editor = $model->editor;
        return $this->item($editor, new UserTransformer);
    }       
}
