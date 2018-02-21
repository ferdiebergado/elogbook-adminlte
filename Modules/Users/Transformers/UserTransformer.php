<?php

namespace Modules\Users\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Users\Entities\User;
use Modules\Documents\Transformers\OfficeTransformer;

/**
 * Class UserTransformer.
 *
 * @package namespace Modules\Documents\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'jobtitle',
        'office'
    ];
    /**
     * Transform the User entity.
     *
     * @param \Modules\Documents\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'        => (int) $model->id,
            'name'      => (string) $model->name,
            'jobtitle'  => (string) $model->jobtitle->name,
            'jobtitle_id' => (int) $model->jobtitle_id,
            'office'    => (string) $model->office->name,
            'office_id' => (int) $model->office_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
    public function includeJobtitle(User $model)
    {
        $jobtitle = $model->jobtitle;
        return $this->item($jobtitle, new JobtitleTransformer);
    }  
    public function includeOffice(User $model)
    {
        $office = $model->office;
        return $this->item($office, new OfficeTransformer);
    }      
}
