<?php
namespace Modules\Documents\Transformers;
use League\Fractal\TransformerAbstract;
use Modules\Documents\Entities\Document;
use Modules\Users\Transformers\UserTransformer;
/**
 * Class DocumentTransformer.
 *
 * @package namespace Modules\Documents\Transformers;
 */
class DocumentTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'doctype',
        'office',
        'creator',
        'editor'
    ];
    public function __construct()
    {
        \Carbon\Carbon::setToStringFormat('M j, Y g:i A');
    }
    /**
     * Transform the Document entity.
     *
     * @param \Modules\Documents\Entities\Document $model
     *
     * @return array
     */
    public function transform(Document $model)
    {
        return [
            'id'            => (int) $model->id,
            'doctype'       => (string) $model->doctype->name,
            'doctype_id'    => (int) $model->doctype_id,
            'details'       => (string) $model->details,
            'persons_concerned' => (string) $model->persons_concerned,
            'office'        => (string) $model->office->name,
            'office_id'     => (int) $model->office_id,
            'creator'       => (string) $model->creator->name,
            'editor'        => (string) $model->editor->name,            
            'created_at'    => $model->created_at,
            'updated_at'    => $model->updated_at,
            'deleted_at'    => $model->deleted_at
        ];
    }
    public function includeDoctype(Document $model)
    {
        $doctype = $model->doctype;
        return $this->item($doctype, new DoctypeTransformer);
    }      
    public function includeOffice(Document $model)
    {
        $office = $model->office;
        return $this->item($office, new OfficeTransformer);
    }      
    public function includeCreator(Document $model)
    {
        $creator = $model->creator;
        return $this->item($creator, new UserTransformer);
    }    
    public function includeEditor(Document $model)
    {
        $editor = $model->editor;
        return $this->item($editor, new UserTransformer);
    }     
}
